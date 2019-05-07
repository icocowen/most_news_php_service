<?php
/**
 * 定义news的增删查改
 * DBHANDLE 是全局的数据库句柄
 */
class NewsDao{
    static $dbHandle;
    public function __construct(){
        global $DBHANDLE;
        self::$dbHandle = $DBHANDLE; //获得全局dbHandle
    }

    public function addNews($news){
        /**
         * 根据news添加新闻 
         * 
         * @param news News对象
         */
        $sql = "INSERT INTO news(n_id, n_user_id, n_title,n_content,n_tag) values(?,?,?,?,?)";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssss',
            $news->n_id,
            $news->u_id,
            $news->n_title,
            $news->article,
            $news->tag_id
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;
    }

    public function deleteNews($u_id, $n_id){
        /**
         * 根据u_id, n_id删除新闻
         * 需要把评论也删除
         * @param u_id, n_id
         */
        self::$dbHandle->begin_transaction(); //开始事务
        $csql = "DELETE FROM comment WHERE  n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($csql);
        $stmt->bind_param('s',$n_id);
        $stmt->execute();

        $nsql = "DELETE FROM news WHERE n_user_id = ? and n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($nsql);
        $stmt->bind_param('ss',$u_id,$n_id);
        $stmt->execute();
        if ($stmt->error) {
            $dbHandle->rollback(); //执行错误回滚
            return false;
        }
        self::$dbHandle->commit(); //提交事务
        return true;
    }

