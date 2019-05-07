<?php 
/**
 * 定义用户的登录,注销,注册,资源的访问
 */
class AuthControls{
    public function login(){
        /**
         * 检查是否有jwt,如果有jwt，则根据username，查找signature 秘钥salt，
         * 如果里面的username，password与欲登录的相同，则提示不要重复登录
         * 如果没有jwt，则根据username验证，password，
         * 然后把username，password，写入jwt，和cookie中, salt为md5（salt+random()）
         *
         */
        $user_info = file_get_contents('php://input');
        $user_info_instance = json_decode($user_info);
        $maybe_pwd = self::auth_control_remove_salt($user_info_instance->password);
        $username = $user_info_instance->username;
     
        $u = new UserDao();
        #先检验jwt,存在且里面的username等于欲登录的username，提示不要重复登录
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){
            //获取对应username的签名秘钥
            $key = self::auth_control_get_signature($username);
            $token = json_decode($_COOKIE['info'])->token;
            $isValid = self::auth_control_verify_jwt($token, $key);
            
            if($isValid) {
                if (isset($isValid['username']) && isset($isValid['password'])) {
                    if($isValid['username'] == $username && $isValid['password'] == $maybe_pwd){
                        $uu = $u->getUserByUid($username);
                        if(!$uu) {
                            $uu = $u->getUserByEmail($username);
                        }
                        return new Result(ResultSet::DONT_LOGIN_AGAIN, $uu); 
                    }
                }
                
            }
        }

        
        $isMatch = $this->auth_control_verify_password($username, $maybe_pwd);
        if (!$isMatch) {
            return new Result(ResultSet::USER_PASSWORD_FAIL, null);         
        }
        $generate_key = md5(time() + random_int(100, 10000));
        
        if(!$u->updateSaltByUid($username, $generate_key)){
            $u->updateSaltByEmail($username, $generate_key);
        }

        $info = array('iat' => time(),'exp'=>time()+60*60*24,'nbf'=>time(), 'username' => $username,  'password' => $maybe_pwd);
        $client_info = array('token' => self::auth_control_encode_jwt($info, $generate_key) , 'username'=> $username, 'password' => $maybe_pwd);
        setcookie('info',json_encode($client_info) , time()+60*60*24, '/');
    
