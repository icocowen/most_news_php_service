<?php
/**
 * 有待实现，根据给定文件夹，自动扫描后缀然后自动导入php文件
 * for example:
 * 给定demo为control文件夹，然后自动扫描里面后缀的.control的文件并且自动导入
 */
########################引入基本的结果类
include_once('./result/defineResultSet.class.php');
include_once('./result/result.class.php');

########################引入实体类
include_once('./entity/user.entity.php');
include_once('./entity/tag.entity.php');
include_once('./entity/subscription.entity.php');
include_once('./entity/news.entity.php');
include_once('./entity/favorite.entity.php');
include_once('./entity/comment.entity.php');

########################导入数据库连接文件
include_once('./dao/connectDb.php');

########################引入dao file
include_once('./dao/user.dao.php');
include_once('./dao/tag.dao.php');
include_once('./dao/subscription.dao.php');
include_once('./dao/news.dao.php');
include_once('./dao/favorite.dao.php');
include_once('./dao/comment.dao.php');
include_once('./dao/notify.dao.php');

########################引入jwt
include_once('./auth/jwt.service.php');
########################引入权限验证
include_once('./auth/auth.controls.php'); 

