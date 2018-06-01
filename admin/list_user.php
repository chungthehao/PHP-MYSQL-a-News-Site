<link rel="stylesheet" href="style.css" type="text/css">
<script>
    function xacNhan(){
        if(window.confirm('Bạn có chắc là bạn muốn xoá thành viên này không?') == false){
            return false;
        }else{
            return true;
        }
    }
</script>
<?php
    // PHẢI LÀ quản trị viên
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI CSDL phponline
    require('../includes/config.php');
?>
<table align="center">
    <tr>
        <td colspan="5"><a href="index.php">Admin Panel</a></td>
    </tr>
    <tr class="title">
        <td>STT</td>
        <td>Tên đăng nhập</td>
        <td>Cấp bậc</td>
        <td>Sửa</td>
        <td>Xoá</td>
    </tr>
    <?php
        $sql = "select * from user order by userid DESC";
        $query = mysqli_query($conn,$sql);
        $stt = 0;
        if(mysqli_num_rows($query) == 0){
            echo '<tr>';
            echo '<td colspan="5">Empty data</td>';
            echo '</tr>';
        }else{ // CÓ DỮ LIỆU THÌ ĐỔ RA            
            while($data = mysqli_fetch_assoc($query)){
                $stt++;
                echo '<tr>';
                echo "<td>$stt</td>";
                echo "<td>".$data['username']."</td>";
                if($data['level'] == 1){
                    echo "<td>Thành viên</td>";
                }else if($data['level'] == 2){
                    echo "<td style='color:red;'>Quản trị viên</td>";
                }                
                echo "<td><a href='edit_user.php?uid=".$data['userid']."'>Sửa</a></td>";
                echo "<td><a onclick='return xacNhan();' href='del_user.php?uid=".$data['userid']."'>Xoá</a></td>";
                echo '</tr>';
            }
        }
    ?>
</table>