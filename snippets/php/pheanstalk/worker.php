<?php
ini_set('default_socket_timeout', 86400*7);
ini_set( 'memory_limit', '256M' );

// 消费队列消息
require_once(__DIR__.'/../vendor/autoload.php');

use Pheanstalk\Pheanstalk;

$pheanstalk = Pheanstalk::create('127.0.0.1', 11300);

$tubeName = 'email_list';

while ( true )
{
    // 获取队列信息, reserve 阻塞获取
    $job = $pheanstalk->watch( $tubeName )->ignore( 'default' )->reserve();
    if ( $job !== false )
    {
        $data = $job->getData();
        var_dump($data);
        /*
        expected output:
        
        string(83) "{"email":"123456@163.com","message":"Hello World !!","dtime":"2019-08-19 17:07:01"}"
        ...
        */
        
        /* TODO 逻辑操作 */
        
        /* 处理完成，删除 job */
        $pheanstalk->delete( $job );
    }
}
