<?php
    // PHẢI LÀ ADMIN mới đc vô đây
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');

    $pid = $_GET['pid'];
    $sql = "DELETE FROM page
            WHERE page_id=$pid";
    mysqli_query($conn,$sql);
    header('location:list_page.php');
    exit();
?>
