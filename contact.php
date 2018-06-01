<?php
    require('includes/config.php');
    require_once("templates/qhonline/top.php");
	require_once("templates/qhonline/left.php");
?>
<script>
    function kiemTra(){
        n = document.myForm.txtname.value;
        e = document.myForm.txtemail.value;
        m = document.myForm.txtmess.value;
        if(n == ''){
            alert('Vui lòng nhập Tên của bạn!');
            document.myForm.txtname.focus();
            return false;
        }
        if(e == ''){
            alert('Vui lòng nhập Email của bạn!');
            document.myForm.txtemail.focus();
            return false;
        }
        if(m == ''){
            alert('Vui lòng nhập Nội dung của bạn!');
            document.myForm.txtmess.focus();
            return false;
        }
        return true;
    }
</script>
<div class="info">
    <h2>Trang liên hệ</h2>
    <?php
        if(isset($_POST['ok'])){
            if($_POST['txtname'] == NULL){
                echo 'Vui lòng nhập Tên của bạn!<br />';
            }else{
                $n = $_POST['txtname'];
            }
            if($_POST['txtemail'] == NULL){
                echo 'Vui lòng nhập Email của bạn!<br />';
            }else{
                $e = $_POST['txtemail'];
            }
            if($_POST['txtmess'] == NULL){
                echo 'Vui lòng nhập Nội dung của bạn!<br />';
            }else{
                $m = $_POST['txtmess'];
            }
            if(isset($n) && isset($e) && isset($m)){
                $to = "chungthehao@gmail.com";
                $subject = "Thu lien he tu thehao.tk";
                $message = "Email nay duoc gui tu :$n<$e> \n$m";
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "Content-Transfer-Encoding: 8bit\r\n"; 
                $headers .= "From: $n<$e> \r\n"; 
                $headers .= "X-Priority: 1\r\n"; 
                $headers .= "X-MSMail-Priority: High\r\n"; 
                $headers .= "X-Mailer: PHP/" . phpversion()."\r\n"; 
                mail($to, $subject, $message, $headers);
                echo "<font color='red'>Cám ơn vì sự phản hồi của bạn, chúng tôi sẽ phúc đáp ngay sau khi nhận được thông tin của bạn.</font>";
            }
        }
    ?>
    <form action="contact.php" method="post" name="myForm" onsubmit="return kiemTra();">
        <table>
            <tr>
                <td>Tên của bạn</td>
                <td><input type="text" name="txtname"></td>
            </tr>
            <tr>
                <td>Email của bạn</td>
                <td><input type="text" name="txtemail"></td>
            </tr>
            <tr>
                <td>Nội dung của bạn</td>
                <td><textarea name="txtmess" cols="35" rows="5"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="ok" value="Gửi"></td>
            </tr>
        </table>
    </form>
</div>
<?php
	require_once("templates/qhonline/bottom.php");
?>