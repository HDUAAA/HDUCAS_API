<?php
$ticket = !empty(htmlspecialchars(@$_REQUEST['ticket'])) ? htmlspecialchars($_REQUEST['ticket']) : null;
if (is_null($ticket)) {
	header("Location: http://cas.hdu.edu.cn/cas/login?service=".urlencode("http://localhost/hducas/getUserInfo.php"));
  	exit();
}
$res = file_get_contents("http://cas.hdu.edu.cn/cas/serviceValidate?ticket=".$ticket."&service=".urlencode("http://localhost/hducas/getUserInfo.php"));
header("Content-Type: text/xml; charset=UTF-8");
echo $res;
//echo "当前用户名：".$user."<br><a href='./index.php' target='_self'>返回</a>";
exit();