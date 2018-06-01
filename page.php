<?php
/*
 * page.php dùng để quản lý trang (trang giới thiệu, trang dịch vụ)
 * CSDL nằm trong bảng page
 */
    require('includes/config.php');
    require_once("templates/qhonline/top.php");
	require_once("templates/qhonline/left.php");
    $pid = $_GET['pid'];
    $sql = "SELECT * FROM page WHERE page_id=$pid";
    $query = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($query);
?>
<div class="info">
<?php
		
    echo "<div class='news'>";
        echo "<h1 style='background:orange;color:white;margin:3px;'>".$data['page_title']."</h1>";
        echo $data['page_info'];
        
        echo "<div class='cls'></div>"; 
    echo "</div>";
		
?>
</div>
<?php
	require_once("templates/qhonline/bottom.php");
?>