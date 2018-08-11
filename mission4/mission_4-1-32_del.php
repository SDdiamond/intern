<html>
<head>
<meta charset="utf-8">
<title>入力フォｰム</title>
</head><body>

<form action="./mission_4-1-32_write.php" method="post">
<p>
<!--　名　前　：<input type="text" name="name"><br> -->
　コメント：<input type="text" name="comment" placeholder="ここへ入力"><br>
<!-- パスワード：<input type="password" name="pass"><br> -->
<input type="submit" value="入力">
<input type="hidden" name="time">
<?php
	$name = $_POST["name"];
	$hpass = $_POST["hpass"];
	echo "<input type=\"hidden\" name=\"name\" value=\"$name\">";
	echo "<input type=\"hidden\" name=\"hpass\" value=\"$hpass\">";
?>
</form> 
</p>

<p>
<form action="./mission_4-1-32_del.php" method="post">
　削除番号：<input type="number" name="del"><br>
パスワード：<input type="password" name="pass"><br>
<?php
	$name = $_POST["name"];
	$hpass = $_POST["hpass"];
	echo "<input type=\"hidden\" name=\"name\" value=\"$name\">";
	echo "<input type=\"hidden\" name=\"hpass\" value=\"$hpass\">";
?>
<input type="submit" value="削除">
</form>
</p>

<p>
<form action="./mission_4-1-32_edit.php" method="post">
　編集番号：<input type="number" name="edit"><br>
<!--　名　前　：<input type="text" name="ename"><br> -->
　コメント；<input type="text" name="ecomment" placeholder="ここに入力"><br>
パスワード：<input type="password" name="pass"><br>
<?php
	$name = $_POST["name"];
	$hpass = $_POST["hpass"];
	echo "<input type=\"hidden\" name=\"name\" value=\"$name\">";
	echo "<input type=\"hidden\" name=\"hpass\" value=\"$hpass\">";
?>
<input type="submit" value="編集">
</form>
</p>




<?php
$del = $_POST["del"] ;
$pass = $_POST["pass"];
$hpass = $_POST["hpass"];
$filename = "mission_4-1.txt";

include("./mission_3-1.php");

$sql="SELECT * FROM bbord;";
$stmh=$pdo->prepare($sql);
$stmh->execute();
$count=$stmh->rowCount();



if($count != 0){
	foreach ($stmh as $row){
		if($pass == $row['pass'] AND $del == $row['id']){
				$sql = "DELETE FROM bbord WHERE id = \"$del\";" ;
				$result=$pdo->prepare($sql);
				$result->execute();
		}
	}
}


$sql="SELECT * FROM bbord ORDER BY id;";
$result=$pdo->prepare($sql);
$result->execute();
$count=$result->rowCount();
//echo $count."<br>";

if($count != 0){
	foreach ($result as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['msg'].',';
		echo $row['time'].'<br>';
	}
}



?>

</body>
</html>


