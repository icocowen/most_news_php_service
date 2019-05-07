<?php 


/**
 * realpath("./") 解决include上一层文件问题
 */
class UserControls{

    /**
     * 用户相关的信息，如，获取作品，收藏，订阅，动态等
     * user/user/pullUserProduct ? u=uid 
     */
    public function pullUserProduct(){
        /**
         * 根据uid拉取user poduct   i == pageindex
         * 实现分页
         */
        if (isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $i = 1;
            if (isset($_GET['i']) && !empty($_GET['i'])) {
                $i = (int)$_GET['i'];
            }
            $au = new AuthControls(); //权限验证
            $ns = new NewsDao();
            $nsRes = $ns->getNewssByUID($uid, $i);
            if($nsRes) {

                if($au->authUser($uid)) {
                    //请求的是本人的homepage 153
                    return new Result(ResultSet::PULL_OWNER_PRODUCT_SUCCESS, $nsRes); 
    
                }else{
                    // 其他人的 152
                    return new Result(ResultSet::PULL_OTHER_PRODUCT_SUCCESS, $nsRes); 
                }
            }
           
        }

        return new Result(ResultSet::PULL_PRODUCT_SUCCESS_WITHOUT, null); 
    }

    public function delUserProduct(){
        /**
         * 根据uid，和n_id 删除user poduct
         * 实现分页
         */
       
        if (isset($_GET['n']) && !empty($_GET['n'])) {
            if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
                $info = json_decode($_COOKIE['info']);
                $u = new UserDao();
                $maybe_uid = $u->getUidByEmail($info->username);
                if(!$maybe_uid) {
                    $maybe_uid = $info->username;
                }
                $au = new AuthControls(); //权限验证
                if($au->authUser($maybe_uid)) {
                   
                    $nid = $_GET['n']; //nid
                    $ns = new NewsDao();
                    $nsRes = $ns->deleteNews($maybe_uid, $nid);
                    //请求的是本人的homepage 153
                    if($nsRes) {
                        return new Result(ResultSet::DEL_PRODUCT_SUCCESS, $nsRes); 
                    }
                }
            
            }      
        }
        

