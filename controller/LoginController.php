<?php
	require_once '../libs/Smarty.class.php';
	$smarty=new Smarty;
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	$smarty-> template_dir='../templates/'; 
	$smarty-> compile_dir='../templates_c/'; 
	
	$smarty->display("manLogin.html");
?>