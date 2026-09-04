<?php
function isAdmin($cookle=''){
    global $DB,$password_hash;
    if(empty($cookle)){
        return false;
    }
    $cookles = str_ireplace(' ', '+', $cookle);
    $token = authcode(daddslashes($cookles), 'DECODE', SYS_KEY);
	list($username, $session, $expiretime) = explode("\t", $token);
	$memberinfo = $DB->getRow("SELECT * FROM `api_admin` WHERE `username`='{$username}' and `status`='1' limit 1");
	if(empty($memberinfo)){
	    return false;
	}else{
    	$sessions = md5($memberinfo['username'].$memberinfo['password'].$password_hash);
    	if($expiretime < time()){
    	    return false;
    	}else{
        	if($session==$sessions) {
        		return $memberinfo;
        	}else{
        	    return false;
        	}
    	}
	}
}
?>