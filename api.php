<?php
header("Content-Type: text/json; charset=UTF-8");
$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);
$localurl = $_SERVER['HTTPS']?'https://':'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$ticket = !empty(htmlspecialchars(@$_REQUEST['ticket'])) ? htmlspecialchars($_REQUEST['ticket']) : null;
if (is_null($ticket)) {
	header("Location: http://cas.hdu.edu.cn/cas/login?service=".urlencode($localurl));
  	exit();
}
$res = file_get_contents("http://cas.hdu.edu.cn/cas/serviceValidate?ticket=".$ticket."&service=".urlencode($localurl));
if(explode('"',explode('value="',$res)[3])[0]==null||explode('"',explode('value="',$res)[3])[0]==""){
	$userinfo["state"]=403;
}
else{
	$userinfo["state"]=200;
	$userinfo["name"]=explode('"',explode('value="',$res)[1])[0];
	$userinfo["sid"]=explode('"',explode('value="',$res)[3])[0];
	$userinfo["sex"]=explode('"',explode('value="',$res)[6])[0];
	$userinfo["institute"]=explode('"',explode('value="',$res)[7])[0];
	$userinfo["class"]=explode('"',explode('value="',$res)[8])[0];
}
$userinfo = json_encode($userinfo);

echo $jsoncallback . "(" . $userinfo . ")";
exit();