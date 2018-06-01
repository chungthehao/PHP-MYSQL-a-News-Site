<?php
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
    }
    if(isset($_POST['ok'])){
        if($_POST['txtcate'] == NULL){
            echo 'Vui lòng nhập tên chuyên mục.<br />';
        }else{
            $c = $_POST['txtcate'];
        }
        if(isset($c)){
            require('../includes/config.php');
            $sql = "INSERT INTO cate_news(cate_title) VALUES('$c')";
            mysqli_query($conn,$sql);
            header('location:list_cate.php');
            exit();
        }
    }
?>
<a href="index.php">Quay lại Admin Panel</a><br />
<form action='add_cate.php' method='post'>
    Tên Chuyên Mục: <input type="text" name='txtcate' /><br />
    <input type="submit" name='ok' value='Submit' />
</form>