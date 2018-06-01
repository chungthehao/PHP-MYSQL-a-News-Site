<?php
    // PHẢI LÀ ADMIN
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
    }
    // KẾT NỐI CSDL
    require('../includes/config.php');
    $sql = "delete from cate_news where cate_id=".$_GET['cid'];
    mysqli_query($conn,$sql);
    // VỀ LẠI TRANG list_cate.php
    header('location:list_cate.php');
    exit();
?>