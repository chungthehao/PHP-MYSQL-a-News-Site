<?php
    // PHẢI LÀ ADMIN mới đc vô đây
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');

    if(isset($_POST['ok'])){
        if($_POST['txttitle'] == NULL){
            echo 'Vui lòng nhập tên trang!<br />';
        }else{
            $t = $_POST['txttitle'];
        }
        if($_POST['txtinfo'] == NULL){
            echo 'Vui lòng nhập nội dung của trang!<br />';
        }else{
            $i = $_POST['txtinfo'];
        }
        if(isset($t) && isset($i)){
            $sql = "INSERT INTO page(page_title,page_info) VALUES('$t','$i')";
            mysqli_query($conn,$sql);
            header('location:list_page.php');            
            exit();
        }
    }
?>
<script src="ckeditor/ckeditor.js"></script>
<a href="index.php">Quay lại Admin Panel</a><br />
<table>
    <form action="add_page.php" method="post">
        <tr>
            <td>Tên trang</td>
            <td><input type="text" name="txttitle"></td>
        </tr>
        <tr>
            <td>Nội dung</td>
            <td><textarea name="txtinfo" cols="30" rows="8"></textarea></td>
        </tr>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'txtinfo' );
</script>
        <tr>
            <td></td>
            <td><input type="submit" name="ok" value="Thêm trang"></td>
        </tr>
    </form>
</table>