<?php
global $current_user;

$PLUGIN_DIR_URL = plugin_dir_url(__FILE__);

if(is_null($current_user)){
	add_action('wp_head', 'tmc_add_jquery_plugins');
	add_action('wp_footer', 'tmc_add_login_box_template', 100);
	add_action('wp_footer', 'tmc_add_register_box_template', 100);
	add_action('wp_footer', 'tmc_add_user_panel', 101);
}

add_action('wp_head', 'tmc_add_javascript');

function tmc_add_user_panel(){
	echo '<div id="tmc_user_panel_data" style="display:none;">';
	if(!is_user_logged_in() ){	
	echo <<<EOF
		<a href="#login" id="tmc_login_button" class="small button">Đăng nhập</a> | <a id="tmc_register_button" href="#register" class="small button">Đăng ký</a>
EOF;
	}else{
		$current_user = wp_get_current_user();
		$site_url = get_site_url();
		$logout_url = wp_logout_url( home_url() );
	echo <<<EOF
	Chào {$current_user->user_login} <a href="{$site_url}/profile" class="small button">Trang cá nhân</a> | <a class="small button alert" href="$logout_url">Thoát</a>
EOF;
	}
	echo '</div>';
}

function tmc_add_jquery_plugins(){
	global $PLUGIN_DIR_URL;
	echo <<<EOF
	<!-- Fancy box -->
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="{$PLUGIN_DIR_URL}asset/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="{$PLUGIN_DIR_URL}asset/js/fancybox/source/jquery.fancybox.js?v=2.1.4"></script>
	<link rel="stylesheet" type="text/css" href="{$PLUGIN_DIR_URL}asset/js/fancybox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
EOF;
}

function tmc_add_javascript(){
	global $PLUGIN_DIR_URL;
	$ajax_url = admin_url('admin-ajax.php');
	echo <<<EOF
	<script language="javascript">var ajaxurl = '$ajax_url';</script>
	<script type="text/javascript" src="{$PLUGIN_DIR_URL}asset/js/tremocoi_login_registration.js"></script>
EOF;
}

function tmc_add_register_box_template(){
	global $PLUGIN_DIR_URL;
	echo <<<EOF
	<div id="register" style="display:none;width:600px;height:auto;">
		<div>
			<img src="{$PLUGIN_DIR_URL}asset/imgs/register-header.png" width="600" />
		</div>
		<br />
		<div data-alert="" class="alert-box alert" style="display:none;" id="tmc_login_error_container">
          Bạn phải nhập đầy đủ thông tin.
        </div>
		
		<form class="custom">
					
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-username" class="inline">Tên đăng nhập <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-username" id="txt-username" placeholder="Tên đăng nhập">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-mail" class="inline">Email <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-email" id="txt-mail" placeholder="Email liên lạc" value="">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-pwd" class="inline">Mật khẩu <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="password" name="txt-pwd" id="txt-pwd" placeholder="Mật khẩu" value="">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-confirm-pwd" class="inline">Xác nhận <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="password" name="txt-confirm-pwd" id="txt-confirm-pwd" placeholder="Nhập lại mật khẩu" value="">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-name" class="inline">Họ tên <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-name" id="txt-name" placeholder="Họ tên">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-address" class="inline">Địa chỉ <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-address" id="txt-address" placeholder="Địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  &nbsp;
							</div>
							<div class="small-4 columns">
							  <input type="text" name="txt-district" placeholder="Quận (Huyện)">
							</div>
							<div class="small-5 columns">
							  <input name="txt-province" type="text" placeholder="Tỉnh (Thành phố)">
							</div>
						</div>
						<div class="row">
							<div class="small-3 columns">
							  <label for="txt-phone" class="inline">Điện thoại <span class="require">*</span></label>
							</div>
							<div class="small-9 columns">
							  <input type="text" name="txt-phone" id="txt-phone" placeholder="Số điện thoại liên lạc">
							</div>
						</div>
						
						<div class="row">
							<div class="large-12 columns text-right">
							<button class="small">Đăng ký</button> <button class="small">Nhập lại</button>
							</div>
						</div>

					
				</form>
	</div>
EOF;
}

function tmc_add_login_box_template(){
	global $PLUGIN_DIR_URL;
	echo <<<EOF
		<div id="login" style="display:none;width:300px;height:auto;">
		<div>
			<img src="{$PLUGIN_DIR_URL}asset/imgs/login-header.png" width="300" />
		</div>
		<br />
		<div data-alert="" class="alert-box alert" style="display:none;" id="tmc_login_error_container">
          Bạn phải nhập đầy đủ thông tin.
        </div>
		<div style="text-align:center;margin-top:40px;margin-bottom:50px;display:none;" id="tmc_login_waiting">
			<div><img src="{$PLUGIN_DIR_URL}asset/imgs/wait.gif" width="32" /></div>
			<div style="margin-top:5px;color:#999999;font-style:italic;">Đang đăng nhập</div>
		</div>
		<div id="tmc_login_form">
			<div>
			  <div class="large-12 columns" style="padding-left:0px;padding-right:0px;width:300px;">
				<div class="left"style="margin-top:7px;">
				<label><b>Tên đăng nhập</b></label>
				</div>
				<div class="right" style="margin-left:10px;">
				<input type="text" id="tmc_username" value="" style="width:170px;">
				</div>
			  </div>
			  <div style="clear:both;"></div>
			</div>
			<div>
			  <div class="large-12 columns" style="padding-left:0px;padding-right:0px;width:300px;">
			  <div class="left"style="margin-top:7px;">
				<label><b>Mật khẩu</b></label>
			  </div>
			  <div class="right" style="margin-left:10px;">
				<input type="password" id="tmc_password" value=""  style="width:170px;">
			  </div>
			  </div>
			  <div style="clear:both;"></div>
			</div>
			<div>
			<div class="left" style="margin-top:8px;font-size:14px;">
			<label for="tmc_rememberme"><input style="margin:0 0 0 0;vertical-align:middle;" name="rememberme" type="checkbox" id="tmc_rememberme" value="forever" tabindex="90"> <span>Tự động đăng nhập lần sau</span>
			</label>
			</div>
			<div class="right">
			<a href="#" id="tmc_login_submit_button" class="success small button" title="Đăng nhập">Đăng nhập</a>
			</div>
				<div style="clear:both;"></div>
			</div>
			
		
			<div>
				<div class="left" style="font-size:17px;font-weight:bold;margin-top:7px;">Đăng nhập bằng</div>
				<div class="right">
				<a href="#" id="login_by_facebook" title="Đăng nhập bằng Facebook" style="background:url({$PLUGIN_DIR_URL}asset/imgs/facebook-and-twitter-logo-png-8115.png) -35px 0px no-repeat;display:block;width:35px;height:34px;float:left;"></a>
				<a href="#" id="login_by_twitter" title="Đăng nhập bằng Twitter" style="background:url({$PLUGIN_DIR_URL}asset/imgs/facebook-and-twitter-logo-png-8115.png) 0px 0px no-repeat;display:block;width:35px;height:34px;float:left;margin-left:5px;"></a>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="font-style:italic;font-size:14px;margin-top:7px;">
				Chưa có tài khoản? Click vào <a href="#" id="tmc_login_form_signup_link">đây</a> để đăng ký
			</div>
			</div>
		<div style="clear:both;"></div>
	</div>
EOF;
}