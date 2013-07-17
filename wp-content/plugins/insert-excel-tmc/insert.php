<?php
global $current_user, $orphan_prefix;
$tdata = unserialize(base64_decode($_COOKIE['datatre']));
setcookie("datatre","",time()-100);
$lc = $_POST["luachon"];
foreach($lc as $item){
	$tmpissert = $tdata[$item-1];
	$my_post = array(
		  'post_title'    => $tmpissert[0],
		  'post_type'    => 'tre-mo-coi',
		  'post_content'  => 'Trẻ mồ côi',
		  'post_status'   => 'pending',
		  'post_author'   => $current_user->ID
		);
	$birthday = $tmpissert[1];
	// Insert the post into the database
	$post_id  = wp_insert_post( $my_post );
	//echo $post_id;
	if($post_id){
		add_post_meta( $post_id, $orphan_prefix.'birthday', $birthday );
		add_post_meta( $post_id, $orphan_prefix.'gender', $tmpissert[2]);
		add_post_meta( $post_id, $orphan_prefix.'cv-address', $tmpissert[3] ); 
		add_post_meta( $post_id, $orphan_prefix.'cv-time', $tmpissert[4]);
		add_post_meta( $post_id, $orphan_prefix.'cv-content', $tmpissert[5] );
		//add_post_meta( $post_id, $orphan_prefix.'photo', $data["url-hinhanh"] );
		add_post_meta( $post_id, $orphan_prefix.'cv-auth',$current_user->user_email);
	}
}
/*
echo "<pre>";
print_r($tdata);
echo "<br/>hihi<br/>";
print_r($lc);
echo "<br/>hihi2<br/>";
print_r($hihi);
echo "</pre>";*/
 get_header();
?>
	<div class="large-8 columns content">
		<div class="row">
			<div class="row shadow-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); 	?>
					<h2>Thêm vào thành công </h2>
					<div class="box-content list-2">
						Cảm ơn bạn. Chúc bạn luôn vui vẻ, hạnh phúc.
					</div>
				<?php endif; ?>	
			</div>
		</div>
	</div><!--end .large-8-->

<?php
  			get_sidebar();
  			get_footer() ; 
