<script>
    function xacNhan(){
        if(window.confirm('Bạn có chắc là bạn muốn xoá tin này không?') == false){
            return false;
        }else{
            return true;
        }
    }
</script>
<link rel="stylesheet" type="text/css" href="./style.css" />
<?php
    // LÀ admin MỚI ĐC VÔ ĐÂY
    session_start();
    if($_SESSION['ses_level'] != 2){
        header('localtion:login:php');
        exit();
    }
    // KẾT NỐI VỚI CSDL phponline
    require('../includes/config.php');

?>
<table align='center'>
    <tr>
        <td colspan="8"><a href="index.php">Admin Panel</a></td>
    </tr>
    <tr class='title'>
        <td>STT</td>
        <td>Tiêu đề</td>
        <td>Chuyên mục</td>
        <td>Hình ảnh</td>
        <td>Kiểm duyệt</td>
        <td>Người thêm</td>
        <td>Sửa</td>
        <td>Xoá</td>
    </tr>
    <tr>
        <?php
            $sql = "SELECT news_id,news_title,cate_title,news_img,news_check,username
                    FROM news AS n, cate_news AS cn, user AS u
                    WHERE n.cate_id=cn.cate_id AND n.userid=u.userid
                    ORDER BY news_id DESC";
            $query = mysqli_query($conn,$sql);
            $stt = 0;
            if(mysqli_num_rows($query) == 0){
                echo "<tr><td colspan='8'>Không có tin nào cả.</td></tr>";
            }else{
                while($data = mysqli_fetch_assoc($query)){
                    $stt++;
                    echo "<tr>";
                    echo "<td>$stt</td>";
                    echo "<td>".$data['news_title']."</td>";
                    echo "<td>".$data['cate_title']."</td>";
                    echo "<td>".$data['news_img']."</td>";
                    if($data['news_check'] == 'Y'){
                        echo "<td>Đã duyệt</td>";
                    }else if($data['news_check'] == 'N'){
                        echo "<td style='color:red;'>Chưa duyệt</td>";
                    }                    
                    echo "<td>".$data['username']."</td>";
                    echo "<td><a href='edit_news.php?nid=".$data['news_id']."'>Sửa</a></td>";
                    echo "<td><a onclick='return xacNhan();' href='del_news.php?nid=".$data['news_id']."'>Xoá</a></td>";
                    echo "</tr>";
                }
            }
        ?>
    </tr>
</table>