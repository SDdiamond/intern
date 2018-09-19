<html>
<head>
<meta charset="utf-8">
<title>カレンダー</title>
</head>
<body>
<?php
include("./mission_3-1.php");

$id = $_GET['id'];
$sql = "SELECT mail FROM toregister WHERE id=$id;";
$result = $pdo -> query($sql);

foreach ($result as $row){
	$mail = $row['mail'];
}
echo "ログイン者：".$mail."<br>";
echo "入力した予定は予定日の午前0:00～午前1:00に登録メールに届きます。<br>";
echo "<h3>2018年</h3><br>";

?>

<?php

for($m=1; $m<=12; $m++){
	if($m % 4 == 1){
		for($i=$m; $i<$m+4; $i++){
			echo $i."月　　　　　　　　　";
			if($i < 10){
				echo "　";
			}else{
				echo "&nbsp";
			}
		}
		echo "<br>";
	}
	
	$year = 2018;
	$month = date($m);

	//日：0　月：1　火：2　水：3　木：4　金：5　土：6
	$week = date(w, mktime(0,0,0,$month, 1, $year));
	$last = date(j, mktime(0,0,0,$month+1, 0, $year));
	
	if($week != 0){
		$week--;
	}
	
/*	$month = array();
	$day = array();
	$num = 0;
	$sql = "SELECT * FROM schedule ORDER BY month, day;";
	$result = $pdo -> query($sql);
	$count=$result->rowCount();
	foreach($result as $row){
		$month[$num] = $row["month"];
		$day[$num] = $row["day"];
		$num++;
	}
*/	
	
	echo "<table border=\"1\" align=\"left\">";
	echo "	<tr>
			<th>月</th>
			<th>火</th>
			<th>水</th>
			<th>木</th>
			<th>金</th>
			<th>土</th>
			<th>日</th>
		</tr>
		<tr>";

	for($i=$week; $i>0; $i--){
		echo "<td><a href=\"./schedulewrite.php?id=$id&month=$m&day=$i&bool=1\"></a></td>";
	}
	$num == 0;
	for($d=1; $d<=$last; $d++){
		/*$color = "#0000ff";
		for($num=0; $num<$count; $num++){
			if($month[$num] == $m && $day[$num] == $d){
				$color="#00ff00";
				echo "$month[$num]月$day[$num]日<br>";
			}
		}*/
		echo "<td><a href=\"./schedulewrite.php?id=$id&month=$m&day=$d&bool=1\">$d</a></td>";
		echo "</font>";
		$aa=$d+$week;
		if($aa % 7 == 0){
			echo "</tr>\n<tr>";
		}
	}
	echo"	</tr>";
	
	echo "</table>";
	if($m % 4 == 0){
		echo "<br><br><br><br><br><br><br><br><br><br>";
	}
}
?>

</body>
</html>