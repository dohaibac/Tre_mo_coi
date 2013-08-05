<?php
/*
Plugin Name: Save image to post
Plugin URI: http://isovn.net
Description: To increase the speed of website. When you save an article, if the images found in post content (The image at another site). This plugin will automatically save the image of the host.
Version: 1.0
Author: leeseawuyhs
Author URI: http://isovn.net
License: GPL2
TextDomain: isovn.net
*/

/*Global */
$imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "JPG", "JPEG", "PNG");
global $dir_file_upload ;
$dir_file_upload = wp_upload_dir();

add_action('admin_menu', 'isovn_register_save_media_post_submenu_page');

/**
* Function name:	isovn_register_save_media_post_submenu_page
* Description : 	Register menu page
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			Register menu page
*/
function isovn_register_save_media_post_submenu_page() {
	add_submenu_page(
		'options-general.php', 
		'Option Save Media Post',
		'Option Save Media Post',
		'manage_options',
		'save-media-post-page', 
		'isovn_setting_callback'
	); 
}

/**
* Function name:	isovn_setting_callback
* Description : 	Setting form
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			Setting form
*/
function isovn_setting_callback(){
	global $uc_message;
	if (!current_user_can( 'manage_options' ) ) {
		wp_die ( __( 'You do not have sufficient permissions to access this page' ) );
	}
	if(isset($_POST['save_media_action_setting']) && $_POST['save_media_action_setting'] == 'Save Settings'){
		$status = update_option('save_media_post_active',$_POST['save_media_post_active']);
		$uc_message = 'Save successfully!'; 
	} else {
		$uc_message= '';
	}
	$save_media_post_active = get_option('save_media_post_active');
	if($save_media_post_active == 'Yes'){
		$save_media_post_active = 'checked="checked"';
	}

?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Settings - Save Media Post</h2>
		<p class="message_action" style="display:none; border: 1px solid green;  color: blue;  padding: 10px;"></p>
		<form class="save_media_admin_form" action="#" method="post" name="setting-save-media-post" id="setting-save-media-post">
		<p><br/></p>
			<fieldset>
			<legend>Setting </legend>
			<table class="form-table">
				<tr valign="top">
					<td width="100">Save media post</td>
					<td>
						<input type="checkbox" name="save_media_post_active" <?php echo $save_media_post_active; ?> value="Yes" /><label class="opt">&nbsp;Yes</label>
						<p>When you save an article, if the images found in post content (The image at another site). This plugin will automatically save the image of the host.</p>
					</td>
				</tr>
				<tr>
					<td width="100"></td>
					<td>
						<p class="submit">
						<input class="button-primary" type="submit" name="save_media_action_setting" value="Save Settings" />
						</p>
					</td>
				</tr>
			</table>
		</form>
		<style>
			form fieldset{ border:1px solid #d5d5d5; padding 5px;}
			form legend{ border:1px solid #d5d5d5; padding:5px 10px; margin-left: 5px;}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				<?php if(isset($uc_message) && $uc_message !=''){ ?>
					jQuery('p.message_action').text('<?php echo $uc_message; ?>').show().fadeOut(6000);
				<?php $uc_message ='';	}  ?>
			});
			
		</script>
	</div>
<?php
}

