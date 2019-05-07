/*
-- 新闻发布系统
-- 数据库基本结构创建
-- author: iwen
-- date: 19/04/25
-- database: news_system 
*/


DROP DATABASE if EXISTS news_system;
CREATE DATABASE if not EXISTS news_system;

use news_system;

CREATE table if not exists news(
    id int unsigned auto_increment, /* 这个是primary key */
    n_id VARCHAR(20) not null,
    n_date varchar(12) ,
    n_title varchar(100) ,
    n_content TEXT,
    n_user_id varchar(20) not null,
    n_tag varchar(20) not null,
    primary key(id),
    unique key(n_id)
);
 /* 触发器 -->default unix_timestamp(now()) */

CREATE table if not exists tag(
    id int unsigned auto_increment,
    t_id varchar(20) not null,
    t_name varchar(20) not null,
    primary key(id),
    unique key(t_id)
);

CREATE table if not exists favorite(
    id int unsigned auto_increment,
    n_id varchar(20) not null,
    f_date varchar(12),
    u_id varchar(20) not null,
    primary key(id),
    unique key(`u_id`, `n_id`)
);

CREATE table if not exists comment(
    id int unsigned auto_increment,
    c_date varchar(12),
    c_text text,
    u_id varchar(20) not null,
    n_id varchar(20) not null,
    primary key(id),
    unique key(`u_id`,`n_id`)
);
CREATE table if not exists user(
    id int unsigned auto_increment,
    u_id varchar(20) not null,
    nick_name varchar(20) not null,
    motto varchar(50) ,
    email varchar(20) not null,
    `password` varchar(40) not null,
    phone_number varchar(20) not null,
    avator text not null,
    register_date varchar(12),
    last_login_date varchar(12),
    salt varchar(40),
    primary key(id),
    unique key(u_id)
);

create table if not exists subscription(
    id int unsigned auto_increment,
    s_date varchar(12),
    u_id varchar(12) not null,
    t_u_id varchar(12) not null, /*订阅的目标*/
    primary key(id),
    unique key(u_id, t_u_id)
);

/* 空间留言板 */
create table if not exists note(
    id int unsigned auto_increment,
    note_date varchar(12),
    u_id varchar(12) not null,
    note text,
    primary key(id)
);


create table if not exists notify(
    id int unsigned auto_increment,
    trigger_uid varchar(12),
    target_uid varchar(12),
    nid varchar(12),
    trigger_date varchar(12),
    type TINYINT comment '1 为被订阅，2 为被评论，3 文章被收藏',
    seen TINYINT comment '0 代表没有看过 1代表已经看过',
    primary key(id)
);

CREATE VIEW notify_desc_before as
select no.id `noid`,u.nick_name,no.nid, u.u_id, u1.nick_name `target_nickname`, u1.u_id `target_uid`, no.trigger_date, no.type, no.seen
from  user u right join notify no on u.u_id = no.trigger_uid left join user u1 on u1.u_id = no.target_uid ;
 

CREATE VIEW notify_desc_after as
select noid,nick_name,u_id,target_nickname,target_uid,trigger_date,type,seen,n.n_title, n.n_id
from notify_desc_before no left join news n on no.nid = n.n_id;



CREATE VIEW news_desc as
select news.n_id,tag.t_name,news.n_date,news.n_user_id,user.nick_name,user.motto,news.n_title,news.n_content,news.n_tag,count(comment.u_id) as `comment_num`
from news left join comment on news.n_id = comment.n_id left join user on news.n_user_id = user.u_id left join tag on tag.t_id = news.n_tag
group by news.n_id
order by news.n_date desc;

CREATE VIEW favorite_desc as
select nd.n_id,nd.t_name,nd.n_tag,nd.n_date,u.u_id,u.nick_name,nd.n_title,nd.comment_num, f.f_date
from user u left join favorite f on u.u_id = f.u_id inner join news_desc nd on f.n_id = nd.n_id
order by nd.n_date desc;

-- 查询评论的时候，把用户的昵称补齐
create View comm_user as
select c.u_id, c.c_date, c.n_id,c.id,c.c_text,u.nick_name
from comment c, user u
where c.u_id = u.u_id
order by c.c_date desc;
/*
    创建每个用户订阅的表
*/
CREATE view  user_sub as
select s.u_id , s.s_date, u1.u_id `t_u_id`, u1.nick_name , u1.motto,u1.avator
from subscription s  inner join user u1 on s.t_u_id = u1.u_id
order by s.s_date asc;




 /* 创建基本结构的约束或默认值 */

CREATE trigger default_date before insert
on news for each row
set new.n_date=unix_timestamp(now());

CREATE trigger default_date_notify before insert
on notify for each row
set new.trigger_date=unix_timestamp(now());

CREATE trigger default_seen_notify before insert
on notify for each row
set new.seen=0;

/*插入的时候检查，已经查看并且已经是7天之前的通知*/
/* CREATE trigger default_notify_manage after insert
on notify for each row
delete from notify where seen='1' and  trigger_date < unix_timestamp(now()) - 604800; */

CREATE trigger default_date_note before insert
on note for each row
set new.note_date=unix_timestamp(now());

CREATE trigger default_user_note after insert
on user for each row
insert into note(u_id) values(new.u_id); 

CREATE trigger default_date_favorite before insert
on favorite for each row
set new.f_date=unix_timestamp(now());

CREATE trigger default_date_comment before insert
on comment for each row
set new.c_date=unix_timestamp(now());


alter table news add constraint n_fk foreign key(n_tag) references tag(t_id);
alter table news add constraint n_u_fk foreign key(n_user_id) references user(u_id);

alter table favorite add constraint f_u_fk foreign key(u_id) references user(u_id);

alter table comment add constraint cn_fk foreign key(n_id) references news(n_id);
alter table comment add constraint cu_fk foreign key(u_id) references user(u_id);

alter table subscription add constraint su_fk foreign key(u_id) references user(u_id);


