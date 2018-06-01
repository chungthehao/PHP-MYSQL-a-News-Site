<?php
    // KẾT NỐI CSDL
    require('../includes/config.php');
    // LÀ quản trị viên mới được sửa
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('location:login.php');
        exit();
    }
    // Lần 1: lấy từ URL khi ngta bấm 'Sua' tại trang list_user.php
    // Lần 2: lấy từ URL khi ngta bấm 'Lưu' tại trang này
    $id = $_GET['uid'];
    // KHI ngta bấm 'Lưu', xử lý dữ liệu từ FORM
    if(isset($_POST['ok'])){
        if($_POST['txtuser'] == NULL){
            echo 'Vui lòng nhập tên đăng nhập cần sửa!<br />';
        }else{
            // KIỂM TRA tên đăng nhập có bị TRÙNG với những tên CÒN LẠI hay k?
            $tmp = $_POST['txtuser'];
            $sql = "select * from user where username='$tmp' and userid<>'$id'";
            $query = mysqli_query($conn,$sql);
            if(mysqli_num_rows($query) == 1){
                echo 'Tên đăng nhập đã tồn tại, vui lòng nhập tên khác!<br />';
            }else{
                $u = $tmp;
            }
        }
        if($_POST['txtpass1'] != $_POST['txtpass2']){
            echo 'Mật khẩu và xác nhận mật khẩu phải giống nhau!<br />';
        }else{ // MẬT KHẨU === XÁC NHẬN MẬT KHẨU
            if($_POST['txtpass1'] == NULL){
                $p = 'khongDoi';
            }else{
                $p = md5($_POST['txtpass1']);
            }
        }
        $l = $_POST['level']; // HẾT phần xử lý dữ liệu FORM
        if(isset($u) && isset($p) && isset($l)){
            if($p == 'khongDoi'){ // k có đổi password
                $sql = "update user set username='$u',level='$l' where userid='$id'";
            }else{ // có đổi password
                $sql = "update user set username='$u',level='$l',password='$p' where userid='$id'";
            }
            mysqli_query($conn,$sql); // THỰC HIỆN UPDATE DỮ LIỆU 
            header('location:list_user.php');
            exit();
        }
    }

    // LẤY DỮ LIỆU ĐỔ RA FORM
    $sql = "select * from user where userid='$id'";
    $query = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($query);
    
?>
<a href="list_user.php">Quay lại danh sách user</a><br />
<form action="edit_user.php?uid=<?php echo $data['userid'];?>" method="post">
    Cấp bậc: 
    <select name="level">
        <option value="1" <?php if($data['level']==1) echo 'selected';?>>Thành viên</option>
        <option value="2" <?php if($data['level']==2) echo 'selected';?>>Quản trị viên</option>
    </select><br />
    Tên đăng nhập: <input type="text" name="txtuser" value="<?php echo $data['username'];?>" /><br />
    Mật khẩu: <input type="password" name="txtpass1" /><br />
    Xác nhận mật khẩu: <input type="password" name="txtpass2" /><br />
    <input type="submit" name="ok" value="Lưu" />
</form>