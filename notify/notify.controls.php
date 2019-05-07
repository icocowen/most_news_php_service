<?php

// notify/notify/notifys

class NotifyControls {

    public function notifys() {
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
               $no = new NotifyDao();
               $res = $no->getNotify($maybe_uid);
               if($res) {
                   $process_res =array();
                   $noid_set = array();
                   foreach ($res as $value) {
                       $process = array();
                       $method = 'process_hint_'.$value['type'];
                       $process['hint'] = $this->$method($value);
                       $noid_set[] = $value['noid'];
                       $process_res[] = $process;
                   }
                  return new Result(ResultSet::PULL_NOTIFY_SUCCESS, array('hints' => $process_res, 'noids' => $noid_set)); 
               }
            }
        
        }    
        return new Result(ResultSet::PULL_NOTIFY_FAIL, null); 
    }
    // <a [routerLink]="[ '/path', routeParam ]">name</a>
    private function process_hint_1($res){
        return '<a>'.$res['nick_name'].'</a>关注了你';
    }

    private function process_hint_2($res){
        return '<a >'.$res['nick_name'].'</a>评论了你的文章:<a>'.$res['n_title'].'</a>';
    }


    private function process_hint_3($res){
        return '<a>'.$res['nick_name'].'</a>收藏了你的文章:<a>'.$res['n_title'].'</a>';
    }



    public function notifyNum() {
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
               $no = new NotifyDao();
               $res = $no->getNotifyNum($maybe_uid);
               if($res) {
                  return new Result(ResultSet::PULL_NOTIFY_NUM_SUCCESS, $res); 
               }
            }
        
        }    
        return new Result(ResultSet::PULL_NOTIFY_NUM_FAIL, null); 
    }


    public function seen() {
        header("Access-Control-Allow-Headers:Content-Type,Access-Token"); 
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
               $no = new NotifyDao();
               foreach ($n_info_instance as  $value) {
                 foreach ($value as $val) {
                    $res = $no->setSeen($maybe_uid, $val);
                 }
               }   
               if($res) {
                  return new Result(ResultSet::NOTIFY_SEEN_SUCCESS, null); 
               }
            }
        
        }    
        return new Result(ResultSet::NOTIFY_SEEN_FAIL, null); 
    }





}