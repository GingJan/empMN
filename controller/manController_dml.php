<?php
	require_once '../model/manModel.class.php';
	$manModel=new ManModel();
	require_once '../libs/Smarty.class.php';
	$smarty=new Smarty();
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	$smarty->template_dir='../templates/'; 
	$smarty->compile_dir='../templates_c/'; 
	
	$code=$_REQUEST['code'];
	
	switch($code)
	{	
		//code=1就是增加新用户
		case 1: 
			require_once '../model/new_user.class.php';//这个放在这里和放在外面有什么区别
			$new_user=new New_user();
			$new_user->name=$_POST['userName'];
			$new_user->password=$_POST['userpwd'];
			$exe_code=$manModel->add_user($new_user);
			if($exe_code == 1)
			{
				$smarty->assign("notice","增加成功");
			}
			else 
			{
				$smarty->assign("notice","增加失败");
			}
			$smarty->display("manUI.html");
			break;
		
		//code=2 修改用户信息
		case 2:
			$id=$_GET['id']; 
			$mod_name=$_GET['mod_name'];
			$exe_code=$manModel->modify_user($id,$mod_name);//修改用户信息
			if($exe_code == 1)
			{
				$smarty->assign("notice","修改信息成功");
			}
			else 
			{
				$smarty->assign("notice","修改信息失败");
			}
			$smarty->display("manUI.html");
			break;
				
		case 3:// 删除用户
			$id=$_GET['id'];
			$exe_code=$manModel->delete_user($id);
			if($exe_code == 1)
			{
				$smarty->assign("notice","删除成功");
			}
			else 
			{
				$smarty->assign("notice","删除失败");
			}
			$smarty->display("manUI.html");
			break;
			
	
	}
?>