<?php
/**
 * 定义Subscription的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class SubscriptionDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function addSubscribe($u_id, $t_u_id){
        /**
         * 根据u_id添加订阅
         * @param $u_id u_id
         */
        $time = (string)time();
        $sql = "INSERT INTO subscription(s_date, u_id, t_u_id) values(?,?,?)";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sss', $time,$u_id, $t_u_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function deleteSubscribe($u_id, $t_u_id){
        /**
         * 根据u_id删除订阅
         * @param $u_id u_id
         */
        $sql = "DELETE FROM subscription WHERE u_id = ? and t_u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$u_id,$t_u_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function getSubscribe($u_id, $start=1, $len = 12){
        /**
         * 根据u_id获得具体的订阅信息
         * 订阅的信息包括 t_u_id ,t_name, t_motto,t_nick_name,s_data,
         * @param $u_id 用户id
         * @param $start 从第几个订阅开始获得
         * @param $len 获取多少个订阅
         */
        $sql = "SELECT t_u_id,s_date,nick_name,motto,avator FROM user_sub WHERE u_id = ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$u_id, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $subSet = array();
            while($resSet = $res->fetch_assoc()){
                $sub = array();
                $sub['t_u_id'] = $resSet['t_u_id'];
                $sub['s_date'] = $resSet['s_date'];
                $sub['nick_name'] = $resSet['nick_name'];
                $sub['motto'] = $resSet['motto'];
                $sub['avator'] = $resSet['avator'];
                $subSet[] = $sub;
            }
            return $subSet;
        }
        return false;
    }


    public function getSubNum($uid){
        $sql = "SELECT count(*) `num` FROM subscription WHERE u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if($stmt->error) {
            return false;   
        }
        return $res->fetch_assoc()['num'];
    }
    public function getSubedNum($uid){
        $sql = "SELECT count(*) `num` FROM subscription WHERE t_u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if($stmt->error) {
            return false;   
        }
        return $res->fetch_assoc()['num'];
    }


    public function checkIsSub($uid, $tuid){
        $sql = "SELECT count(*) `num` FROM subscription WHERE t_u_id = ? and u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$tuid, $uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if($stmt->error) {
            return false;   
        }
        return (int)($res->fetch_assoc()['num']) >= 1;
    }
    
}

