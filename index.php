<?php
/**
 * all function most basice module 
 * 
 * @author: iwen
 * @date: 19/04/28
 */
$fullPath = $_SERVER['REQUEST_URI'];
header("Access-Control-Allow-Credentials:true"); 
header("Access-Control-Allow-Origin: http://localhost:4200");
// header("Access-Control-Allow-Origin: http://localhost:8080");
header("Content-Type:application/json; charset=UTF-8"); 

try {
    $firstIndex = @strpos($fullPath, "index.php");
    $realPath = @substr($fullPath, $firstIndex+10);

    #need path format like 模块/类名/方法名
    #slice realPath to module  class method
    $targetArray = @explode('/', $realPath);
    $moduleName = @$targetArray[0];
    $className = @$targetArray[1];
    $methodName = @explode('?', $targetArray[2])[0];

    # 导入必须的前导包
    @include_once('include.php'); 

    #声明全局数据库处理句柄
    #析构函数在exit的时候自动运行
    $dbClass = new ConnectDB();
    global $DBHANDLE;
    $DBHANDLE = @$dbClass->dbHandle;

    #according to modulename and classname include php file
    @include_once($moduleName.'/'.strtolower($className).'.controls.php');

    #实例化类
    $className = @ucfirst($className.'Controls');

    $targetClass = new $className();
    #php 访问静态成员或方法为:: 访问实例成员或方法->
    $result = @$targetClass->$methodName();
    exit(json_encode($result));
} catch (\Throwable $th) {
    exit(json_encode(new Result(ResultSet::INVALID_PATH, null)));
}

