<?php
class mCAS {

    /**
     * CAS互联登录协议
     * @return null
     */
    public function CASLogin() {
        include(dirname(__FILE__).'/CAS-1.3.5/CAS.php');
        //phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, "cas.hdu.edu.cn", 80, "cas");
        phpCAS::setNoCasServerValidation();
        phpCAS::handleLogoutRequests();
        if (phpCAS::isAuthenticated()) {
            $user = phpCAS::getUser();
            $_SESSION['user'] = $user;
          	//window.location.href="getUserInfo.php"；
          	echo "当前用户名：".$user."<br><a href='./getUserInfo.php'>资料</a><br><a href='./index.php?act=logout' target='_self'>退出</a>";
        }
        else {
            phpCAS::forceAuthentication();
        }
    }

    /**
     * CAS同步退出协议
     * @return null
     */
    public function CASLogout() {
        include(dirname(__FILE__).'/CAS-1.3.5/CAS.php');
        phpCAS::client(CAS_VERSION_2_0, "cas.hdu.edu.cn", 80, "cas");
        phpCAS::logout( array( 'url' => $_SERVER['HTTP_REFERER']));
        session_destroy();
        session_write_close();
    }
}

header("Content-Type: text/html; charset=UTF-8");
if (@$_REQUEST['act'] == 'logout') {
	$cas = new mCAS();
	$cas->CASLogout();
}
else if (@$_REQUEST['act'] == 'login') {
	$cas = new mCAS();
	$cas->CASLogin();
}
else {
	echo "欢迎使用杭电CAS登陆测试程序，点此<a href='./index.php?act=login' target='_self'>登陆</a>。";
}
