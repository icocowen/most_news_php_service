<?php
/**
 * 定义Comment的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class CommentDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function addComment($comm){
        /**
         * 根据comm添加评论 
         * @param comm Comment对象
         */
 
        $sql = "INSERT INTO comment(n_id, u_id, c_text) values(?,?,?)";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sss',
            $comm->n_id,
            $comm->u_id,
            $comm->c_content
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function deleteComment($u_id, $n_id){
        /**
         * 根据u_id, n_id删除评论
         * @param u_id, n_id
         */
        $sql = "DELETE FROM comment WHERE u_id = ? and n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$u_id,$n_id);
        $stmt->execute();
        if (!$stmt->affected_rows) {
            return false;
        }
        return true;
    }

    public function getComments($n_id, $start=1, $len = 5){
        /**
         * 根据n_id获得具体的所有的评论信息
         * @param n_id 新闻id
         * @param start 从第几个comm_user开始获得
         * @param len 获取多少个comm_user
         */
        $sql = "SELECT id,u_id,c_date,c_text,nick_name FROM comm_user WHERE n_id = ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$n_id, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $comSet = array();
            while($resSet = $res->fetch_assoc()){
                $com = new Comment();
                $com->c_id = $resSet['id'];
                $com->u_id = $resSet['u_id'];
                $com->c_date = $resSet['c_date'];
                $com->c_content = $resSet['c_text'];
                $com->nick_name = $resSet['nick_name'];
                $com->n_id = $n_id;
                $comSet[] = $com;
            }
            return $comSet;
        }
        return false;
    }

}

