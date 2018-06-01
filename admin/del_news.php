<?php
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login:php');
        exit();
    }
    // LẤY id của news TRÊN URL khi ngta bấm vào 'xoá' trong trang list_news
    $id = $_GET['nid'];
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');
    $sql = "DELETE FROM news WHERE news_id=$id";
    mysqli_query($conn,$sql);
    header('location:list_news.php');
    exit();
?>