<?php

	require_once '../libs/Smarty.class.php';
	$smarty=new Smarty();
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	$smarty->template_dir='../templates/'; 
	$smarty->compile_dir='../templates_c/'; 
	
	$id=$_GET['id']; 
	$name=$_GET['name'];
	$smarty->assign("id",$id);
	$smarty->assign("name",$name);
	$smarty->display("modify_info_UI.html");
?>