<?php
	global $current_user, $orphan_prefix,$tname_excel; 
	//include(dirname(__FILE__)."/excelreader.php");
	include(dirname(__FILE__)."/excel_reader2.php");
	$data = new Spreadsheet_Excel_Reader(dirname(__FILE__)."/data/".$tname_excel.".xls",false);
	$arrtre_hoten =  array();
	$arrtre_ngaysinh =  array();
	$arrtre_gioitinh =  array();
	$arrtre_diadiem =  array();
	$arrtre_thoigian =  array();
	$arrtre_hoancanh =  array();
	for($r = 2; $r <= $data->rowcount(); $r++){
			$arrtre_hoten[]    =  $data->val($r,'A');
			$arrtre_ngaysinh[] =  $data->val($r,'B');
			$arrtre_gioitinh[] =  $data->val($r,'C');
			$arrtre_diadiem[]  =  $data->val($r,'D');
			$arrtre_thoigian[] =  $data->val($r,'E');
			$arrtre_hoancanh[] =  $data->val($r,'F');
	}
	$arrtre = array_map(null,$arrtre_hoten,$arrtre_ngaysinh,$arrtre_gioitinh,$arrtre_diadiem,$arrtre_thoigian,$arrtre_hoancanh );
	$datastore = base64_encode(serialize($arrtre));
	setcookie("datatre", $datastore, time()+3600);
	unlink(dirname(__FILE__)."/data/".$tname_excel.".xls");
	get_header();
?>
	<div class="large-12 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Danh sách trẻ</h2>
					<div class="box-content list-2" style="text-align:center;">
					<form method="post">
						<table width="100%">
						<tr>
							<td colspan="8"><h4>Danh sách trẻ từ file Excel</h4></td>
						</tr>
						<tr>
							<td>STT</td>
							<td>Họ tên</td>
							<td>Ngày sinh</td>
							<td>Giới tính</td>
							<td>Địa điểm</td>
							<td>Thời gian</td>
							<td>Hoàn cảnh</td>
							<td>Chọn</td>
						</tr>
						<?php 
							$tt = 0;
							foreach($arrtre as $tre): 
						?>
							<tr>
							<td><?php echo ++$tt ?></td>
							<td><?php echo $tre[0]; ?></td>
							<td><?php echo $tre[1]; ?></td>
							<td><?php echo $tre[2]; ?></td>
							<td><?php echo $tre[3]; ?></td>
							<td><?php echo $tre[4]; ?></td>
							<td><?php echo $tre[5]; ?></td>
							<td> <input type="checkbox" name="luachon[]" value="<?php echo $tt ?>" checked="checked"/> </td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="8"><input type="submit" class="button" value="Thêm Vào" name="accept_insert" /></td>
						</tr>
						</table>
					</form>
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div>
	
<?php 
get_footer() ;
?>