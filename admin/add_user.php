<?php
    // LÀ admin MỚI ĐƯỢC THÊM THÀNH VIÊN hoặc QUẢN TRỊ VIÊN
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // KHI BẤM 'Thêm'
    if(isset($_POST['ok'])){
        if($_POST['txtuser'] == NULL){
            echo 'Vui lòng nhập tên đăng nhập!<br />';
        }else{
            $u = $_POST['txtuser'];
        }
        if($_POST['txtpass1'] == NULL){
            echo 'Vui lòng nhập mật khẩu!<br />';
        }else{
            // KIỂM TRA 2 LẦN NHẬP mật khẩu CÓ TRÙNG NHAU K?
            if($_POST['txtpass1'] != $_POST['txtpass2']){
                echo 'Mật khẩu và xác nhận mật khẩu phải giống nhau!<br />';
            }else{
                $p = md5($_POST['txtpass1']);
            }
        }
        $l = $_POST['level'];
        // KHI ĐÃ NHẬP THÔNG TIN ĐẦY ĐỦ THÌ LÀM
        if(isset($u) && isset($p) && isset($l)){
            // KẾT NỐI CSDL
            require('../includes/config.php');
            // KIỂM TRA ĐÃ TỒN TẠI TÊN ĐĂNG NHẬP NÀY CHƯA
            $sql = "select * from user where username='$u'";
            $query = mysqli_query($conn,$sql);
            if(mysqli_num_rows($query) == 1){
                echo 'Tên đăng nhập này đã tồn tại, vui lòng chọn tên khác!<br />';
            }else{ // NẾU CHƯA CÓ THÌ THÊM VÀO CSDL
                $sql = "INSERT INTO user(username,password,level) VALUES ('$u','$p','$l')";
                mysqli_query($conn,$sql);
                header('location:list_user.php');
            }
        }
    }
?>
<a href="index.php">Quay lại Admin Panel</a><br />
<form action="add_user.php" method="post">
    Cấp bậc: 
    <select name="level">
        <option value="1">Thành viên</option>
        <option value="2">Quản trị viên</option>
    </select><br />
    Tên đăng nhập: <input type="text" name="txtuser" /><br />
    Mật khẩu: <input type="password" name="txtpass1" /><br />
    Xác nhận mật khẩu: <input type="password" name="txtpass2" /><br />
    <input type="submit" name="ok" value="Thêm" />
</form>