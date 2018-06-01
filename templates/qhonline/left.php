    <div id="main">
    	<div id="left">
        	<h1>Trang Chủ</h1>
            <ul>
				<li><a href="index.php">Trang Chủ</a></li>
				<?php
					$sql = "SELECT page_id,page_title
							FROM page";
					$query = mysqli_query($conn,$sql);
					if(mysqli_num_rows($query) == 0){
						echo "<li>Chưa có dữ liệu</li>";
					}else{
						while($data = mysqli_fetch_assoc($query)){
							echo "<li><a href='page.php?pid=".$data['page_id']."'>".$data['page_title']."</a></li>";
						}
					}
				?>
				<li><a href="contact.php">Liên Hệ</a></li>       	                                                              
            </ul>
        	<h1>Chuyên Mục</h1>
            <ul>
				<?php
					$sql = "select * from cate_news";
					$query = mysqli_query($conn,$sql);
					if(mysqli_num_rows($query) == 0){
						echo "<li>Chưa có dữ liệu.</li>";
					}else{
						while($data = mysqli_fetch_assoc($query)){
							echo "<li><a href='categorie.php?cid=".$data['cate_id']."'>".$data['cate_title']."</a></li>";
						}
					}
				?>
            </ul>            
        </div>