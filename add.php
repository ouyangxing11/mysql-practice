<?php



/**
 * con [连接数据库]
 * [字符串] $name [数据库服务器登录用户名]
 * [字符串] $psd [数据库服务器登录密码]
 * [字符串] $db [数据库名]
 * [字符串] $host [数据库服务器地址]
 * [字符串] $code [数据传输编码]
 * mysqli_connect($name,$psd,$db,$host,$code)
 * 
 */
/************插入数据*************/
$_SESSION['mysqli'] = mysqli_connect('localhost','root','','news');//连接数据库
mysqli_query($_SESSION['mysqli'],'set names utf8');//设置数据传输编码
if(mysqli_connect_errno($_SESSION['mysqli'])){//报错信息
	echo '连接失败：'.mysqli_connect_errno();
}else{
	echo "连接成功";
	 $data['name'] = $_POST['title'];//获取html页面的name
	// $data['content'] = $_POST['con'];

	// $data1 = $_POST['title'];
	// $data2 = $_POST['con'];
	// $data3 = $_POST['id'];
	// var_dump($data);
	
	// var_dump($data);
	// var_dump($data1);

	// echo $sql = "insert into ne(id,name,content,cid) value (null,'$data1','$data2','$data3')";//将一条数据插入数据库
	// $res = mysqli_query($_SESSION['mysqli'],$sql);//函数执行某个针对数据库的查询。
	// if($res||$res['num_rows']>0){//如果插入数据大于0
	// 	echo "成功";
	// }
	// mysqli_close($_SESSION['mysqli']); /* Close the connection 关闭连接*/
}

/************查询数据*************/
// $_SESSION['mysqli'] = mysqli_connect('localhost','root','','news');
// mysqli_query($_SESSION['mysqli'],'set names utf8');
// if(mysqli_connect_errno($_SESSION['mysqli'])){
// 	echo '连接失败：'.mysqli_connect_errno();
// }else{
// 	echo "连接成功";
	
// 	echo $sql = "select cid from ne where cid=2";
// 	$res = mysqli_query($_SESSION['mysqli'],$sql);
// 	mysqli_fetch_assoc($res);
// 	var_dump(mysqli_fetch_assoc($res));//从结果集中取得一行作为关联数组
// 	if($res||$res['num_rows']>0){
// 		echo "成功";
// 	}
// mysqli_close($_SESSION['mysqli']); /* Close the connection 关闭连接*/
// }

/************更新数据*************/
// $_SESSION['mysqli'] = mysqli_connect('localhost','root','','news');
// mysqli_query($_SESSION['mysqli'],'set names utf8');
// if(mysqli_connect_errno($_SESSION['mysqli'])){
// 	echo '连接失败：'.mysqli_connect_errno();
// }else{
// 	echo "连接成功";
	
// 	echo $sql = "update ne set cid=1 where cid=2";
// 	$res = mysqli_query($_SESSION['mysqli'],$sql);
// 	// mysqli_fetch_assoc($res);
// 	// var_dump(mysqli_fetch_assoc($res));
// 	// if($res||$res['num_rows']>0){
// 	// 	echo "成功";
// 	// }
// mysqli_close($_SESSION['mysqli']); /* Close the connection 关闭连接*/
// }



/************删除数据*************/
// $_SESSION['mysqli'] = mysqli_connect('localhost','root','','news');
// mysqli_query($_SESSION['mysqli'],'set names utf8');
// if(mysqli_connect_errno($_SESSION['mysqli'])){
// 	echo '连接失败：'.mysqli_connect_errno();
// }else{
// 	echo "连接成功";	
// 	echo $sql = "delete from ne where cid=4";
// 	$res = mysqli_query($_SESSION['mysqli'],$sql);
// 	// mysqli_fetch_assoc($res);
// 	// var_dump(mysqli_fetch_assoc($res));
// 	// if($res||$res['num_rows']>0){
// 	// 	echo "成功";
// 	// }
// mysqli_close($_SESSION['mysqli']); /* Close the connection 关闭连接*/
// }


