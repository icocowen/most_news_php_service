<?php
/**
 * 定义result的所有code msg
 */
class ResultSet 
{
    ## 0000100 成功
    const REGISTER_SUCCESS = array('code'=>'0000101','msg'=>'注册成功');
    const LOGIN_SUCCESS = array('code'=>'0000102','msg'=>'登录成功');
    const NEWS_PULL_SUCCESS = array('code'=>'0000140','msg'=>'新闻拉取成功');
    const NEWS_PULL_ITEM_SUCCESS = array('code'=>'0000141','msg'=>'新闻项拉取成功');
    const NEWS_PULL_TITLE_SUCCESS = array('code'=>'0000142','msg'=>'新闻标题拉取成功');
    const NEWS_PULL_SEARCH_TITLE_SUCCESS = array('code'=>'0000143','msg'=>'新闻标题搜索拉取成功');
    const EMAIL_VAILD = array('code'=>'0000149','msg'=>'email有效');
    ##登录
    const USER_LOGIN_SUCCESS = array('code'=>'0000144','msg'=>'登录成功');
    const USER_LOGOUT_SUCCESS = array('code'=>'0000145','msg'=>'注销成功');
    const PULL_SALT_SUCCESS = array('code'=>'0000146','msg'=>'拉取salt成功');
    const LOGOUT_SUCCESS = array('code'=>'0000147','msg'=>'注销成功');
    const USER_REGISTER_SUCCESS = array('code'=>'0000148','msg'=>'注册成功');

    ##拉取用户信息
    #
    const PULL_OWNER_INFO_SUCCESS = array('code'=>'0000150','msg'=>'获取个人信息成功');
    const PULL_OTHER_INFO_SUCCESS = array('code'=>'0000151','msg'=>'获取他人信息成功');
    const PULL_OTHER_PRODUCT_SUCCESS = array('code'=>'0000152','msg'=>'获取他人作品成功');
    const PULL_OWNER_PRODUCT_SUCCESS = array('code'=>'0000153','msg'=>'获取个人作品成功'); 
    const PULL_PRODUCT_SUCCESS_WITHOUT = array('code'=>'0000154','msg'=>'还未有作品');
    const PULL_OWNER_FAVORITE_SUCCESS = array('code'=>'0000156','msg'=>'拉取个人收藏成功');
    const PULL_OTHER_FAVORITE_SUCCESS = array('code'=>'0000158','msg'=>'拉取他人收藏成功');
    const PULL_FAVORITE_SUCCESS_WITHOUT = array('code'=>'0000157','msg'=>'还未有收藏');

    const PULL_SUB_SUCCESS = array('code'=>'0000168','msg'=>'获得订阅数成功');
    const PULL_SUB_FAIL = array('code'=>'0000169','msg'=>'获得订阅数失败');


    const PULL_NOTIFY_SUCCESS = array('code'=>'0000194','msg'=>'获得通知成功');
    const PULL_NOTIFY_FAIL = array('code'=>'0000195','msg'=>'获得通知失败');

    const PULL_NOTIFY_NUM_SUCCESS = array('code'=>'0000198','msg'=>'获得通知数量成功');
    const PULL_NOTIFY_NUM_FAIL = array('code'=>'0000199','msg'=>'获得通知数量失败');


    const NOTIFY_SEEN_SUCCESS = array('code'=>'0000196','msg'=>'看了');
    const NOTIFY_SEEN_FAIL = array('code'=>'0000197','msg'=>'没看成');

    const ADD_SUB_SUCCESS = array('code'=>'0000180','msg'=>'订阅成功');
    const ADD_SUB_FAIL = array('code'=>'0000181','msg'=>'订阅失败');

    const HAS_SUB = array('code'=>'0000182','msg'=>'已经订阅');
    const NO_SUB = array('code'=>'0000183','msg'=>'还未订阅');


    const ADD_FAVORITE_SUCCESS = array('code'=>'0000184','msg'=>'收藏成功');
    const ADD_FAVORITE_FAIL = array('code'=>'0000185','msg'=>'收藏失败');

    const COMMENT_SUCCESS = array('code'=>'0000188','msg'=>'评论成功');
    const COMMENT_FAIL = array('code'=>'0000189','msg'=>'评论失败');

    const PULL_COMMENT_SUCCESS = array('code'=>'0000192','msg'=>'拉取评论成功');
    const PULL_COMMENT_FAIL = array('code'=>'0000193','msg'=>'拉取评论失败');

    const COMMENT_DEL_SUCCESS = array('code'=>'0000190','msg'=>'删除评论成功');
    const COMMENT_DEL_FAIL = array('code'=>'0000191','msg'=>'删除评论失败');

    const HAS_FAVORITE = array('code'=>'0000186','msg'=>'已经收藏');
    const NO_FAVORITE = array('code'=>'0000187','msg'=>'还未收藏');



    const PULL_USER_NOTE_SUCCESS = array('code'=>'0000174','msg'=>'获得note成功');
    const PULL_USER_NOTE_FAIL = array('code'=>'0000175','msg'=>'获得note失败');

    const PULL_TOTAL_SUCCESS = array('code'=>'0000178','msg'=>'获得total成功');
    const PULL_TOTAL_FAIL = array('code'=>'0000179','msg'=>'获得total失败');

