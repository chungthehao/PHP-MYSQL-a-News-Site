<?php
    // PHẢI LÀ QUẢN TRỊ VIÊN
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI CSDL phponline
    require('../includes/config.php');
    // LẤY user id cần xoá trên URL
    $id = $_GET['uid'];
    
    if($id == 6){
        // KHÔNG CHO XOÁ admin
        echo '<script>';
        echo 'alert("Bạn không thể xoá admin!");';
        echo 'location="list_user.php";';
        echo '</script>';
    }else{
        // sau khi kiểm tra, chuẩn bị này nọ xong, thì xoá
        $sql = "delete from user where userid=$id";
        mysqli_query($conn,$sql);
        header('location:list_user.php');
        exit();
    }
?>