<?php 

/**
 * Template Name: Cập nhật history tre mo coi Template
 * Description: A Page Template that shows unsubscipbe email 
 */

global $current_user, $orphan_prefix; 
	if($current_user->ID == null)
	{
		?>
		<script>
		alert("Bạn cần đăng nhập và kích hoạt tài khoản trước khi sử dụng chức năng này.");
		document.location.href = '<?php echo home_url()?>';
		</script>
		<?php
		exit();
	}
	if(isset($_POST['accept_insert'])){
		require(dirname(__FILE__)."/insert.php");
		exit();
	}
	if(isset($_POST['upfile_ok']) && $_POST['upfile_ok'] == 'Upload') {
		$tmp_name = $_FILES["file_tmc"]["tmp_name"];
		$up_name = $_FILES["file_tmc"]["name"];
		$path_parts = pathinfo($up_name);
		$extension = $path_parts['extension'];
		if($extension == "xls"){
			global $tname_excel;
			$tname_excel = md5(uniqid().$up_name);
			if(move_uploaded_file($tmp_name, dirname(__FILE__)."/data/".$tname_excel.".xls")){
				require(dirname(__FILE__)."/process.php");
				exit();
			}else 
				$upfile_mess ="Chúng tôi không thể upload file trong thời điểm này. ";
		}else{
			$upfile_mess ="Vui lòng upload file đúng định dạng xls(excel 97-2003 ) ";
		}
	}
get_header();
?>
	<div class="large-12 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Upload File Excel</h2>
					<div class="box-content list-2" style="text-align:center;">
						<?php
							if((isset($upfile_mess)) && ($upfile_mess != "")){
								echo '<p style="color:red">'.$upfile_mess.'</p>';
							}
						?>
						<table width="100%">
						<tr>
							<td colspan="2">Bạn có thể tải file mẫu <a href="<?php echo  plugins_url('data/datatmc.xls' , __FILE__ ); ?>">tại đây</a> .</td>
						</tr>
						
							
							<form method="post" enctype="multipart/form-data">
							<tr>
								<td>
								<label for="file-tmc">Chọn File Excel (*.xls)</label>
								</td>
								<td>
								<input type="file" name="file_tmc" id="file_tmc" />
								</td>
							</tr>
							<td colspan="2">
								<input type="submit" name="upfile_ok" value="Upload" class="button" />
							</tr>
							</form>
						
						</table>
			
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div>
	
<?php 
get_footer() ;
?>