<?php
    // PHẢI LÀ ADMIN mới đc vô đây
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');
    // Lấy nhiều lần nha!
    $pid = $_GET['pid'];

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
            $sql = "UPDATE page SET page_title='$t',page_info='$i' WHERE page_id=$pid";
            mysqli_query($conn,$sql);
            header('location:list_page.php');            
            exit();
        }
    }

    // ĐỔ DỮ LIỆU RA FORM CHO NGTA SỬA
    $sql = "SELECT * FROM page
            WHERE page_id=$pid";
    $query = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($query);
?>
<script src="ckeditor/ckeditor.js"></script>
<a href="list_page.php">Quay lại danh sách page</a><br />
<table>
    <form action="edit_page.php?pid=<?php echo $data['page_id'];?>" method="post">
        <tr>
            <td>Tên trang</td>
            <td><input type="text" name="txttitle" value="<?php echo $data['page_title'];?>" /></td>
        </tr>
        <tr>
            <td>Nội dung</td>
            <td><textarea name="txtinfo" cols="30" rows="8"><?php echo $data['page_info'];?></textarea></td>
        </tr>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'txtinfo' );
</script>
        <tr>
            <td></td>
            <td><input type="submit" name="ok" value="Lưu"></td>
        </tr>
    </form>
</table>