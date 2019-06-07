<?php
require 'vendor/autoload.php';
use Plivo\XML\Response;
use Plivo\RestClient;
use Plivo\Exceptions\PlivoRestException;

try{
	$dst = $_REQUEST['TO'];
    $src = $_REQUEST['CLID'];
    if(! $src) {
        $src = $_REQUEST['From'];
    }
    $cname = $_REQUEST['CallerName'];
    $response = new Response();
    if($dst) {
        $dial_params = array();
        if($src)
            $dial_params['callerId'] = $src;
        if($cname)
            $dial_params['callerName'] = $cname;
        $dial = $response->addDial($dial_params);
        if(substr($dst, 0,4) == "sip:") {
            $dial->addUser($dst);
        } else {
        $dial->addNumber($dst);
        }
    } else {
        $response->addHangup();
    }
    //header("Content-Type: text/xml");
    echo($response->toXML());
    //print_r($response);
}catch (PlivoRestException $ex) {
    print_r($ex);
} 