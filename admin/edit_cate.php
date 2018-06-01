<?php
    // PHẢI LÀ ADMIN
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
    }
    // Lần 1 : Lấy trên URL khi ngta nhấp vào 'Sua'
    // Lần 2 : Lấy trên URL khi ngta nhấp vào 'Save'
    $id = $_GET['cid'];

    // Khi ngta bấm 'Save'
    if(isset($_POST['ok'])){
        if($_POST['txtcate'] == NULL){
            echo 'Vui long nhap Categorie name.<br />';
        }else{
            $new_title = $_POST['txtcate'];
        }
        if(isset($new_title)){ // ngta có nhập
            require('../includes/config.php');
            $sql2 = "update cate_news set cate_title='$new_title' where cate_id=$id";
            mysqli_query($conn,$sql2);
            header('location:list_cate.php');
            exit();
        }
    }

    // KẾT NỐI CSDL ĐỂ ĐỔ RA form
    require('../includes/config.php');
    $sql = "select * from cate_news where cate_id='$id'";
    $query = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($query);

?>
<a href="list_cate.php">Quay lại danh sách chuyên mục</a><br />
<form action="edit_cate.php?cid=<?php echo $data['cate_id'];?>" method="post">
    Categorie name: <input type="text" name="txtcate" value="<?php echo $data['cate_title'];?>" /><br />
    <input type="submit" name="ok" value="Save" />
</form>