        $uu = $u->getUserByUid($username);
        if(!$uu) {
            $uu = $u->getUserByEmail($username);
        }
        return new Result(ResultSet::USER_LOGIN_SUCCESS, $uu);   
    }


    public function checkStatus(){

        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){
            //获取对应username的签名秘钥 
            $info = json_decode($_COOKIE['info']);
            $username = $info->username;
            $password = $info->password;
            $key = self::auth_control_get_signature($username);
            $token = $info->token;
            $isValid = self::auth_control_verify_jwt($token, $key);
            $u = new UserDao();
            if($isValid) {
                if (isset($isValid['username']) && isset($isValid['password'])) {
                    if($isValid['username'] == $username && $isValid['password'] == $password){
                        $uu = $u->getUserByUid($username);
                        if(!$uu) {
                            $uu = $u->getUserByEmail($username);
                        }
                        return new Result(ResultSet::DONT_LOGIN_AGAIN, $uu); 
                    }
                }  
            }
            setcookie('info','', 0,'/');
        }
    }

    public function authUser($uid){
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){
            //获取对应username的签名秘钥 
            $info = json_decode($_COOKIE['info']);
            $username = $info->username;
            $password = $info->password;
            $key = self::auth_control_get_signature($username);
            $token = $info->token;
            $isValid = self::auth_control_verify_jwt($token, $key);
            $u = new UserDao();
            if($isValid) {
                if (isset($isValid['username']) && isset($isValid['password'])) {
                    if($isValid['username'] == $username && $isValid['password'] == $password ){
                        if($u->getEmailByUid($uid) == $username || $uid == $username){
                            
                            return true; 
                        }
                    }
                }  
            }

        }
        return false;
    }

    public function logout(){

        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){
            //获取对应username的签名秘钥 
            $info = json_decode($_COOKIE['info']);
            $username = $info->username;
            $password = $info->password;
            $key = self::auth_control_get_signature($username);
            $token = $info->token;
            $isValid = self::auth_control_verify_jwt($token, $key);
            $u = new UserDao();
            if($isValid) {
                if (isset($isValid['username']) && isset($isValid['password'])) {
                    if($isValid['username'] == $username && $isValid['password'] == $password){
                        setcookie('info','', 0,'/');
                    
                        return new Result(ResultSet::LOGOUT_SUCCESS, null); 
                    }
                }  
            }
        }
        return new Result(ResultSet::NO_LOGIN, null);
    }

    public function pullUser(){
        header("Access-Control-Allow-Headers:Content-Type,Access-Token"); 
        $uid = file_get_contents('php://input');
        $uid_instance = json_decode($uid);
        $u = new UserDao();
        if(isset($_COOKIE['info']) && !empty($_COOKIE['info'])){ //进入自己的主页
            $info = json_decode($_COOKIE['info']);
            $username = $info->username;
            $password = $info->password;
            $key = self::auth_control_get_signature($username);
            $token = $info->token;
            $isValid = self::auth_control_verify_jwt($token, $key);
            
            if($isValid) {
                if (isset($isValid['username']) && isset($isValid['password'])) {
                    if($isValid['username'] == $username && $isValid['password'] == $password ){
                        if($u->getEmailByUid($uid_instance->uid) == $username || $uid_instance->uid == $username){
                            $uu = $u->getUserByUid($username);
                            if(!$uu) {
                                $uu = $u->getUserByEmail($username);
                            }
                            return new Result(ResultSet::PULL_OWNER_INFO_SUCCESS, $uu); 
                        }
                    }
                }  
            }
        }
        //进入他人的主页
        $uu = $u->getUserByUid($uid_instance->uid);
        if(!$uu) {
            $uu = $u->getUserByEmail($uid_instance->uid);
        }
        if($uu) {
            return new Result(ResultSet::PULL_OTHER_INFO_SUCCESS, $uu); 
        }
        return new Result(ResultSet::PULL_OTHER_INFO_FAIL, null); 
    }


    public function register(){
        header("Access-Control-Allow-Headers:Content-Type,Access-Token"); 
        $user_info = file_get_contents('php://input');
        $user_info_instance = json_decode($user_info);

        if($user_info_instance) {
            $u = new User();
            $ud = new UserDao();
            if($ud->checkUserByEmail($user_info_instance->email)){
                return new Result(ResultSet::EMAIL_INVAILD, null);
            };
            $u->email = $user_info_instance->email;
            $u->pwd = self::auth_control_remove_salt($user_info_instance->password);
            $u->phone_number = $user_info_instance->phoneNumber;
            $u->nick_name = $user_info_instance->nickname;
            $u->register_data = (string)time();
            $u->last_data = $u->register_data;
            $u->motto = '明日复明日，明日何其多';
            $u->avator = '还没确定';
            $uid = '';
            do {
                $uid = '1'.(string)random_int(1000000, 1999999);
            } while ($ud->checkUser($uid));
            $u->u_id = $uid;
            $res = $ud->addUser($u);
            if($res) {
                return new Result(ResultSet::USER_REGISTER_SUCCESS, $uid);
            }
        }
        return new Result(ResultSet::USER_REGISTER_FAIL, null);
    }

    public function checkEmail(){
        $user_info = file_get_contents('php://input');
        $user_info_instance = json_decode($user_info);
        if($user_info_instance) {
            $ud = new UserDao();
            if(!$ud->checkUserByEmail($user_info_instance->email)){
                return new Result(ResultSet::EMAIL_VAILD, null);
            };
        }
        
        return new Result(ResultSet::EMAIL_INVAILD, null);
    }

    
    public static function auth_control_encode_password(string $password, string $salt){
        /**
         * md5 + salt
         * @return 
         *  encrypt.substr(12, 13) 
         * + this.psalt.substr(8, 4) 
         * +  encrypt.substr(0, 12) 
         * +  this.psalt.substring(0, 8)
         * + encrypt.substr(30, 2)  
         * + this.psalt.substr(12, 4) 
         * + encrypt.substr(25, 5);
         */
        // $repassword = substr($password, 16, 12).substr($password, 0, 13).substr($password, 42, 5).substr($password, 36, 2);
        $match_pwd = md5($password.$salt.$password);
        return $match_pwd;
    }
    public static function auth_control_remove_salt(string $password){
        /**
         * 根据规则得到密码 
         *    // d9b1d7db4cd6e70935368a1ef b10e377
        *     // d9b1d7db4cd6e70935368a1ef 5b10ef3
        *      e70935368a1ef285ed9b1d7db4cd66a6a12c43665b10e3
         */
        return substr($password, 17, 12).substr($password, 0, 13).substr($password, 43, 5).substr($password, 37, 2);
    }

    public static function auth_control_get_signature($username){
        /**
         * 根据username 获取signature
         */
        $u = new UserDao();
        $usalt = $u->getSaltByUid($username);
        $esalt = $u->getSaltByEmail($username);
        return $usalt ? $usalt : $esalt;
    }

   

    public function auth_control_verify_password($u_key, $password){
        /**
         * 根据传入的userid, password 密码是否正确
         * @return true or false
         */
        $u_dao = new UserDao();
        $upwd = $u_dao->getPasswordByUid($u_key);
        $epwd = $u_dao->getPasswordByEmail($u_key);
        if($upwd || $epwd){//存在密码
            if ($password == $upwd || $epwd == $password) {
                return true; 
            }
        }
        return false;
    }

    public static function auth_control_verify_jwt($payload,string $key){
        /**
         * 根据payload检验jwt
         * @return payload or false
         */
        return Jwt::verifyToken($payload,$key);
    }

    public static function auth_control_encode_jwt($payload,string $key){
        /**
         * 根据payload检验jwt
         * @return payload or false
         */
        return Jwt::getToken($payload,$key);
    }



  


}