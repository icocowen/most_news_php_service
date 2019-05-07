<?php
/**
 * 定义Favorit的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class FavoriteDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function addFavorite($u_id, $n_id){
        /**
         * 根据u_id n_id添加收藏
         * @param u_id n_id
         */
        if(!$this->isHasNid($u_id, $n_id)){
            $sql = "INSERT INTO favorite(n_id, f_date, u_id) values(?,?,?)";
            $stmt = self::$dbHandle->stmt_init();
            $stmt->prepare($sql);
            $stmt->bind_param('sss',$n_id, $time, $u_id);
            $stmt->execute();
            if ($stmt->error) {
                return false;
            }
            return true;
        }
        return false;
    }


    public function isHasNid($u_id, $n_id){
        /**
         * 根据u_id n_id添加收藏
         * @param u_id n_id
         */
        $sql = "SELECT count(*) `num` from news where n_user_id = ? and n_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss', $u_id, $n_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if($stmt->error) {
            return false;   
        }
        return (int)($res->fetch_assoc()['num']) >= 1 ;
    }

    /**
     * 根据u_id, n_id删除收藏
     * @param u_id, n_id
     */
    public function deleteFavorite($u_id, $n_id){
       
        $sql = "DELETE FROM favorite WHERE u_id = ? and n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$u_id,$n_id);
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function getFavorite($u_id, $start=1, $len = 8){
        /**
         * 根据u_id获得对应的新闻
         * @param $u_id 用户id
         * @param $start 从第几个收藏开始获得
         * @param $len 获取多少个收藏
         */
        $sql = "SELECT n_id,t_name,n_date,n_tag,nick_name,n_title,comment_num,f_date FROM favorite_desc WHERE u_id = ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$u_id, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $favSet = array();
            while($resSet = $res->fetch_assoc()){
                $fav = array();
                $fav['n_id'] = $resSet['n_id'];
                $fav['t_name'] = $resSet['t_name'];
                $fav['n_date'] = $resSet['n_date'];
                $fav['nick_name'] = $resSet['nick_name'];
                $fav['n_title'] = $resSet['n_title'];
                $fav['comment_num'] = $resSet['comment_num'];
                $fav['f_date'] = $resSet['f_date'];
                $fav['t_id'] = $resSet['n_tag'];
                $favSet[] = $fav;
            }
            return $favSet;
        }
        return false;
    }


    public function checkFavoriteNum($uid){
        /**
         * 获得个人的news数量
         * 
         */ 
        $sql = "SELECT count(*) `num` from favorite where u_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',
                $uid
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return (int)($stmt->get_result())->fetch_assoc()['num'];
    }


    public function checkIsFavorite($uid, $nid){
        $sql = "SELECT count(*) `num` FROM favorite WHERE n_id = ? and u_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$nid, $uid);
        $stmt->execute();
        $res = $stmt->get_result();
        if($stmt->error) {
            return false;   
        }
        return (int)($res->fetch_assoc()['num']) >= 1;
    }
    
}

