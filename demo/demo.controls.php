<?php
    /**
     * index.php/demo/demo/dd?a=5345345345
     * 入口文件/模块/类/方法?查询参数
     * 类名为驼峰写法，php文件为驼峰类名加.controls.php
     * 
     * 这个文件及文件夹为演示实例
     * http://localhost:8080/phpService/index.php/demo/demo/dd?a=5345345345 测试地址
     */
    class DemoControls 
    {
        public function dd()
        {
            $u = new User();
            $u->u_id = "11111222";
            $u->motto = "eqweqweq";
            $u->avator = "sadasddas";
            $u->email = "dasdasdad";
            $u->last_data = (string)time();
            $u->register_data = $u->last_data;
            $u->pwd = "ddddddddddddddddddddd";
            $u->phone_number = "342342343242";
            $u->nick_name = "3243423";
            $a = new UserDao();
            $b = $a->addUser($u);
            $u->u_id = "44444222";
            $b = $a->addUser($u);
            $u->u_id = "66666222";
            $b = $a->addUser($u);
            $u->u_id = "88888222";
            $b = $a->addUser($u);

            $a = new SubscriptionDao();
            $a->addSubscribe('11111222','44444222');
            $a->addSubscribe('11111222','66666222');
            $a->addSubscribe('11111222','88888222');

            $a->deleteSubscribe('11111222','44444222');

            $b = $a->getSubscribe('11111222');

            $f = new FavoriteDao();
            $f->addFavorite('44444222','132312');
            $f->addFavorite('44444222','132322');
            $f->addFavorite('44444222','122322');

            $f->deleteFavorite('44444222','132312');

            $b = $f->getFavorite('44444222');


            $c = new Comment();
            $c->u_id = "44444222";
            $c->n_id = "122322";
            $c->c_date = (string)time();
            $c->c_content = "你好骚";

            $cc = new CommentDao();
            $cc->addComment($c);
            $c->u_id="66666222";
            $c->n_id="122322";
            $cc->addComment($c);
            $c->u_id="88888222";
            $c->n_id="122322";
            $cc->addComment($c);

            $cc->deleteComment($c->u_id, $c->n_id);

            $b = $cc->getComments('122322');

            $n = new News();
            $n->u_id = "44444222";
            $n->n_id = "3234r432";
            $n->n_date = (string)time();
            $n->tag_id = "222";
            $n->n_title = "最娱乐的新闻";
            $n->article = "dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd";

            $nn = new NewsDao();
            $nn->addNews($n);
            $n->n_id = "32343453";
            $nn->addNews($n);
            $n->n_id = "32343432";
            $nn->addNews($n);
            $n->n_id = "32343323";
            $nn->addNews($n);
            $n->n_id = "32342353";
            $nn->addNews($n);

            $b = $nn->getNewss();
            $c = $nn->getNewssByTagId('221');
            $n->n_title="1111111";
            $n->tag_id="221";
            $n->article="sasa";
            $nn->updateNews($n);
            $d = $nn->getNewssByUID('44444222');
            $nn->deleteNews('44444222','3234r432');

            

            if ($c) {
                return new Result(ResultSet::LOGIN_SUCCESS,array($d));
            }
            return new Result(ResultSet::REGISTER_FAIL,null);
        }
    }
    