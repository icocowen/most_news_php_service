<?php
/**
 * 定义Comment的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class NotifyDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function addNotify($trig_uid, $tar_uid,$type , $tar_nid = null ){
        $this->checkNotify();
        $sql = "INSERT INTO notify(trigger_uid, target_uid, type, nid) values(?,?,?,?)";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ssis',
            $trig_uid,
            $tar_uid,
            $type,
            $tar_nid
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

   
    public function getNotify($u_id){
       
        $sql = 'SELECT noid,u_id,nick_name,target_nickname,n_title,n_id,type FROM notify_desc_after WHERE target_uid = ?  and trigger_date > unix_timestamp(now()) - 259200  order by trigger_date desc limit ?';
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $len = 40;
        $stmt->bind_param('si',$u_id, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $notifySet = array();
            while($resSet = $res->fetch_assoc()){
                $notify = array();
                $notify['noid'] = $resSet['noid'];
                $notify['u_id'] = $resSet['u_id'];
                $notify['nick_name'] = $resSet['nick_name'];
                $notify['target_nickname'] = $resSet['target_nickname'];
                $notify['n_title'] = $resSet['n_title'];
                $notify['n_id'] = $resSet['n_id'];
                $notify['type'] = $resSet['type'];
                $notifySet[] = $notify;
            }
            return $notifySet;
        }
        return false;
    }

    public function setSeen($uid, $noid){
        
        $sql = "UPDATE notify set seen='1' where target_uid=? and id=? ";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('si',$uid, $noid);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function getNotifyNum($uid){
        
        $sql = "SELECT count(*) `num` from notify where target_uid=? and seen = '0'";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($stmt->error) {
            return false;
        }
        return $res->fetch_assoc()['num'];
    }


    public function checkNotify(){
        
        $sql = "DELETE from notify where seen='1' and  trigger_date < unix_timestamp(now()) - 604800";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }


    
}

