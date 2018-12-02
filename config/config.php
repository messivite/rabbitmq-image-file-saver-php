<?php

/*
 * RabbitMQ and other config datas..
*/
$GLOBALS['config'] = array(
    "rabbitmq" => array(
        "username" => 'root',
        "password" => 'root',
        'host' => 'localhost',
        'port' => 5672
    ),
);
class Config
{
    public static function get($key = null)
    {
        $keys = explode("/", $key);
        $tmpref = &$GLOBALS['config'];
        $return = null;
        while($key=array_shift($keys)){
            if(array_key_exists($key,$tmpref)){
              $return = $tmpref[$key];
              $tmpref = &$tmpref[$key];
            } else {
              return null;//not found
            }
        }
        return $return;//found
    }
}


?>