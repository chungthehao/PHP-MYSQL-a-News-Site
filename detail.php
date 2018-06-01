<?php
	require('./includes/config.php');
	require_once("templates/qhonline/top.php");
	require_once("templates/qhonline/left.php");
?>
<div id="info">
    <?php
        $id = $_GET['nid'];
		$sql = "SELECT news_id,news_title,news_full,news_img,cate_id
				FROM news
				WHERE news_check='Y' AND news_id=$id";
		$query = mysqli_query($conn,$sql);
		if(mysqli_num_rows($query) == 0){
			echo "Chưa có tin nào cả."; // CẨN THẬN THÔI!
		}else{
			$data = mysqli_fetch_assoc($query);
            
            /* Bắt đầu echo chi tiết tin ra */
            echo "<div class='news'>";

            // Tiêu đề
            echo "<h1>".$data['news_title']."</h1>";

            // Hình ảnh
            if($data['news_img'] != ''){
                echo "<img src='data/".$data['news_img']."' width='130px' align='left' />";
            }

            // xử lý dữ liệu trước khi xuất
            $tmp = $data['news_full'];
            // $tmp = str_replace("\n","<br />",$tmp); // xử lý xuống hàng
            // $tmp = str_replace("[b]","<b>",$tmp); // xử lý BBcode forum
            // $tmp = str_replace("[/b]","</b>",$tmp); // xử lý BBcode forum
            // $tmp = str_replace("[/b]","</b>",$tmp); // xử lý BBcode forum
            $tmp = str_replace(":((","<img src='data/icon1.gif' />",$tmp); // xử lý mặt cười YAHOO
            $tmp = str_replace("fuck","f**k",$tmp); // xử lý chữ "fuck"
            echo $tmp; // xuất phần mô tả

            echo "<div class='cls'></div>"; 
            echo "</div>";
            /* Kết thúc việc đổ ra chi tiết tin */
        }
        // Đổ bản tin khác cùng chuyên mục, cũ hơn
        $cid = $data['cate_id'];
        $sql = "SELECT news_id,news_title
                FROM news
                WHERE cate_id=$cid AND news_check='Y' AND news_id<$id
                ORDER BY news_id DESC
                LIMIT 0,8";
        $query = mysqli_query($conn,$sql);
        if(mysqli_num_rows($query) != 0){
            echo "<h3>Bản tin khác</h3>";
            echo "<ul>";
            while($data2 = mysqli_fetch_assoc($query)){
                echo "<li><a href='detail.php?nid=".$data2['news_id']."'>".$data2['news_title']."</a></li>";
            }
            echo "</ul>";
        }
	?>
</div>
<?php
	require_once("templates/qhonline/bottom.php");
?>