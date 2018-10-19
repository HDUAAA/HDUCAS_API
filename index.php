<?php
//error_reporting(E_ALL ^ E_NOTICE); 
class HDUCAS {

    /**
     * CAS互联登录协议
     * @return null
     */
    public function CASLogin() {
        include(dirname(__FILE__).'/CAS/CAS.php');
        //phpCAS::setDebug();
        phpCAS::client(CAS_VERSION_2_0, "cas.hdu.edu.cn", 80, "cas");
        phpCAS::setNoCasServerValidation();
        phpCAS::handleLogoutRequests();
        if (phpCAS::isAuthenticated()) {  
            $user = phpCAS::getUser();
            //$attr = phpCAS::getAttributes();
            //var_dump($attr);
            $_SESSION['user'] = $user;
            require(dirname(__FILE__).'/html/ticket.phml');
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
        include(dirname(__FILE__).'/CAS/CAS.php');
        phpCAS::client(CAS_VERSION_2_0, "cas.hdu.edu.cn", 80, "cas");
        phpCAS::logout( array( 'url' => $_SERVER['HTTP_REFERER']));
        session_destroy();
        session_write_close();
    }
}

header("Content-Type: text/html; charset=UTF-8");
if (@$_REQUEST['act'] == 'logout') {
	$cas = new HDUCAS();
	$cas->CASLogout();
}
else if (@$_REQUEST['act'] == 'login') {
	$cas = new HDUCAS();
	$cas->CASLogin();
}
else {
    require(dirname(__FILE__).'/html/login.phml');
}
