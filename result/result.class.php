<?php
/**
 * 定义返回结果的格式类
 * @var resSet: ResultSet 包含了code msg
 * @var data: 返回的数据
 */
 class Result{
    public $code;
    public $msg;
    public $data;

     public function __construct($resSet, $data){
         $this->code = $resSet['code'];
         $this->msg = $resSet['msg'];
         $this->data = $data;
     }
 }