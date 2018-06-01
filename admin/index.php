<?php
    session_start();
    // Tài khoản đăng nhập phải là admin mới đc vào đây
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
    }
?>
<link rel="stylesheet" href="style.css" type="text/css" />
<table align='center'>
    <tr class='title'><td colspan='7'>Chào bạn, <?php echo $_SESSION['ses_username'];?></td></tr>
    <tr>
        <td><a href='add_cate.php'>Thêm chuyên mục</a></td>
        <td><a href='list_cate.php'>Quản lý chuyên mục</a></td>
        <td><a href='add_news.php'>Thêm tin tức</a></td>
        <td><a href='list_news.php'>Quản lý tin tức</a></td>
        <td><a href='add_user.php'>Thêm thành viên</a></td>
        <td><a href='list_user.php'>Quản lý thành viên</a></td>
        
    </tr>
    <tr>
        <td colspan='2'><a href='add_page.php'>Thêm trang</a></td>
        <td colspan='2'><a href='list_page.php'>Quản lý trang</a></td>
        <td colspan='2'><a href='logout.php'>Đăng xuất</a></td>
    </tr>
</table>
