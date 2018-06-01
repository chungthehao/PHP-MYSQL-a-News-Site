<?php
session_start();

    if(isset($_POST['ok'])){ // KHI NGTA BẤM NÚT 'Dang nhap'
        // Kiểm tra, xử lý dữ liệu nhập từ FORM
        if($_POST['txtuser'] == NULL){
            echo "Ban chua nhap username!<br />";
        }else{
            $u = $_POST['txtuser'];
        }
        if($_POST['txtpass'] == NULL){
            echo "Ban chua nhap password!<br />";
        }else{
            $p = md5($_POST['txtpass']);
        } // HẾT phần kiểm tra, xử lý dữ liệu
        // KHI ĐẦY ĐỦ DỮ LIỆU RỒI THÌ KIỂM TRA, SO SÁNH VỚI CSDL
        if(isset($u) && isset($p)){
            require('../includes/config.php'); // kết nối csdl
            $sql = "select * from user where username='$u' and password='$p'";
            $query = mysqli_query($conn,$sql);
            $row = mysqli_num_rows($query);
            if($row == 0){
                echo 'Username hoặc password không chính xác!';
            }else{ // TẠO SESSION CHO NGTA QUA LẠI CÁC TRANG WEB CỦA WEBSITE MÌNH
                $data = mysqli_fetch_assoc($query);
                $_SESSION['ses_username'] = $u;
                $_SESSION['ses_userid'] = $data['userid'];
                $_SESSION['ses_level'] = $data['level'];
                header('location:index.php');
                exit();
            }
        }
    }
?>
<form action="#" method="post">
    Username: <input type="text" name="txtuser" size="25" /><br />
    Password: <input type="password" name="txtpass" size="25" /><br />
    <input type="submit" name="ok" value="Dang nhap" />
</form>