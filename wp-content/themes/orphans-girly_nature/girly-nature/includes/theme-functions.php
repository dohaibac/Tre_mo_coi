<?php
function templatelite_get_postthumb($postid,$width,$height,$return='img',$class=''){
	//$return=img,url
	global $tpinfo;
	
	if($tpinfo[$tpinfo['tb_prefix'].'_postthumb_show']!='true')	return '';

	$thumb_id=get_post_thumbnail_id($postid); // @since 2.9.0
	if($thumb_id){
		$thumb_url=wp_get_attachment_url($thumb_id);
	}else{
		if($tpinfo[$tpinfo['tb_prefix'].'_postthumb_default']!='true') return '';
		$thumb_url=get_bloginfo('template_url')."/images/thumbnail.png";
	}

//clean http:// prevent mod_security problem	
	$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
	$regex = "/^((ht|f)tp(s|):\/\/)(www\.|)" . $host . "/i";
	$thumb_url = preg_replace ($regex, '', $thumb_url);

	if($return=='img'){
		return '<img class="'.$class.'" src="'.get_bloginfo('template_url').'/includes/timthumb.php?src='.$thumb_url.'&amp;w='.$width.'&amp;h='.$height.'&amp;zc=1" alt=""/>';
	}else{ //return URL
		return $thumb_url;
	}
}

function templatelite_excerpt($displaylink='',$excerpt_more="...",$more_left='',$more_right=''){
	global $tpinfo;
	$text= has_excerpt() ? get_the_excerpt() : get_the_content('');
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	//$text = strip_tags($text,"<a><b><u><i><strong>");
	$text = strip_tags($text);
		
	$excerpt_length = $tpinfo[$tpinfo['tb_prefix'].'_postexcerpt_words'];
	

	if(!empty($displaylink)){
		$excerpt_more=$more_left.'<a href="'.get_permalink().'">'.$excerpt_more.'</a>'.$more_right;
	}else{
		$excerpt_more=$more_left.$excerpt_more.$more_right;
	}
	
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words) > $excerpt_length) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	}
	echo $text;
}

function templatelite_wp_head(){
	global $tpinfo;
	$stylesheet=!empty($_REQUEST['style'])? $_REQUEST['style'].".css":$tpinfo[$tpinfo['tb_prefix'].'_stylesheet'];

	if(empty($stylesheet)) $stylesheet='default.css';

	$customjs='/styles/'.basename($stylesheet,'.css').'/custom.js';

	echo '<link href="'. get_bloginfo('template_directory') .'/styles/'. $stylesheet .'" rel="stylesheet" type="text/css" />'."\n";
	echo '<script type="text/javascript" src="'.get_bloginfo("template_directory").'/includes/js/templatelite-general.js"></script>'; //load before custom js
	if(file_exists(TEMPLATEPATH.$customjs)) echo '<script type="text/javascript" src="'.get_bloginfo('template_directory').$customjs.'"></script>';
	if($tpinfo['templatelite_ie6warning']=='true'){
		echo "<!--[if lte IE 6]>";
		echo "<script type='text/javascript'>var template_directory='".get_bloginfo("template_directory")."';</script>";
		echo "<script type='text/javascript' src='".get_bloginfo("template_directory")."/includes/js/jquery.ie6blocker.js'></script>";
		echo "<![endif]-->";
	}
	echo "<!--[if lte IE 7]>";
	echo '<style type="text/css">#sidebar,#sidebar1{margin-top:0;}</style>';
	echo "<![endif]-->";
}

function style_tag_cloud($tags){
	return '<div style="padding:5px;">'.$tags.'</div>';
}

function templatelite_page_menu_args( $args ) {
	global $tpinfo;
	if($tpinfo[$tpinfo['tb_prefix'].'_homelink']=='true'){
		$args['show_home'] = true;
	}
	return $args;
}

function templatelite_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 40 ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'templatelite' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author .vcard -->
					
					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php								
								printf( __( '%1$s at %2$s', 'templatelite' ), get_comment_date(),  get_comment_time() ); /* translators: 1: date, 2: time */
							?>
						</a>
						<?php edit_comment_link(__('Edit','templatelite'),'(',') ');?>
					</div><!-- .comment-meta .commentmetadata -->

					<div class="comment-body">
						<?php if ( $comment->comment_approved == '0' ) : ?>
										<em><?php _e('Your comment is awaiting moderation.');?></em><br/><br/>
						<?php endif; ?>
						<?php comment_text(); ?>
					</div>

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</div><!-- #comment-##  -->
<?php
			break;
		case 'pingback'  :
		case 'trackback' :
?>
			<li class="post pingback">
				<div><?php _e( 'Pingback:', 'templatelite' ); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit','templatelite'),'(',') '); ?></div>
<?php
			break;
	endswitch;
}
?>