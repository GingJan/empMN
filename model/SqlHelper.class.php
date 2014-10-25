<?php
	//这是一个工具类，作用是完成对数据库的操作
	class SqlHelper
	{
		public $conn;
		public $dbname="empM";
		public $username="root";
		public $password="13680enmxd";
		public $host="localhost";
		
		public function __construct()
		{
			$this->conn=mysql_connect($this->host,$this->username,$this->password);
			if(!$this->conn)
			{
				die("连接失败".mysql_error());
			}
			mysql_select_db($this->dbname,$this->conn);
		}
		
		
		
/*		//执行dql语句
		public function execute_dql($sql)
		{
			$res=mysql_query($sql,$this->conn) or die(mysql_error());
			return $res;
		}
*/		
		//执行dql语句，但是返回的是一个数组
		public function execute_dql2($sql)
		{
			$arr=array();
			
			$res=mysql_query($sql,$this->conn) or die(mysql_error());
			//把$res=>$arr 把结果集内容转到一个数组中
		
			while($row=mysql_fetch_assoc($res))//以索引数组的方式提取
			{
				$arr[]=$row;
			}
			//释放资源
			mysql_free_result($res);
			return $arr;
		}
						
		//考虑分页情况的查询，这是一个比较通用的并体现OOP编程思想的代码
		//$sql1="select * from 表名 where limit 0,6"
		//$sql2="select count(id) from 表名"
		public function execute_dql_fenye($sql1,$sql2,$fenyePage)//是否有&?
		{
			//这里我们查询了要分页显示的数据
			$res=mysql_query($sql1,$this->conn) or die(mysql_error());
			//$res导入array()
			$arr=array();
			//把$res转移到$arr
			while($row=mysql_fetch_assoc($res))
			{
				$arr[]=$row;
			}
			mysql_free_result($res);
			//把$arr赋给$fenyePage
			$fenyePage->res_array=$arr;//$arr是数组,这里直接改变了对象的res_array属性
			
			
			$res2=mysql_query($sql2,$this->conn) or die(mysql_error());
			if($row=mysql_fetch_row($res2))
			{
				$fenyePage->pageCount=ceil($row[0]/$fenyePage->pageSize);//共多少页，ceil() 函数向上取整
				$fenyePage->rowCount=$row[0];//共多少条记录（多少行）
			}
			mysql_free_result($res2);
			
			
			//把导航信息也封装到fenyePage对象中
			if ($fenyePage->pageNow>1)
			{
				$prePage=$fenyePage->pageNow-1;//$prePage上一页
				$fenyePage->navigate="<a href='{$fenyePage->gotoUrl}?pageNow=$prePage'>上一页</a>&nbsp;";
			}
			
			
			
			$page_whole=10;//整10页翻动
			$start=floor(($fenyePage->pageNow-1)/$page_whole)*$page_whole + 1;//floor函数向下(小)取整
			$index=$start;
			//整体每10页向前翻
			//如果当前pageNow在1-10页数之间，就没有向前翻动标志<<
			if($fenyePage->pageNow>$page_whole)
			{
				$fenyePage->navigate.="   <a href='{$fenyePage->gotoUrl}?pageNow=".($start-1)."'>    <<    </a>";
			}
			//输出[1][2][3][4][5][6][7][8][9][10]的标志
			for (;$start<$index+$page_whole && $start<=$fenyePage->pageCount ;$start++)
			{
				$fenyePage->navigate.="   <a href='{$fenyePage->gotoUrl}?pageNow=$start'>    [$start]    </a>";
			}
			
			
			//整体每10页向后翻动
			if($start <= $fenyePage->pageCount)
			{
				$fenyePage->navigate.="    <a href='{$fenyePage->gotoUrl}?pageNow=$start'>    >>    </a>";
			}
			
			if($fenyePage->pageNow < $fenyePage->pageCount)
			{
				$nextPage=$fenyePage->pageNow+1;
				//使用  $变量.=  可以把串连起来
				$fenyePage->navigate.="<a href='{$fenyePage->gotoUrl}?pageNow=$nextPage'>下一页</a>&nbsp;";
			}
			
			//显示当前页、共有多少页
			$fenyePage->navigate.="当前页{$fenyePage->pageNow}/共{$fenyePage->pageCount}页";
			
			//跳转条
			$fenyePage->navigate.="<form action='../controller/mancontroller_dql.php' method='get'>
			跳转到第<input type='text' name='pageNow'/>页
			<input type='submit' value='确定'>";
			
		}	
		
		//执行dml语句
		public function execute_dml($sql)
		{
			$b=mysql_query($sql,$this->conn);
			if(!$b)
			{
				return 0;//失败
			}
			else
			{
				if(mysql_affected_rows($this->conn)>0)//如果受影响的行数大于0,该函数返回上一次sql操作所影响的行数
				{
					return 1;//表示执行成功
				}
				else
				{
					return 2;//表示没有行受到影响，但也不是失败
				}
			}
		}
		
		//关闭连接的方法
		public function close_connect()
		{
			if(!empty($this->conn))
			{
				mysql_close($this->conn);
			}
		}
		
		
	}
	
	
?>