<?php
class NewsControls 
{
    /**
     * 
     * 规定拉取新闻的统一接口为pullnews
     * 然后根据查询参数获取，拉取的新闻类型
     * news/news/pullnews?t=想要拉取的新闻类型
     * 
     */
    public function pullnews(){
        #获取请求的新闻类型
        try {
            $news_type = @$_GET['t']; //抑制notice提示
             
            if(isset($_GET['p']) && !empty($_GET['p'])) {
                /**
                 * 适配请求的页数p
                 * 当请求的p未设置，则请求最前面的5条
                 */
                $news_page = $_GET['p'];
            }else{
                $news_page = 1;
            }
            # 增加方法后缀防止，被测试接口
            $news_type = 'news_controls_'.$news_type.'_newss';
            return $this->$news_type($news_page);
        } catch (\Throwable $th) { //错误处理，当t值不存在时，或t值未设置时
            return new Result(ResultSet::NOT_FIND, null);  
        }
    }

    public function news_controls_all_newss($news_page){
        /**
         * 返回5条新闻all
         */
        $ns = new NewsDao();
        $res = $ns->getNewss($news_page, 8);
        if($res){
             return new Result(ResultSet::NEWS_PULL_SUCCESS,$res);
        }
        return new Result(ResultSet::NEWS_PULL_FAIL,null);
    }

    public function news_controls_technology_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('科技',$news_page);
    }

    public function news_controls_recreation_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('娱乐',$news_page);
    }

    public function news_controls_game_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('游戏',$news_page);
    }

    public function news_controls_sports_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('体育',$news_page);
    }

    public function news_controls_finance_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('财经',$news_page);
    }

    public function news_controls_funny_newss($news_page){
        return $this->news_controls_get_newss_by_newtype('搞笑',$news_page);
    }

    public function news_controls_get_newss_by_newtype($type,$news_page){
        /**
         * 根据tag_name 查找 tag_id ,根据t_id 查找 news
         */
        $ns = new NewsDao();
        $t = new TagDao();
        $t_instance = $t->tagToId($type);
        if ($t_instance->t_id) {
            $res = $ns->getNewssByTagId($t_instance->t_id,$news_page, 8);
            if($res){
                return new Result(ResultSet::NEWS_PULL_SUCCESS,$res);
            }else{
                return new Result(ResultSet::NEWS_PULL_FAIL,null);
            }
        }else{
            return new Result(ResultSet::NEWS_PULL_TYPE_NOT_FIND,null);
        }
    }

    public function pullnewsitem(){
        try {
            if(isset($_GET['nid']) && !empty($_GET['nid'])){
                $nid = $_GET['nid'];
            }
            return $this->news_controls_get_news_item($nid);
        } catch (\Throwable $th) { //错误处理，当t值不存在时，或t值未设置时
            return new Result(ResultSet::NOT_FIND, null);  
        }
    }
    public function news_controls_get_news_item($nid){
        /**
         * 具体的新闻项目
         */
        $ns = new NewsDao();
        $res = $ns->getNewsByNid($nid);
        $com = (new CommentDao())->getComments($nid);
        if ($res) {
            return new Result(ResultSet::NEWS_PULL_ITEM_SUCCESS,array('item'=>$res, 'comm'=> $com));
        }
        return new Result(ResultSet::NEWS_PULL_ITEM_FAIL, null);
        
    }


    public function getComment(){
        /**
         * 具体的新闻项目
         */

        if(isset($_GET['nid']) && !empty($_GET['nid'])){
            $nid = $_GET['nid'];
            $com = (new CommentDao())->getComments($nid);
            if ($com) {
                return new Result(ResultSet::PULL_COMMENT_SUCCESS,$com);
            }
            return new Result(ResultSet::PULL_COMMENT_FAIL, null);
        }  
    }
    

    public function pullnewstitle(){
        /**
         * 根据关键字，匹配标题，根据搜索关键字匹配news
         * pullnewstitle?t=模糊匹配的标题    返回标题集合
         * pullnewstitle?search=模糊匹配的标题  返回新闻
         */
        try {   
            if(isset($_GET['search']) && !empty(($_GET['search']))){
                $news_title = $_GET['search'];
                return $this->news_controls_get_news_title_search($news_title);
            }else{
                if(isset($_GET['k']) && !empty(($_GET['k']))){
                    $news_title = $_GET['k'];
                }else {
                    throw new Exception();
                }
                return $this->news_controls_get_news_title($news_title);
            }
            
        } catch (\Throwable $th) {
            return new Result(ResultSet::NEWS_PULL_TITLE_FAIL, null);  
        }
    }

    public function news_controls_get_news_title($news_title){
        /**
         * @return 标题集合
         */
        $ns = new NewsDao();
        $res = $ns->fuzzyMatchTitle($news_title);
        if ($res) {
            return new Result(ResultSet::NEWS_PULL_TITLE_SUCCESS,$res);
        }
        return new Result(ResultSet::NEWS_PULL_TITLE_NOT_FIND, null);
        
    }

    public function news_controls_get_news_title_search($news_title){
        /**
         * @return news集合
         */
        $ns = new NewsDao();
        $res = $ns->fuzzyMatchNewss($news_title);
        if ($res) {
            return new Result(ResultSet::NEWS_PULL_SEARCH_TITLE_SUCCESS,$res);
        }
        return new Result(ResultSet::NEWS_PULL_SEARCH_TITLE_NOT_FIND, null);
        
    }

}

