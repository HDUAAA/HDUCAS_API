<?php
$localurl = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$ticket = !empty(htmlspecialchars(@$_REQUEST['ticket'])) ? htmlspecialchars($_REQUEST['ticket']) : null;
if (is_null($ticket)) {
	header("Location: http://cas.hdu.edu.cn/cas/login?service=".urlencode($localurl));
  	exit();
}
$res = file_get_contents("http://cas.hdu.edu.cn/cas/serviceValidate?ticket=".$ticket."&service=".urlencode($localurl));
header("Content-Type: text/xml; charset=UTF-8");
echo $res;
exit();