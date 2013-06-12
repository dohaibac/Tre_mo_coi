
<div class="large-4 columns">
	<div class="shadow-box" style="margin-bottom: 18px !important">
		<a href="<?php echo get_permalink( get_page_by_path( 'don-nhan-yeu-thuong' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/don-nhan-yeu-thuong.png"/></a>
	</div>
	<div class="shadow-box">
		<a href="<?php echo get_permalink( get_page_by_path( 'nhap-thong-tin-tre-mo-coi' ) );?>"><img alt="title" src="<?php echo get_template_directory_uri(); ?>/images/dang-thong-tin-tre-em.png"/></a>
	</div>
	<!--Begin widget Tấm lòng vàng -->
	<div class="row sidebar-box shadow-box">
		<h2>Tấm lòng vàng</h2>
		<div class="box-content list-2">
			<div class="row">
				<div class="large-4 columns">
					<a href=""><img alt="title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/1.png"/></a>
				</div>
				<div class="large-8 columns">
					<h3><a href="">Mỗi bàn tay, một tấm lòng, đón nhận yêu thương</a></h3>
				</div>
			</div>
			<div class="row">
				<div class="large-4 columns">
					<a href=""><img alt="title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/2.png"/></a>
				</div>
				<div class="large-8 columns">
					<h3><a href="">Mỗi bàn tay, một tấm lòng, đón nhận yêu thương</a></h3>
				</div>
			</div>
			<div class="row">
				<div class="large-4 columns">
					<a href=""><img alt="title" class="thumb" src="<?php echo get_template_directory_uri(); ?>/images/temp-img/3.png"/></a>
				</div>
				<div class="large-8 columns">
					<h3><a href="">Mỗi bàn tay, một tấm lòng, đón nhận yêu thương</a></h3>
				</div>
			</div>
		</div>
	</div><!--End widget Tấm lòng vàng -->
	<!--Begin widget  Bình luận mới nhất -->
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_main') ) :endif;?>
	<!--End widget Bình luận mới nhất -->
	<!--Begin widget  widget Fan Page -->
	<div class="row sidebar-box shadow-box">
		<h2>Fan Page</h2>
		<div class="box-content list-2" style="padding:0;">
			<div class="facebook-box">
			<div class="fb-like-box" data-href="https://www.facebook.com/monandanangfanclub" data-width="290" data-height="300" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false" style="text-align:center;font-style:italic;font-size:13px;color:#999;">Đang tải...</div>
			</div>
		</div>
	</div><!--End widget Fan Page -->
	
</div><!--end .large-4-->