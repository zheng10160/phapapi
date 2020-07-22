<?php
namespace App;

function hello() {
    return 'Hey, man~';
}

function show_json($code, $mess='', $data=array()) {
    header('Content-Type: application/json; charset=utf-8');
    $json = array('code'=>$code, 'message'=>$mess, 'data'=>$data);
    return $json;
}
