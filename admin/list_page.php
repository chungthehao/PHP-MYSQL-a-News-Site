<?php
    // PHẢI LÀ ADMIN mới đc vô đây
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');
?>
<link href="style.css" rel="stylesheet" type="text/css" />
<script>
    function xacNhan(){
        if(window.confirm('Bạn có chắc là bạn muốn xoá trang này không?') == false){
            return false;
        }else{  
            return true;
        }
    }
</script>
<table width='400px' align="center">
    <tr>
        <td colspan="4"><a href="index.php">Admin Panel</a></td>
    </tr>
    <tr class="title">
        <td>STT</td>
        <td>Tên trang</td>
        <td>Sửa</td>
        <td>Xoá</td>
    </tr>
    <?php
        $sql = "SELECT page_id,page_title
                FROM page
                ORDER BY page_id DESC";
        $query = mysqli_query($conn,$sql);
        $stt = 0;
        if(mysqli_num_rows($query) == 0){
            echo "<tr><td colspan='4'>Chưa có dữ liệu</td></tr>";
        }else{
            while($data = mysqli_fetch_assoc($query)){
                $stt++;
                echo "<tr>";
                echo "<td>$stt</td>";
                echo "<td>".$data['page_title']."</td>";
                echo "<td><a href='edit_page.php?pid=".$data['page_id']."'>Sửa</a></td>";
                echo "<td><a onclick='return xacNhan();' href='del_page.php?pid=".$data['page_id']."'>Xoá</a></td>";
                echo "</tr>";
            }
        }
    ?>
</table>