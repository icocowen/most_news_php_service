use news_system;

insert into tag(t_id, t_name) values
('655341','娱乐'),
('655342','科技'),
('655343','搞笑'),
('655344','体育'),
('655345','游戏'),
('655346','财经');

insert into user(u_id,nick_name,motto,email,password,phone_number,avator,register_date,last_login_date) values
('95132651','iwne1','i want to fly','1558165507@qq.com','d9b1d7db4cd6e70935368a1efb10e377','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132652','iwne2','i want to fly','1558165507@qq.com','d9b1d7db4cd6e70935368a1efb10e377','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132653','iwne3','i want to fly','1558165507@qq.com','d9b1d7db4cd6e70935368a1efb10e377','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132654','iwne4','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132655','iwne5','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132656','iwne6','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132657','iwne7','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132658','iwne8','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132659','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132660','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132661','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132662','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132663','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132664','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132665','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132666','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132667','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132668','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132669','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132670','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now())),
('95132671','iwne9','i want to fly','1558165507@qq.com','qweryuioplkajshdbcnzgfhsjdfsdf','15119306876','c://www/www/dasd/p.png',unix_timestamp(now()),unix_timestamp(now()));

insert into news(n_id,n_title, n_content,n_user_id,n_tag) values
('12312311','i fly1','iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132651','655341'),
('12312312','i fly2','iiiiii234234234iiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132652','655341'),
('12312313','i fly3','iierwerwerwerwerweiiiiiiiiiiiiiiiiiiiiiiiii','95132652','655342'),

('12312314','i fly4','iiiqwreqrwerwerwerweiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312315','i fly5','iieqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312326','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312336','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312346','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312356','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312366','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312376','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312386','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312396','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312306','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),
('12312416','i fly6','iieqweqweqweqweqiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132653','655342'),

('12312317','i fly7','iiiiiifffffffffffiiiiiiiiiiiiiiiiiiiiiiiiiiiii','95132654','655343'),
('12312318','i fly8','iiiiidfsdfsdfdfsdfiiiiiiiiiiiiiiiiiiiiiiiiiii','95132654','655343'),
('12312319','i fly9','iiiiiiiii55555iiiiiiiiiiiiiiiiiiiiiii','95132654','655344'),
('12312321','i fly424','iiiiddddddddddddddiiiiiiiiiiiiiiiiiiiiiii','95132655','655345'),

('12312122','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312222','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312322','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312422','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312522','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312622','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312722','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312822','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12312922','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12313022','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12313122','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12313222','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12313322','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346'),
('12313422','i fly232','iiiiiiiiiiiiiiiiiiitttttttttttiiiiiiiiiiiiiiii','95132655','655346');

insert into comment(c_date,c_text,u_id,n_id) values
(unix_timestamp(now()),concat("你好骚啊",now()),'95132653','12312311'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132651','12312312'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132651','12312313'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132652','12312314'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132652','12312315'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132654','12312311'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132654','12312312'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132655','12312313'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132655','12312314'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132651','12312315'),
(unix_timestamp(now()),concat("你好骚啊",now()),'95132651','12312311');


insert into favorite(n_id,f_date,u_id) values
('12312311',unix_timestamp(now()),'95132653'),
('12312312',unix_timestamp(now()),'95132652'),
('12312313',unix_timestamp(now()),'95132653'),
('12312314',unix_timestamp(now()),'95132654'),
('12312315',unix_timestamp(now()),'95132652'),

('12312122',unix_timestamp(now()),'95132653'),
('12312222',unix_timestamp(now()),'95132653'),
('12312322',unix_timestamp(now()),'95132653'),
('12312422',unix_timestamp(now()),'95132653'),
('12312522',unix_timestamp(now()),'95132653'),
('12312622',unix_timestamp(now()),'95132653'),
('12312722',unix_timestamp(now()),'95132653'),
('12312822',unix_timestamp(now()),'95132653'),
('12312922',unix_timestamp(now()),'95132653'),
('12313022',unix_timestamp(now()),'95132653'),
('12313122',unix_timestamp(now()),'95132653'),
('12313222',unix_timestamp(now()),'95132653'),
('12313322',unix_timestamp(now()),'95132653'),
('12313422',unix_timestamp(now()),'95132653');


insert into subscription(s_date, u_id, t_u_id) values
(unix_timestamp(now()),'95132651','95132652'),
(unix_timestamp(now()),'95132652','95132652'),
(unix_timestamp(now()),'95132652','95132651'),

(unix_timestamp(now()),'95132651','95132653'),

(unix_timestamp(now()),'95132653','95132651'),
(unix_timestamp(now()),'95132653','95132652'),
(unix_timestamp(now()),'95132653','95132654'),
(unix_timestamp(now()),'95132653','95132655'),
(unix_timestamp(now()),'95132653','95132656'),
(unix_timestamp(now()),'95132653','95132657'),
(unix_timestamp(now()),'95132653','95132658'),
(unix_timestamp(now()),'95132653','95132659'),

(unix_timestamp(now()),'95132653','95132660'),
(unix_timestamp(now()),'95132653','95132661'),
(unix_timestamp(now()),'95132653','95132662'),
(unix_timestamp(now()),'95132653','95132663'),
(unix_timestamp(now()),'95132653','95132664'),
(unix_timestamp(now()),'95132653','95132665'),
(unix_timestamp(now()),'95132653','95132666'),
(unix_timestamp(now()),'95132653','95132667'),
(unix_timestamp(now()),'95132653','95132668'),
(unix_timestamp(now()),'95132653','95132669'),
(unix_timestamp(now()),'95132653','95132670'),
(unix_timestamp(now()),'95132653','95132671'),
(unix_timestamp(now()),'95132651','95132655');

