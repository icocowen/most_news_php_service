<?php
/**
 * 定义user的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class UserDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }
    
    /**
         * 只是一个插入语句不需要启动事务
         * 
         * @param $user 为User类变量
         */
    public function addUser(User $user){
        
        $sql = "insert into user(u_id,nick_name,motto,email,password,phone_number,avator,register_date,last_login_date)".
        "values(?,?,?,?,?,?,?,?,?)";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        ### 这里需要抛出一个$stmt语句异常的错误
        $stmt->bind_param('sssssssss',
                        $user->u_id,
                        $user->nick_name,
                        $user->motto,
                        $user->email,
                        $user->pwd,
                        $user->phone_number,
                        $user->avator,
                        $user->register_data,
                        $user->last_data
                    );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function checkUser($u_id){
        /**
         * @param $u_id 用户id 检查用户是否存在
         */
        $sql = "select count(*) from user where u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $u_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = (int)$res->fetch_assoc()['count(*)'];
        if ($r > 0) {
            return true;
        }
        return false;
    }

    public function checkUserByEmail($email){
        /**
         * @param $email email 检查用户是否存在
         */
        $sql = "select count(*) from user where email = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = (int)$res->fetch_assoc()['count(*)'];
        if ($r > 0) {
            return true;
        }
        return false;
    }

    public function getPasswordByUid($u_id){
        /**
         * @param $u_id 用户id 检查用户是否存在
         */
        $sql = "select password from user where u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $u_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['password'];
        }
        return false;
    }

    public function getPasswordByEmail($email){
        /**
         * @param $email email 检查用户是否存在
         */
        $sql = "select password from user where email = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['password'];
        }
        return false;
    }

    public function getSaltByUid($u_id){
        /**
         * @param u_id 返回salt
         */
        $sql = "select salt from user where u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $u_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['salt'];
        }
        return false;
    }

    public function getSaltByEmail($email){
        /**
         * @param email email
         */
        $sql = "select salt from user where email = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['salt'];
        }
        return false;
    }

    public function getEmailByUid($uid){
        /**
         * @param uid uid
         */
        $sql = "select email from user where u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['email'];
        }
        return false;
    }

    public function getUidByEmail($email){
        /**
         * @param email email
         */
        $sql = "select u_id from user where email = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_assoc()['u_id'];
        }
        return false;
    }

    public function getUserByUid($u_id){
        /**
         * 返回user对象
         * @param $u_id 用户id
         */
        // $sql = "SELECT u_id,nick_name,motto,email,password,phone_number,avator,register_date,last_login_date from user where u_id = ?";
        $sql = "SELECT u_id,nick_name,motto,email,phone_number,avator,register_date,last_login_date from user where u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $u_id);
        $stmt->execute();
        
        $resSet = $stmt->get_result();
        if ($resSet->num_rows > 0) {
            $res = $resSet->fetch_assoc();
            $u = new User();
            $u->u_id = $res['u_id'];
            $u->nick_name = $res['nick_name'];
            $u->motto = $res['motto'];

            $u->email = $res['email'];
            // $u->pwd = $res['password'];
            $u->phone_number = $res['phone_number'];

            $u->avator = $res['avator'];
            $u->register_data = $res['register_date'];
            $u->last_data = $res['last_login_date'];
            return $u;
        }
        return false;

    }

    public function getUserByEmail($email){
        /**
         * email
         * @param $email email
         */
        // $sql = "SELECT u_id,nick_name,motto,email,password,phone_number,avator,register_date,last_login_date from user where u_id = ?";
        $sql = "SELECT u_id,nick_name,motto,email,phone_number,avator,register_date,last_login_date from user where email = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        
        $resSet = $stmt->get_result();
        if ($resSet->num_rows > 0) {
            $res = $resSet->fetch_assoc();
            $u = new User();
            $u->u_id = $res['u_id'];
            $u->nick_name = $res['nick_name'];
            $u->motto = $res['motto'];

            $u->email = $res['email'];
            // $u->pwd = $res['password'];
            $u->phone_number = $res['phone_number'];

            $u->avator = $res['avator'];
            $u->register_data = $res['register_date'];
            $u->last_data = $res['last_login_date'];
            return $u;
        }
        return false;

    }

    public function updateNickName($u_id, $nickName){
        /**
         * 更新昵称
         * @param $nickName 昵称
         */ 
        $sql = "UPDATE user SET nike_name=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$nickName,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateMotto($u_id, $motto){
        /**
         * 签名
         * @param $motto 签名
         */ 
        $sql = "UPDATE user SET motto=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$motto,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateEmail($u_id, $email){
        /**
         * email
         * @param $email email
         */ 
        $sql = "UPDATE user SET email=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$email,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateSaltByUid($u_id, $salt){
        /**
         * salt
         * @param $salt salt
         */ 
        $sql = "UPDATE user SET salt=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$salt,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateSaltByEmail($email, $salt){
        /**
         * salt
         * @param $salt salt
         */ 
        $sql = "UPDATE user SET salt=? where email=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$salt,$email);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updatePassword($u_id, $password){
        /**
         * password
         * @param $password password
         */ 
        $sql = "UPDATE user SET password=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$password,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }


    public function updatePhoneNumber($u_id, $phone_number){
        /**
         * phone_number
         * @param $phone_number phone_number
         */ 
        $sql = "UPDATE user SET phone_number=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$phone_number,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateAvator($u_id, $avator){
        /**
         * avator
         * @param $avator avator
         */ 
        $sql = "UPDATE user SET avator=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$avator,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateLastLoginDate($u_id, $last_login_date){
        /**
         * last_login_date
         * @param $last_login_date last_login_date
         */ 
        $sql = "UPDATE user SET last_login_date=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$last_login_date,$u_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        }
        return false;

    }

    public function updateNote($uid, $note){
        $sql = "UPDATE note  SET note=? where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$note,$uid);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function getUserNote($uid){
        $sql = "SELECT note from note where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$uid);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return ($stmt->get_result())->fetch_assoc()['note'];
    }

}