add_filter( 'plugin_action_links', 'isovn_save_media_post_action_links',10,2);
/**
* Function name:	isovn_save_media_post_action_links
* Description : 	action links
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			action links
*/
function isovn_save_media_post_action_links( $links, $file ) {
	if ( $file != plugin_basename( __FILE__ ))
		return $links;
		
	$settings_link = '<a href="options-general.php?page=save-media-post-page">' . __( 'Setting', 'save_media_post' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_action( 'save_post', 'isovn_hook_update_media_in_post' );
/**
* Function name:	isovn_hook_update_media_in_post
* Description : 	hook update post when user save post
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			hook update post when user save post
*/
function isovn_hook_update_media_in_post( $post_id ) {
	if(isset($post_id)){
		$save_media_post_active = get_option('save_media_post_active');
		if($save_media_post_active == 'Yes'){
			//verify post is not a revision
			if ( !wp_is_post_revision( $post_id ) ) {
				$content_post = get_post($post_id);
				if(isset($content_post->ID)){
					
					// unhook this function so it doesn't loop infinitely
					remove_action('save_post', 'isovn_hook_update_media_in_post');
					$my_post = array();
					$my_post['ID'] = $post_id;
					$my_post['post_content'] = isovn_get_image_post_content($content_post->post_content);

					// update the post, which calls save_post again
					wp_update_post( $my_post );
					// re-hook this function
					add_action('save_post', 'isovn_hook_update_media_in_post');
				}
			}
		}
	}
}

/**
* Function name:	isovn_get_image_post_content
* Description : 	get image in post content
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			get image in post content
*/
function isovn_get_image_post_content($content = null){
	preg_match_all('/<img[^>]+>/i',$content, $result); 
	$imgs = array();
	if(isset($result[0] )){
		$i=0;
		foreach( $result[0] as $img_tag){
			preg_match_all('/(src)=("[^"]*")/i',$img_tag, $info_img);
			if(isset($info_img[0][0])){
				$imgs[$i] = str_replace(array('src="','"'),'',$info_img[0][0]);
			}
			$i++;
		}
	}
	if($imgs){
		$this_domain = get_bloginfo('home');
		foreach($imgs as $img){
			$found = 0;
			str_replace($this_domain,$this_domain,$img,$found);
			if($found == 0){
				$info_file = isovn_save_image($img);
				$img_new = $info_file['url'];
				$content = str_replace($img,$img_new,$content);
			}
		}
	}
	return $content;
}

/**
* Function name:	isovn_save_image
* Description : 	save game form url
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			save game form url
*/
function isovn_save_image($inPath = null){ //Download images from remote server
	global $dir_file_upload;
	$file_name = isovn_set_file_name($inPath);

	if(isset($file_name['url'])){
		try{
			$handle = @fopen($inPath, "r");
			if($handle){
				$in=    fopen($inPath, "rb");
				$out=   fopen($file_name['url'], "wb");
				while ($chunk = fread($in,8192))
				{
					fwrite($out, $chunk, 8192);
				}
				fclose($in);
				fclose($out);
				$file_name['url'] = $dir_file_upload['url'].'/'.$file_name['name'];
				return $file_name; 
			} else {
				return null;
			}
		} catch (Exception $e){return null;}
		
	} else {
		return null;
	}
}
/**
* Function name:	isovn_set_file_name
* Description : 	set file name
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 14, 2013		leeseawuyhs			set file name
*/
function isovn_set_file_name($url = null){
	global $imgExts, $dir_file_upload ;
	$file_info = pathinfo($url);
	if(isset($file_info)){
		$urlExt = pathinfo($url, PATHINFO_EXTENSION);
		$ext_file = '';
		for($i=0; $i<= strlen($urlExt); $i++){
			$ext_file .= $urlExt[$i-1];
			if($urlExt[$i]== '#' || $urlExt[$i]== '?'){
				break;
			}
		}
		if($ext_file != null){
			$urlExt = $ext_file;
		}
		if (in_array($urlExt, $imgExts)) {
			$file_info['basename'] = isovn_replace_character($file_info['filename'].'.'.$urlExt);
			$file_info['name'] = $file_info['basename'];
			 $check_file =$dir_file_upload['path'].'/'.$file_info['basename'];
			$file_info['url'] = $check_file;
			if(file_exists($file_info['url'])){
				$status = false;
				$i = 1;
				while ($status == false){
					$check_file = $dir_file_upload['path'].'/'.$i.'-'.$file_info['basename'];
					if(!file_exists($check_file)){
						$file_info['name'] = $i.'-'.$file_info['basename'];
						$status = true;
					} else {
						$i++;
					}
				}
				$file_info['url'] = $check_file;
				return $file_info;
			} else {
				return $file_info;
			}
		} else {
			return null;
		}
	}
	return null;
}
/**
* Function name:	isovn_replace_character
* Description : 	replace character
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* July 1, 2013		leeseawuyhs		replace character
*/
function isovn_replace_character($str) {
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	$str = str_replace(array(" ",'(',')','%20','&*#39;','%28','%29'), "", $str);
	return $str;
}