        return new Result(ResultSet::DEL_PRODUCT_FAIL, null); 
    }


    public function delComment(){
        /**
         * 根据uid，和n_id 删除comment
         * 实现分页
         */
       
        if (isset($_GET['n']) && !empty($_GET['n'])) {
            if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
                $info = json_decode($_COOKIE['info']);
                $u = new UserDao();
                $maybe_uid = $u->getUidByEmail($info->username);
                if(!$maybe_uid) {
                    $maybe_uid = $info->username;
                }
                $au = new AuthControls(); //权限验证
                if($au->authUser($maybe_uid)) {
                   
                    $nid = $_GET['n']; //nid
                    $ns = new CommentDao();
                    $nsRes = $ns->deleteComment($maybe_uid, $nid);
                    //请求的是本人的homepage 153
                    if($nsRes) {
                        return new Result(ResultSet::COMMENT_DEL_SUCCESS, null); 
                    }else{
                        return new Result(ResultSet::COMMENT_DEL_FAIL, null); 
                    }
                }
            
            }      
        }
        

        return new Result(ResultSet::NO_LOGIN, null); 
    }



    public function delUserFavorite(){
        /**
         * 根据uid，和n_id 删除user poduct
         * 实现分页
         */
       
        if (isset($_GET['n']) && !empty($_GET['n'])) {
            if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
                $info = json_decode($_COOKIE['info']);
                $u = new UserDao();
                $maybe_uid = $u->getUidByEmail($info->username);
                if(!$maybe_uid) {
                    $maybe_uid = $info->username;
                }
                $au = new AuthControls(); //权限验证
                if($au->authUser($maybe_uid)) {
                   
                    $nid = $_GET['n']; //nid
                    $ns = new FavoriteDao();
                    $nsRes = $ns->deleteFavorite($maybe_uid, $nid);
                    //请求的是本人的homepage 153
                    if($nsRes) {
                        return new Result(ResultSet::DEL_FAVORITE_SUCCESS, $nsRes); 
                    }
                }
            
            }      
        }
        

        return new Result(ResultSet::DEL_FAVORITE_FAIL, null); 
    }


    public function delUserSub(){
        /**
         * 根据uid，和n_id 删除user sub
         * 
         */
       
        if (isset($_GET['tu']) && !empty($_GET['tu'])) {
            if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
                $info = json_decode($_COOKIE['info']);
                $u = new UserDao();
                $maybe_uid = $u->getUidByEmail($info->username);
                if(!$maybe_uid) {
                    $maybe_uid = $info->username;
                }
                $au = new AuthControls(); //权限验证
                if($au->authUser($maybe_uid)) {
                   
                    $tnid = $_GET['tu']; //nid
                    $ns = new SubscriptionDao();
                    $nsRes = $ns->deleteSubscribe($maybe_uid, $tnid);
                    //请求的是本人的homepage 153
                    if($nsRes) {
                        return new Result(ResultSet::DEL_SUB_SUCCESS, $nsRes); 
                    }
                }
            
            }      
        }
        

        return new Result(ResultSet::DEL_SUB_FAIL, null); 
    }


    public function pullUserFavorit(){
        /**
         * 根据uid拉取user 收藏
         */
        if (isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $i = 1;
            if (isset($_GET['i']) && !empty($_GET['i'])) {
                $i = (int)$_GET['i'];
            }
            $au = new AuthControls(); //权限验证
            $fs = new FavoriteDao();
            $fsRes = $fs->getFavorite($uid, $i);
            if($fsRes) {

                if($au->authUser($uid)) {
                    //请求的是本人的homepage 153
                    return new Result(ResultSet::PULL_OWNER_FAVORITE_SUCCESS, $fsRes); 
    
                }else{
                    // 其他人的 152
                    return new Result(ResultSet::PULL_OTHER_FAVORITE_SUCCESS, $fsRes); 
                }
            }
           
        }

        return new Result(ResultSet::PULL_FAVORITE_SUCCESS_WITHOUT, null); 
    }


    public function pullUserSub(){
        /**
         * 根据uid拉取user 收藏
         */
        if (isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $au = new AuthControls(); //权限验证
            $ss = new SubscriptionDao();
            $i = 1;
            if (isset($_GET['i']) && !empty($_GET['i'])) {
                $i = (int)$_GET['i'];
            }
            $ssRes = $ss->getSubscribe($uid, $i);
            if($ssRes) {

                if($au->authUser($uid)) {
                    //请求的是本人的homepage 153
                    return new Result(ResultSet::PULL_OWNER_SUB_SUCCESS, $ssRes); 
    
                }else{
                    // 其他人的 152
                    return new Result(ResultSet::PULL_OTHER_SUB_SUCCESS, $ssRes); 
                }
            }
           
        }

        return new Result(ResultSet::PULL_SUB_SUCCESS_WITHOUT, null); 
    }


    public function pullUserProductItem(){
        /**
         * 根据uid拉取user news iten
         */
        if (isset($_GET['n']) && !empty($_GET['n'])) {
            ## 以下操作可优化
            if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
                $info = json_decode($_COOKIE['info']);
                $u = new UserDao();
                $maybe_uid = $u->getUidByEmail($info->username);
                if(!$maybe_uid) {
                    $maybe_uid = $info->username;
                }
                $au = new AuthControls(); //权限验证
                if($au->authUser($maybe_uid)) {
                   
                    $nid = $_GET['n']; //nid
                    $ns = new NewsDao();
                    $nsRes = $ns->getNewsByNid($nid);
                    //请求的是本人的homepage 153
                    if($nsRes) {
                        return new Result(ResultSet::PULL_PRODUCT_ITEM_SUCCESS, $nsRes); 
                    }
                }
            
            }      
        }
        return new Result(ResultSet::PULL_PRODUCT_ITEM_FAIL, null); 
    }

    public function updateProductItem(){
        $n_info = file_get_contents('php://input');
        $n_info_instance = json_decode($n_info);
        // 更新新闻 可更新的的字段为n_title n_content n_tag
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao();
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
            
                $ns = new NewsDao();
                $t = new TagDao();
                $n_info_instance->tag_id = ($t->tagToId($n_info_instance->tag))->t_id;
                $nsRes = $ns->updateNews($n_info_instance);
                //请求的是本人的homepage 153
                if($nsRes) {
                    return new Result(ResultSet::UPDATE_PRODUCT_SUCCESS, $nsRes); 
                }
            }
        
        }  
        //更新失败    
        return new Result(ResultSet::UPDATE_PRODUCT_FAIL, null); 
    }


    public function releaseProduct(){
        $n_info = file_get_contents('php://input');
        $n_info_instance = json_decode($n_info);
        // 更新新闻 可更新的的字段为n_title n_content n_tag
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
            
                $ns = new NewsDao();
                $t = new TagDao();
                $n = new News();
                $n->tag_id = ($t->tagToId($n_info_instance->tag))->t_id;
                $n->u_id = $maybe_uid;
                $n->n_title = $n_info_instance->title;
                $n->article = $n_info_instance->article;
                $nid = '';
                do {
                    $nid = '23'.(string)random_int(2000000, 2999999);
                } while ($ns->checkNid($nid));
                $n->n_id = $nid;
                
                if($ns->addNews($n)) {
                    return new Result(ResultSet::PUBLISH_PRODUCT_SUCCESS, null); 
                }
            }
        
        }  
        //更新失败    
        return new Result(ResultSet::PUBLISH_PRODUCT_FAIL, null); 
    }



    public function comment(){
        $c_info = file_get_contents('php://input');
        $c_info_instance = json_decode($c_info);
        // 更新新闻 可更新的的字段为n_title n_content n_tag
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                $cd = new CommentDao();
                $c = new Comment();
                $c->u_id = $maybe_uid;
                $c->n_id = $c_info_instance->nid;
                $c->c_content = $c_info_instance->content;
                $res = $cd->addComment($c);

                if($res) {
                     $no = new NotifyDao();
                     $ns = new NewsDao();
                     $tuid = $ns->getUidByNid($c_info_instance->nid);
                     if($tuid) {
                        $no->addNotify($maybe_uid, $tuid, 2, $c_info_instance->nid);
                     }
                     return new Result(ResultSet::COMMENT_SUCCESS, null); 
                }else{
                    return new Result(ResultSet::COMMENT_FAIL, null); 
                }

            }
        
        }  
        //更新失败    
        return new Result(ResultSet::NO_LOGIN, null); 
    }


    public function sub(){ //订阅
        /**
         * 根据u 查询 u = uid
         */
       if(isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $s = new SubscriptionDao();
            $num = $s->getSubNum($uid);
            if($num) {
                return new Result(ResultSet::PULL_SUB_SUCCESS, $num);
            }
       }
       return new Result(ResultSet::PULL_SUB_FAIL, null);
    }

    public function subed(){//被订阅数
        if(isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $s = new SubscriptionDao();
            $num = $s->getSubedNum($uid);
            if($num) {
                return new Result(ResultSet::PULL_SUBED_SUCCESS, $num);
            }
       }
       return new Result(ResultSet::PULL_SUBED_FAIL, null);
    }

    public function pullUserNote(){
        if(isset($_GET['u']) && !empty($_GET['u'])) {
            $uid = $_GET['u'];
            $s = new UserDao();
            $note = $s->getUserNote($uid);
            return new Result(ResultSet::PULL_USER_NOTE_SUCCESS, $note);
       }
       return new Result(ResultSet::PULL_USER_NOTE_FAIL, null);
    }

    public function updateNote(){
        $n_info = file_get_contents('php://input');
        $n_info_instance = json_decode($n_info);
        // 更新新闻 可更新的的字段为n_title n_content n_tag
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                $nt = $u->updateNote($maybe_uid,$n_info_instance->note);
                if($nt) {
                    return new Result(ResultSet::UPDATE_USER_NOTE_SUCCESS, null); 
                }
            }
        
        }  
        //更新失败    
        return new Result(ResultSet::UPDATE_USER_NOTE_FAIL, null); 
    }


    public function total(){
        /**
         * t 为需要获得总条数的类型 p 为news， f为收藏，s为订阅
         * u 为uid
         */
        if((isset($_GET['t']) && !empty($_GET['t'])) && (isset($_GET['u']) && !empty($_GET['u']))) {

            $type = $_GET['t'];
            $uid = $_GET['u'];
            $targetType = 'user_control_'.$type.'_type';
            return $this->$targetType($uid);
       }
       return new Result(ResultSet::PULL_TOTAL_FAIL, null);
    }

    public function user_control_p_type($uid){
        $u = new NewsDao();
        return new Result(ResultSet::PULL_TOTAL_SUCCESS, $u->checkNewsNum($uid));
    }

    public function user_control_f_type($uid){
        $f = new FavoriteDao();
        return new Result(ResultSet::PULL_TOTAL_SUCCESS, $f->checkFavoriteNum($uid));
    }


    public function user_control_s_type($uid){
        $s = new SubscriptionDao();
        return new Result(ResultSet::PULL_TOTAL_SUCCESS, $s->getSubNum($uid));
    }


    public function addSub(){
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $us_info = file_get_contents('php://input');
            $us_info_instance = json_decode($us_info);    
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                if($maybe_uid != $us_info_instance->tuid) {
                    $s = new SubscriptionDao();
                    $res = $s->addSubscribe($maybe_uid, $us_info_instance->tuid);
                    if($res) {
                        $no = new NotifyDao();
                        $no->addNotify($maybe_uid,$us_info_instance->tuid, 1 );
                        return new Result(ResultSet::ADD_SUB_SUCCESS, null); 
                    }
                }
                
            }
        
        }    
        return new Result(ResultSet::ADD_SUB_FAIL, null); 
    }


    public function checkIsSub(){
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $us_info = file_get_contents('php://input');
            $us_info_instance = json_decode($us_info);    
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                $s = new SubscriptionDao();
                $res = $s->checkIsSub($maybe_uid, $us_info_instance->tuid);
                if($res) {
                    return new Result(ResultSet::HAS_SUB, null); 
                }
            }
        
        }    
        return new Result(ResultSet::NO_SUB, null); 
    }



    public function addFavorite(){
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $n_info = file_get_contents('php://input');
            $n_info_instance = json_decode($n_info);    
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                $f = new FavoriteDao();
                $ns = new NewsDao();
                $res = $f->addFavorite($maybe_uid, $n_info_instance->nid);
                if($res) {
                    $no = new NotifyDao();
                    $tuid = $ns->getUidByNid($n_info_instance->nid);
                    if($tuid) {
                        $no->addNotify($maybe_uid,$tuid,3,$n_info_instance->nid);
                    }
                    return new Result(ResultSet::ADD_FAVORITE_SUCCESS, null); 
                }
            }
        
        }    
        return new Result(ResultSet::ADD_FAVORITE_FAIL, null); 
    }


    public function checkIsFavorite(){
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $n_info = file_get_contents('php://input');
            $n_info_instance = json_decode($n_info);      
            $info = json_decode($_COOKIE['info']);
            $u = new UserDao(); 
            $maybe_uid = $u->getUidByEmail($info->username);
            if(!$maybe_uid) {
                $maybe_uid = $info->username;
            }
            $au = new AuthControls(); //权限验证
            if($au->authUser($maybe_uid)) {
                $s = new FavoriteDao();
                $res = $s->checkIsFavorite($maybe_uid, $n_info_instance->nid);
                if($res) {
                    return new Result(ResultSet::HAS_FAVORITE, null); 
                }
            }
        
        }    
        return new Result(ResultSet::NO_FAVORITE, null); 
    }

  


}