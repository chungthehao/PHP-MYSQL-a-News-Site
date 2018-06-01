<?php
    // KẾT NỐI CSDL phponline
    require('../includes/config.php');
    // CHỈ CÓ quản trị viên MỚI ĐC VÔ ĐÂY
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // Lần 1 : LẤY news_id (nid) thì URL khi ngta bấm 'Sửa' ở trang list_news
    // Lần 2 : LẤY news_id (nid) thì URL khi ngta bấm 'Sửa tin' ở trang NÀY
    $id = $_GET['nid'];
    // KHI NGTA BẤM nút 'Sửa tin', xử lý dữ liệu ngta muốn sửa từ FORM
    if(isset($_POST['ok'])){        
        $caid = $_POST['cate'];
        $uid = $_SESSION['ses_userid']; // id của người sửa tin
                                        // KHÔNG CẦN SỬA, nếu muốn giữ nguyên là ng ban đầu
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
        // THỰC HIỆN SỬA nếu đầy đủ thông tin
        if(isset($t) && isset($a) && isset($i) && isset($f)){
            // Chuẩn bị lệnh SQL để SỬA dữ liệu trong CSDL
            if($img == '!khongCoHinh!'){
                $sql = "UPDATE news
                        SET news_title='$t',news_author='$a',news_info='$i',news_full='$f',news_check='$ch',cate_id='$caid'
                        WHERE news_id='$id'";
            }else{
                move_uploaded_file($_FILES['img']['tmp_name'],"../data/$img");
                $sql = "UPDATE news 
                        SET news_img='$img',news_title='$t',news_author='$a',news_info='$i',news_full='$f',news_check='$ch',cate_id='$caid'
                        WHERE news_id='$id'";
            }
            mysqli_query($conn,$sql);
            header('location:list_news.php');
            exit();
        }
    }
    // ĐỔ DỮ LIỆU RA FORM ĐỂ NGTA SỬA
    $sql = "SELECT * FROM news WHERE news_id='$id'";
    $query = mysqli_query($conn,$sql);
    $data2 = mysqli_fetch_assoc($query);
?>
<script src="ckeditor/ckeditor.js"></script>
<a href="list_news.php">Quay lại danh sách tin</a><br />
<table>
<form action="edit_news.php?nid=<?php echo $id;?>" method="post" enctype="multipart/form-data">
    <tr>
        <td>Chuyên mục:</td>
        <td>
            <select name="cate">
                <?php
                    $sql = "select * from cate_news";
                    $query = mysqli_query($conn,$sql);
                    while($data1 = mysqli_fetch_assoc($query)){
                        if($data1['cate_id'] == $data2['cate_id']){
                            echo "<option SELECTED='SELECTED' value=".$data1['cate_id'].">".$data1['cate_title']."</option>";
                        }else{
                            echo "<option value=".$data1['cate_id'].">".$data1['cate_title']."</option>";
                        }
                    }                 
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Tiêu đề:</td>
        <td><input type="text" name="txttitle" value="<?php echo $data2['news_title'];?>" /></td>
    </tr>
    <tr>
        <td>Tác giả:</td>
        <td><input type="text" name="txtauthor" value="<?php echo $data2['news_author'];?>" /></td>
    </tr>
    <tr>
        <td>Mô tả:</td>
        <td><textarea name="txtinfo" cols="30" rows="5"><?php echo $data2['news_info'];?></textarea></td>
    </tr>
    <tr>
        <td>Chi tiết:</td>
        <td><textarea name="txtfull" cols="30" rows="15"><?php echo $data2['news_full'];?></textarea></td>
    </tr>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'txtfull' );
    </script>
    <tr>
        <td>Kiểm duyệt:</td>
        <td>
            <input type="radio" name="check" value="Y" <?php if($data2['news_check']=='Y') echo 'checked="checked"';?> />Yes
            <input type="radio" name="check" value="N" <?php if($data2['news_check']=='N') echo 'checked="checked"';?> />No       
        </td>
    </tr>
    <?php
        if($data2['news_img'] != NULL){
            echo "<tr>";
            echo "<td>Hình cũ</td>";
            echo '<td><img width="200px" src="../data/'.$data2['news_img'].'" alt="Hình cũ"></td>';
            echo "</tr>";
        }
    ?>
    <tr>
        <td>Hình ảnh:</td>
        <td><input type="file" name="img" /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="ok" value="Sửa tin" /></td>
    </tr>
</form>
</table>