    const UPDATE_USER_NOTE_SUCCESS = array('code'=>'0000176','msg'=>'更新note成功');
    const UPDATE_USER_NOTE_FAIL = array('code'=>'0000177','msg'=>'更新note失败');

    const PUBLISH_PRODUCT_SUCCESS = array('code'=>'0000172','msg'=>'发布作品成功');
    const PUBLISH_PRODUCT_FAIL = array('code'=>'0000173','msg'=>'发布作品失败');

    const PULL_SUBED_SUCCESS = array('code'=>'0000170','msg'=>'获得被订阅数成功');
    const PULL_SUBED_FAIL = array('code'=>'0000171','msg'=>'获得被订阅数失败');

    const PULL_OWNER_SUB_SUCCESS = array('code'=>'0000159','msg'=>'拉取个人订阅成功');
    const PULL_OTHER_SUB_SUCCESS = array('code'=>'0000160','msg'=>'拉取他人订阅成功');
    const PULL_SUB_SUCCESS_WITHOUT = array('code'=>'0000161','msg'=>'还没有订阅');

    #
    const PULL_OWNER_INFO_FAIL = array('code'=>'0000452','msg'=>'获取个人信息失败');
    const PULL_OTHER_INFO_FAIL = array('code'=>'0000453','msg'=>'获取他人信息失败');
    const PULL_OTHER_PRODUCT_FAIL = array('code'=>'0000454','msg'=>'获取他人作品失败');
    const PULL_OWNER_PRODUCT_FAIL = array('code'=>'0000455','msg'=>'获取个人作品失败');
    const PULL_OWNER_FAVORITE_FAIL = array('code'=>'0000456','msg'=>'拉取个人收藏失败');
    const PULL_OTHER_FAVORITE_FAIL = array('code'=>'0000457','msg'=>'拉取他人收藏失败');

    const PULL_OWNER_SUB_FAIL = array('code'=>'0000458','msg'=>'拉取个人订阅失败');
    const PULL_OTHER_SUB_FAIL = array('code'=>'0000459','msg'=>'拉取他人订阅失败');

    ##操作作品
    #
    const DEL_PRODUCT_SUCCESS = array('code'=>'0000162','msg'=>'删除作品成功');
    const DEL_FAVORITE_SUCCESS = array('code'=>'0000163','msg'=>'删除收藏成功');
    const DEL_SUB_SUCCESS = array('code'=>'0000164','msg'=>'取消订阅成功');
    const UPDATE_PRODUCT_SUCCESS = array('code'=>'0000167','msg'=>'更新作品成功');

    #
    const DEL_PRODUCT_FAIL = array('code'=>'0000460','msg'=>'删除作品失败');
    const DEL_FAVORITE_FAIL = array('code'=>'0000461','msg'=>'删除收藏失败');
    const DEL_SUB_FAIL = array('code'=>'0000462','msg'=>'取消订阅失败');
    const UPDATE_PRODUCT_FAIL = array('code'=>'0000464','msg'=>'更新作品失败');

    ## 获取新闻
    #
    const PULL_PRODUCT_ITEM_SUCCESS = array('code'=>'0000165','msg'=>'拉取作品项目成功');

    #
    const PULL_PRODUCT_ITEM_FAIL = array('code'=>'0000463','msg'=>'拉取作品项目失败');


    ## 0000400 失败
    const REGISTER_FAIL = array('code'=>'0000401','msg'=>'注册失败');
    const LOGIN_FAIL = array('code'=>'0000402','msg'=>'登录失败');

    const NOT_FIND = array('code'=>'000404','msg'=>'页面未找到');
    // const USER_NOT_FIND = array('code'=>'002365','msg'=>'用户未找到');
    const INVALID_PATH = array('code'=>'006666','msg'=>'无效路径');

    const NEWS_PULL_FAIL = array('code'=>'0000440','msg'=>'新闻拉取失败');
    const NEWS_PULL_ITEM_FAIL = array('code'=>'0000441','msg'=>'新闻项拉取失败');
    const NEWS_PULL_TYPE_NOT_FIND = array('code'=>'0000442','msg'=>'新闻类型未找到');
    const NEWS_PULL_TITLE_NOT_FIND = array('code'=>'0000443','msg'=>'没有找到新闻标题');
    const NEWS_PULL_TITLE_FAIL = array('code'=>'0000444','msg'=>'查找新闻标题失败');
    const NEWS_PULL_SEARCH_TITLE_NOT_FIND = array('code'=>'0000445','msg'=>'没有找到搜索的新闻');
    const EMAIL_INVAILD = array('code'=>'0000451','msg'=>'email无效');

    ##验证
    const USER_NOT_FIND = array('code'=>'0000446','msg'=>'用户不存在');
    const USER_PASSWORD_FAIL = array('code'=>'0000447','msg'=>'密码错误');
    const DONT_LOGIN_AGAIN = array('code'=>'0000448','msg'=>'该账号已经登录');
    const NO_LOGIN = array('code'=>'0000449','msg'=>'还未登录');
    const USER_REGISTER_FAIL = array('code'=>'0000450','msg'=>'注册失败');


    
}