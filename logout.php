<?php

session_start();
session_unset();
session_destroy();

if(isset($_COOKIE['member_login']))
{
	setCookie("member_login", "", time()-3600);
}

if(isset($_COOKIE['user_name']))
{
	setCookie("user_name", "", time()-3600);
}

if(isset($_COOKIE['id']))
{
	setCookie("id", "", time()-3600);
}

header("location: login.php");
exit();

?>