<?php
/**
 * 定义tag的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class TagDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function tagToId($tag){
        /**
         * 根据标签查标签id
         * @param $tag 标签
         */
        $sql = "select t_id from tag where t_name = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $tag);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $tag_instance = new Tag();
            $tag_instance->t_id = $res->fetch_assoc()['t_id'];
            $tag_instance->tag = $tag;
            return $tag_instance;
        }
        return false;
    }

    public function idToTag($tag_id){
        /**
         * 根据标签id查标签name
         * @param $tag_id 标签id
         */
        $sql = "select t_name from tag where t_id = ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s', $tag_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $tag_instance = new Tag();
            $tag_instance->t_id = $tag_id;
            $tag_instance->tag = $res->fetch_assoc()['t_name'];
            return $tag_instance;
        }
        return false;
    }
    
}