    public function getNewssByUID($u_id, $start=1, $len = 6){
        /**
         * 根据u_id获得新闻
         * comment_num FROM news_desc
         * @param u_id u_id
         * @param start 从第几个news开始获得
         * @param len 获取多少个news
         */
        $sql = "SELECT n_id, n_date,t_name, n_title,nick_name,n_content,n_tag,comment_num FROM news_desc WHERE n_user_id = ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$u_id, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $newsSet = array();
            while($resSet = $res->fetch_assoc()){
                $news = new News();
                $news->n_title = $resSet['n_title'];
                $news->u_id = $u_id;
                $news->n_date = $resSet['n_date'];
                $news->article = $resSet['n_content'];
                $news->tag_id = $resSet['n_tag'];
                $news->n_id = $resSet['n_id'];
                $news->comment_num = $resSet['comment_num'];
                $news->nike_name = $resSet['nick_name'];
                $news->t_name = $resSet['t_name'];
                $newsSet[] = $news;
            }
            return $newsSet;
        }
        return false;
    }
    
    public function getNewsByNid($n_id){
        /**
         * 根据n_id获得新闻
         * comment_num FROM news_desc
         * @param u_id n_id
         */
        $sql = "SELECT n_user_id, n_date,t_name,motto, n_title,nick_name,n_content,n_tag,comment_num FROM news_desc WHERE n_id= ? ";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$n_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $resSet = $res->fetch_assoc();
            $news = new News();
            $news->n_title = $resSet['n_title'];
            $news->u_id = $resSet['n_user_id'];
            $news->n_date = $resSet['n_date'];
            $news->article = $resSet['n_content'];
            $news->tag_id = $resSet['n_tag'];
            $news->n_id = $n_id;
            $news->comment_num = $resSet['comment_num'];
            $news->nike_name = $resSet['nick_name'];
            $news->t_name = $resSet['t_name'];
            $news->motto = $resSet['motto'];
            return $news;
        }
        return false;
    }


    public function getUidByNid($n_id){
        /**
         * 根据n_id获得新闻
         * comment_num FROM news_desc
         * @param u_id n_id
         */
        $sql = "SELECT n_user_id FROM news WHERE n_id= ? ";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',$n_id);
        $stmt->execute();
        if($stmt->error) {
            return false;
        }
        return ($stmt->get_result())->fetch_assoc()['n_user_id'];
    }

    public function getNewss($start=1, $len = 8){
        /**
         * 获得规定长度的新闻
         * @param start 从第几个news开始获得
         * @param len 获取多少个news
         */
        $sql = "SELECT n_id, n_date,t_name,n_user_id,nick_name, n_title,n_content,n_tag,comment_num FROM news_desc LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('ii', $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $newsSet = array();
            while($resSet = $res->fetch_assoc()){
                $news = new News();
                $news->n_title = $resSet['n_title'];
                $news->u_id = $resSet['n_user_id'];
                $news->n_date = $resSet['n_date'];
                $news->article = $resSet['n_content'];
                $news->tag_id = $resSet['n_tag'];
                $news->n_id = $resSet['n_id'];
                $news->comment_num = $resSet['comment_num'];
                $news->nike_name = $resSet['nick_name'];
                $news->t_name = $resSet['t_name'];
                $newsSet[] = $news;
            }
            return $newsSet;
        }
        return false;
    }


    public function getNewssByTagId($tag_id, $start=1, $len = 8){
        /**
         * 根据tag_id获得具体的所有的新闻信息
         * @param u_id u_id
         * @param start 从第几个news开始获得
         * @param len 获取多少个news
         */
        $sql = "SELECT n_id, n_date,t_name,n_user_id,nick_name, n_title,n_content,comment_num FROM news_desc WHERE n_tag = ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$tag_id, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $newsSet = array();
            while($resSet = $res->fetch_assoc()){
                $news = new News();
                $news->n_title = $resSet['n_title'];
                $news->u_id = $resSet['n_user_id'];
                $news->n_date = $resSet['n_date'];
                $news->article = $resSet['n_content'];
                $news->tag_id = $tag_id;
                $news->n_id = $resSet['n_id'];
                $news->comment_num = $resSet['comment_num'];
                $news->nike_name = $resSet['nick_name'];
                $news->t_name = $resSet['t_name'];
                $newsSet[] = $news;
            }
            return $newsSet;
        }
        return false;
    }

    public function updateNews($news){
        /**
         * 更新新闻 可更新的的字段为n_title n_content n_tag
         * 
         * @param news News对象
         */ 
        $sql = "UPDATE news SET n_title=?,n_content=?,n_tag=? where n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ssss',
            $news->n_title,
            $news->article,
            $news->tag_id,
            $news->n_id
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return true;

    }

    public function checkNid($nid){
        /**
         * 
         * 
         * @param news News对象
         */ 
        $sql = "SELECT count(*) `num` from news where n_id=?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('s',
                $nid
        );
        $stmt->execute();
        if ($stmt->error) {
            return false;
        }
        return (int)($stmt->get_result())->fetch_assoc()['num'] >= 1;

    }



    public function fuzzyMatchTitle($title_Key, $start=1, $len = 5){
        /**
         * 根据给定的title_key,模糊匹配返回title 5条
         * @param title_Key 标题关键字
         */
        $sql = 'SELECT n_title FROM news where n_title LIKE ? LIMIT ?, ?';
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $title_Key = '%'.$title_Key.'%';
        $start = ($start - 1) * $len;
        $stmt->bind_param('sii',$title_Key,$start,$len);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            $titleSet = array();
            while($resSet = $res->fetch_assoc()){
                $titleSet[] = $resSet['n_title'];
            }
            return $titleSet;
        }
        return false;
    }

    public function fuzzyMatchNewss($title_Key, $start=1, $len = 8){
        /**
         * 根据给定的title_key,模糊匹配返回news 5条
         * @param title_Key 标题关键字
         */
        $sql = "SELECT n_id, n_date,t_name,n_tag,n_user_id,nick_name, n_title,n_content,comment_num FROM news_desc WHERE n_title like ? LIMIT ? , ?";
        $stmt = self::$dbHandle->stmt_init();
        $stmt->prepare($sql);
        $start = ($start - 1) * $len;
        $title_Key = '%'.$title_Key.'%';
        $stmt->bind_param('sii',$title_Key, $start, $len);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $newsSet = array();
            while($resSet = $res->fetch_assoc()){
                $news = new News();
                $news->n_title = $resSet['n_title'];
                $news->u_id = $resSet['n_user_id'];
                $news->n_date = $resSet['n_date'];
                $news->article = $resSet['n_content'];
                $news->tag_id = $resSet['n_tag'];
                $news->n_id = $resSet['n_id'];
                $news->comment_num = $resSet['comment_num'];
                $news->nike_name = $resSet['nick_name'];
                $news->t_name = $resSet['t_name'];
                $newsSet[] = $news;
            }
            return $newsSet;
        }
        return false;

    }


    public function checkNewsNum($uid){
        /**
         * 获得个人的news数量
         * 
         */ 
        $sql = "SELECT count(*) `num` from news where n_user_id=?";
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
 
}

