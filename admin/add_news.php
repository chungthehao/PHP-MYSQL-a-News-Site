<?php
    // KẾT NỐI CSDL phponline
    require('../includes/config.php');
    // CHỈ CÓ quản trị viên MỚI ĐC VÔ ĐÂY
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // XỬ LÝ DỮ LIỆU FORM khi ngta bấm nút 'Thêm tin'
    if(isset($_POST['ok'])){        
        $caid = $_POST['cate'];
        $uid = $_SESSION['ses_userid']; // id của người thêm tin
        if($_POST['txttitle'] == NULL){
            echo 'Vui lòng nhập tiêu đề tin!<br />';
        }else{
            $t = $_POST['txttitle'];
        }
        if($_POST['txtauthor'] == NULL){
            echo 'Vui lòng nhập tên tác giả!<br />';
        }else{
            $a = $_POST['txtauthor'];
        }
        if($_POST['txtinfo'] == NULL){
            echo 'Vui lòng nhập mô tả ngắn gọn cho bản tin!<br />';
        }else{
            $i = $_POST['txtinfo'];
        }
        if($_POST['txtfull'] == NULL){
            echo 'Vui lòng nhập chi tiết bản tin!<br />';
        }else{
            $f = $_POST['txtfull'];
        }
        $ch = $_POST['check'];
        if($_FILES['img']['name'] == NULL){
            $img = '!khongCoHinh!';
        }else{
            $img = $_FILES['img']['name'];
        } // HẾT phần xử lý dữ liệu FORM
        // THỰC HIỆN nếu đầy đủ thông tin
        if(isset($t) && isset($a) && isset($i) && isset($f)){
            // Chuẩn bị lệnh SQL để thêm dữ liệu vào CSDL
            if($img == '!khongCoHinh!'){
                $sql = "INSERT INTO news(news_title,news_author,news_info,news_full,news_check,userid,cate_id) 
                        VALUES          ('$t',      '$a',       '$i',     '$f',     '$ch',     '$uid','$caid')";
            }else{
                move_uploaded_file($_FILES['img']['tmp_name'],"../data/$img");
                $sql = "INSERT INTO news(news_title,news_author,news_info,news_full,news_check,news_img,userid,cate_id) 
                        VALUES          ('$t',      '$a',       '$i',     '$f',     '$ch',     '$img',  '$uid','$caid')";
            }
            mysqli_query($conn,$sql);
            header('location:list_news.php');
            exit();
        }
    }
?>
<script src="ckeditor/ckeditor.js"></script>
<a href="index.php">Quay lại Admin Panel</a><br />
<table>
<form action="add_news.php" method="post" enctype="multipart/form-data">
    <tr>
        <td>Chuyên mục:</td>
        <td>
            <select name="cate">
                <?php
                    $sql = "select * from cate_news";
                    $query = mysqli_query($conn,$sql);
                    while($data = mysqli_fetch_assoc($query)){
                        echo "<option value=".$data['cate_id'].">".$data['cate_title']."</option>";
                    }                 
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Tiêu đề:</td>
        <td><input type="text" name="txttitle" /></td>
    </tr>
    <tr>
        <td>Tác giả:</td>
        <td><input type="text" name="txtauthor" /></td>
    </tr>
    <tr>
        <td>Mô tả:</td>
        <td><textarea name="txtinfo" cols="30" rows="5"></textarea></td>
    </tr>
    <tr>
        <td>Chi tiết:</td>
        <td><textarea name="txtfull" cols="30" rows="15"></textarea></td>
    </tr>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'txtfull' );
    </script>
    <tr>
        <td>Kiểm duyệt:</td>
        <td>
            <input type="radio" name="check" value="Y" />Yes
            <input type="radio" name="check" value="N" checked="checked" />No       
        </td>
    </tr>
    <tr>
        <td>Hình ảnh:</td>
        <td><input type="file" name="img" /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="ok" value="Thêm tin" /></td>
    </tr>
</form>
</table>