/****************封装******************/
/**
 * con [连接数据库]
 * [字符串] $name [数据库服务器登录用户名]
 * [字符串] $psd [数据库服务器登录密码]
 * [字符串] $db [数据库名]
 * [字符串] $host [数据库服务器地址]
 * [字符串] $code [数据传输编码]
 */
function con($name,$psd,$db,$host='localhost',$code='utf8'){
	$_SESSION['mysqli']=mysqli_connect($host,$name,$psd,$db) or die('连接数据库失败'); //连接数据库服务器并选择数据库
	mysqli_query($_SESSION['mysqli'],'set names '.$code); //设置数据传输编码
} 



/*
/**
 * getList [获取多条数据]
 * [字符串] $table [表名]
 * [字符串] $where [条件]
 * [字符串] $order [排序]
 * [字符串] $limit [截取数据]
 * [字符串] $field [要查询的字段名]
 */
function getList($table,$where='',$order='',$limit='',$field='*'){
	$sql="select $field from $table"; //组装sql语句
	if($where!='') //如果有条件
	{
		$sql.=" where $where"; //拼接条件进sql语句
	}
	if($order!='') //如果要排序
	{
		$sql.=" order by $order"; //拼接排序条件进sql语句
	}
	if($limit!='') //如果要截取数据
	{
		$sql.=" limit $limit"; //拼接截取条件进sql语句
	}
	$result=mysqli_query($_SESSION['mysqli'],$sql); //执行sql,返回值为false或对象
	if(!$result||$result->num_rows==0){ //如果错误或者没找到数据
		return false; //返回假并跳出函数
	}
	while ( $row=mysqli_fetch_assoc($result) ) { //循环解析数据
		$data[]=$row; //将解析后的每一条数据存到一个自增索引的数组中
	}
	return $data; //返回结果数组
}





/****************封装******************/
/*
/**
 * add [添加数据]
 * [字符串] $table [表名]
 * [数组] $data [数组的键对应数据表的字段名,数组的值对应字段的值]
 */
function add($table,$data){
	$feild=''; //声明保存要添加内容的字段的字符串变量
	$values=''; //声明保存对应字段的添加的内容的字符串变量
	if(!is_array($data)) //如果传的参数不是数组
	{
		return false; //返回假并跳出函数
	}
	foreach ($data as $key => $value) { //遍历数组参数
		// var_dump($key);
		$feild.=$key.','; //将键拼接上逗号后拼接进字段字符串
		$values.="'".$value."',"; //将值拼接上逗号后拼接进内容字符串

	}
	// var_dump($feild);
	// die;
	$feild=rtrim($feild,','); //调用函数rtrim去掉字符串右边的逗号(,)
	$values=rtrim($values,','); //调用函数rtrim去掉字符串右边的逗号(,)
	$sql="insert into $table ($feild) values ($values)"; //组装sql语句
	$result=mysqli_query($_SESSION['mysqli'],$sql); //执行sql,返回值为false或受影响的条数
	var_dump($result);
	if($result) //如果成功
	{
		return mysqli_insert_id($_SESSION['mysqli']); //获取新增的那一条数据的id
	}
	else //如果失败
	{
		return false; //返回假并跳出函数
	}
}

/**
 * del [删除数据]
 * [字符串] $table [表名]
 * [字符串] $where [条件]
 */
function del($table,$where){
	$sql="delete from $table where $where"; //组装sql语句
	return mysqli_query($_SESSION['mysqli'],$sql); //执行sql,返回为真或假
}


/**
 * getOne [获取一条数据]
 * [字符串] $table [表名]
 * [字符串] $where [条件]
 * [字符串] $field [要查询的字段名]
 */
function getOne($table,$where,$field='*'){
	$sql="select $field from $table where $where"; //组装sql语句
	$result=mysqli_query($_SESSION['mysqli'],$sql); //执行sql,返回值为false或对象
	if(!$result||$result->num_rows==0){ //如果错误或者没找到数据
		return false; //返回假并跳出函数
	}
	return mysqli_fetch_assoc($result); //如果正确找到数据返回解析后的结果
}
