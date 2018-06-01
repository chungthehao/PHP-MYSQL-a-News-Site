<?php
	require('./includes/config.php');
	require_once("templates/qhonline/top.php");
	require_once("templates/qhonline/left.php");
?>
<div id="info">
    <?php
        // Lấy cid ở URL NHIỀU LẦN
        // 1) Khi ở trang chủ, nhấp vào các chuyên mục
        // 2) Khi nhấp qua lại giữa các phân trang
        $cid = $_GET['cid'];
        // -----PHÂN TRANG-----
        $newsPer1Page = 3; // 1 TUỲ MÌNH CHỌN
        
        // Tối ưu, chỉ tính $totalPages ở lần đầu thôi, khi qua lại giữa các phân trang
        // thì không cần nữa
        if(isset($_GET['tP'])){
            $totalPages = $_GET['tP']; // 3
        }else{
            // trường hợp chạy lần đầu
            $sql = "SELECT news_id,news_title,news_info,news_img
            FROM news
            WHERE news_check='Y' AND cate_id=$cid
            ORDER BY news_id DESC";
            $query = mysqli_query($conn,$sql);
            $totalNews = mysqli_num_rows($query); // 2
            $totalPages = ceil($totalNews/$newsPer1Page); // 3
        }

        if(isset($_GET['nNP'])){ // Khi ĐÃ nhấp qua lại giữa các phân trang
            $newsPointer = $_GET['nNP']; // 4
        }else{ // Khi mới vô chuyên mục này, chưa nhấp qua lại giữa các phân trang thì con trỏ trang bằng 0 (tham số thứ 1 trong LIMIT)
            $newsPointer = 0; 
        }

		$sql = "SELECT news_id,news_title,news_info,news_img
				FROM news
				WHERE news_check='Y' AND cate_id=$cid
				ORDER BY news_id DESC
                LIMIT $newsPointer,$newsPer1Page";
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
    <div align="center">
        <?php
            $currentPage = ($newsPointer/$newsPer1Page)+1;
            // Phần trang 'Trước'
            if($currentPage > 1){
                // Con trỏ tin cho phần trang 'Trước'
                $newNewsPointer = $newsPointer - $newsPer1Page;
                echo "<a href='categorie.php?cid=$cid&nNP=$newNewsPointer&tP=$totalPages'> Trước </a>";
            }
            // Phần trang 'Sau'
            if($currentPage < $totalPages){
                // Con trỏ tin cho phần trang 'Sau'
                $newNewsPointer = $newsPointer + $newsPer1Page;
                echo "<a href='categorie.php?cid=$cid&nNP=$newNewsPointer&tP=$totalPages'> Sau </a>";
            }
        ?>
    </div>
</div>
<?php
	require_once("templates/qhonline/bottom.php");
?>