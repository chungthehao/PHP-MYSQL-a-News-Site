<link rel="stylesheet" href="style.css" type="text/css" />
<style>
    a {
        display:inline-block;
        padding:4px 8px;
    }
</style>
<script>
    function xacNhan(){
        if(confirm('Ban co chac la ban muon xoa chuyen muc nay khong?')==false){
            // NGƯỜI TA cancle
            return false;
        }else{ // NGƯỜI TA ok
            return true;
        }
    }
</script>
<?php
    // Là admin (level=2) mới được vô đây
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
    }
    // kết nối với csdl phponline
    require('../includes/config.php');

// ---PHÂN TRANG---... CẦN 6 tham số nha!
    $recordPer1Page = 3; // 1 - Tuỳ chọn
    // Nếu tồn tại $_GET['tP'], tức là ngta đã load trang 1 lần rồi,
    // mình không cần truy vấn CSDL để tìm $totalPages nữa!
    if(isset($_GET['tP'])){
        $totalPages = $_GET['tP'];
    }else{
        $sql = "select * from cate_news";
        $query = mysqli_query($conn,$sql);
        $totalRecords = mysqli_num_rows($query); // 2
        $totalPages = ceil($totalRecords/$recordPer1Page); // 3
    }
    // Nếu tồn tại $_GET['nPP'], tức là ngta nhấp vào Trước, Sau
    // hoặc các trang, thì cập nhật lại $pagePointer
    if(isset($_GET['nPP'])){
        $pagePointer = $_GET['nPP']; // 4
    }else{
        $pagePointer = 0; // 4
    }
    $currentPage = ($pagePointer/$recordPer1Page)+1; // 5

    // Thực hiện lấy dữ liệu từ bảng cate_news show ra table
    $sql = "select * from cate_news limit $pagePointer,$recordPer1Page";
    $query = mysqli_query($conn,$sql);
?>
    <table align='center'>
        <tr>
            <td colspan="4"><a href="index.php">Admin Panel</a></td>
        </tr>
        <tr class='title'>
            <td>STT</td>
            <td>Chuyen muc tin</td>
            <td>Sua</td>
            <td>Xoa</td>
        </tr>
<?php
    $stt = 0;
    if(mysqli_num_rows($query) == 0){
        echo "<tr><td colspan='4'>Empty data</td></tr>";
    }else{
        while($data = mysqli_fetch_assoc($query)){
            $stt++;
            echo '<tr>';
            echo "<td>$stt</td>";
            echo "<td>".$data['cate_title']."</td>";
            echo "<td><a href='edit_cate.php?cid=".$data['cate_id']."'>Sua</a></td>";
            echo "<td><a onclick='return xacNhan();' href='del_cate.php?cid=".$data['cate_id']."'>Xoa</a></td>";
            echo '</tr>';
        }
    }
?>
</table>
<div align="center">
    <?php
        if($currentPage != 1){
            $newPagePointer = $pagePointer - 3; // 6
            echo "<a href='list_cate.php?nPP=0&tP=$totalPages'>Đầu</a>";
            echo "<a href='list_cate.php?nPP=$newPagePointer&tP=$totalPages'>Trước</a>";
        }
        // Dùng $begin, $end để PHÂN ĐOẠN trang
        $totalPagesDisplayed = 5; // số lẻ nha!
        $w = ($totalPagesDisplayed - 1) / 2;
        $begin = $currentPage - $w;
        if($begin < 1) $begin = 1;
        $end = $currentPage + $w;
        if($end > $totalPages) $end = $totalPages;
        
        for($i = $begin; $i <= $end; $i++){
            $newPagePointer = ($i - 1) * $recordPer1Page; // 6
            if($i == $currentPage){
                echo "<b style='display:inline-block;background:#666;color:white;border-radius:5px;padding:4px 8px;'>$i</b>";
            }else{
                echo "<a href='list_cate.php?nPP=$newPagePointer&tP=$totalPages'>$i</a>";
            }
        }
        if($currentPage != $totalPages){
            $newPagePointer = $pagePointer + 3; // 6
            $lastPagePointer = ($totalPages-1)*$recordPer1Page;
            echo "<a href='list_cate.php?nPP=$newPagePointer&tP=$totalPages'>Sau</a>";
            echo "<a href='list_cate.php?nPP=$lastPagePointer&tP=$totalPages'>Cuối</a>";
        }
    ?>
</div>