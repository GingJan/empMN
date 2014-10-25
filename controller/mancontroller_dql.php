<?php
	require_once '../model/manModel.class.php';
	require_once '../model/FenyePage.class.php';
	require_once '../libs/Smarty.class.php';
	$manModel=new ManModel();
	$fenyePage=new FenyePage();
	
	$smarty=new Smarty;
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	$smarty-> template_dir='../templates/'; 
	$smarty-> compile_dir='../templates_c/'; 
	
	$fenyePage->pageSize=3;//每页显示3条信息
	$fenyePage->gotoUrl='../controller/mancontroller_dql.php';
	
	if(empty($_GET['pageNow']))
	{
		$fenyePage->pageNow=1;//默认当前为第1页（初始化）
	}
	
	
	if(!empty($_GET['pageNow']))
	{
		$fenyePage->pageNow=$_GET['pageNow'];
	}
	
	$manModel->getUserInfo($fenyePage);
	if($fenyePage->pageNow > $fenyePage->pageCount)
	{
		$smarty->assign("err_code",1);
	}
	$smarty->assign("arr",$fenyePage);
//	var_dump($fenyePage->res_array);

//	foreach ($fenyePage->res_array as $value ){
//		echo $value["id"];
//		echo $value["name"];
//	}
	$smarty->display("showInfo.html");//调用了smarty模板显示后，本文件的下面的代码仍然执行
	
//	echo "<pre>";
//	print_r($fenyePage->res_array);
//	echo "</pre>";
//	exit();
?>