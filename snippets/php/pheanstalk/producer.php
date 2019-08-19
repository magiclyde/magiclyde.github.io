<?php
require_once(__DIR__ .'/../vendor/autoload.php');

use Pheanstalk\Pheanstalk;

$pheanstalk = Pheanstalk::create('127.0.0.1', 11300);

$tubeName = 'email_list';

$jobData = [
    'email' => '123456@163.com',
    'message' => 'Hello World !!',
    'dtime' => date('Y-m-d H:i:s'),
];

$r = $pheanstalk->useTube( $tubeName )->put( json_encode( $jobData ) );
var_dump($r);
/*
expected output

object(Pheanstalk\Job)#7 (2) {
  ["id":"Pheanstalk\Job":private]=>
  int(1)
  ["data":"Pheanstalk\Job":private]=>
  string(83) "{"email":"123456@163.com","message":"Hello World !!","dtime":"2019-08-19 17:07:01"}"
}
*/
