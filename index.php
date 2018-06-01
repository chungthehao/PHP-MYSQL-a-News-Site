<?php
	require('./includes/config.php');
	require_once("templates/qhonline/top.php");
	require_once("templates/qhonline/left.php");
?>
<div id="info">
	<?php
		$sql = "SELECT news_id,news_title,news_info,news_img
				FROM news
				WHERE news_check='Y'
				ORDER BY news_id DESC
				LIMIT 0,6";
		$query = mysqli_query($conn,$sql);
		if(mysqli_num_rows($query) == 0){
			echo "Chưa có tin nào cả."; // CẨN THẬN THÔI!
		}else{
			while($data = mysqli_fetch_assoc($query)){
				echo "<div class='news'>";
				echo "<h1>".$data['news_title']."</h1>";
				if($data['news_img'] != ''){
					echo "<img src='data/".$data['news_img']."' width='130px' align='left' />";
				}
				echo $data['news_info']; // xuất phần mô tả
				echo "<p align='right'>...<a href='detail.php?nid=".$data['news_id']."'>Đọc tiếp</a></p>";
				echo "<div class='cls'></div>"; 
				echo "</div>";
			}
		}
	?>
</div>
<?php
	require_once("templates/qhonline/bottom.php");
?>