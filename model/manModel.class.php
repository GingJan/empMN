<?php
	require_once 'SqlHelper.class.php';
	class ManModel
	{	
		//登陆验证
		function manLogin($manID,$manpwd)
		{		
			//数据库验证
			$sql="select * from manlist where id=$manID";
			$sqlHelper=new SqlHelper();
			$res=array();
			$res=$sqlHelper->execute_dql2($sql);//得到一个数组
			//比对密码
			if(!empty($res[0]['id']))//如果存在此ID
			{
				if(md5($manpwd) == $res[0]['password'])
				{
					$sqlHelper->close_connect();//关闭连接
					return $res;//返回一个数组
				}
			}
			$sqlHelper->close_connect();//关闭连接
			return false;
		}
		
		//获取用户信息并且显示
		function getUserInfo($fenyePage)//传一个对象进来（对象传递为引用传递）
		{
			//创建一个SqlHelper对象实例
			$sqlHelper=new SqlHelper();
			$sql1="select id,name from userList limit ".($fenyePage->pageNow-1)*$fenyePage->pageSize.",".$fenyePage->pageSize;
			$sql2="select count(id) from userList";
			$sqlHelper->execute_dql_fenye($sql1,$sql2,$fenyePage);
			$sqlHelper->close_connect();
		}
		
		
		//对用户进行增删改
		function add_user($new_user)//增加
		{
			$sqlHelper=new SqlHelper();
			$sql="insert into userList(name,password) values('".$new_user->name."','".md5($new_user->password)."')";
			$code=$sqlHelper->execute_dml($sql);
			$sqlHelper->close_connect();
			return $code; 
		}
		function modify_user($user_id,$mod_name)//修改
		{
			$sqlHelper=new SqlHelper();
			$sql="update userList SET name='".$mod_name."' where id=".$user_id."";  //需要再加个 双引号 吗？
			$exe_code=$sqlHelper->execute_dml($sql);
			$sqlHelper->close_connect();
			return $exe_code; 
		}
		function delete_user($id)//删除
		{
			$sqlHelper=new SqlHelper();
			$sql="delete from userList where id=$id";
			$exe_code=$sqlHelper->execute_dml($sql);
			$sqlHelper->close_connect();
			return $exe_code;
		}
	}
?>
	