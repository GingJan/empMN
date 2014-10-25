<?php

	require_once '../libs/Smarty.class.php'; 
	require_once '../model/manModel.class.php';
	$manID=$_POST['manID'];
	$manpwd=$_POST['manpwd'];
	
	//创建smarty对象
	$smarty=new Smarty();
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	$smarty->template_dir='../templates/'; 
	$smarty->compile_dir='../templates_c/'; 
	

	$manModel=new ManModel();
	$res=$manModel->manLogin($manID,$manpwd);
	//var_dump($res);
	//exit;
	if(!empty($res))//如果$res为true
	{
		$smarty->assign("name",$res[0]['name']);//注意，这里因为$res是二维数组，所以要有[0]
		$smarty->display("manUI.html");
	}
	else
	{
		$smarty->assign("err",1);
		$smarty->display("manLogin.html");
	}

?>