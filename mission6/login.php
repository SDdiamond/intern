<html>
<head>
<meta charset="utf-8">
<title>入力フォｰム</title>
</head>
<body>

<?php
$mail = $_POST['mail'];
$pass = $_POST['pass'];

include("./mission_3-1.php");

$bool = 0;
$sql = 'SELECT * FROM toregister';
$results = $pdo -> query($sql);
if($results != null){
	foreach ($results as $row){
		if($mail == $row['mail'] && $pass == $row['pass'] && $row['parmit'] == 'Yes'){
			$bool = 1;
			echo "ログイン成功。";
			$id = $row['id'];
			header("Location: ./calendar.php?id=$id");
			exit();
			break;
		}
	}
}
if($bool == 0){
	echo "ログイン失敗<br>";
	echo "<a href=\"./login.html\">もどる</a><br>";
}
?>

</body>
</html>

