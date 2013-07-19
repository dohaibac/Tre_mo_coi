<?php   
/*   
Plugin Name: Cronjob History Children
Plugin URI: http://tremocoi.org.vn/   
Description: A plugin to run History Children crontasks.   
Version: 1.0
Author: Long Nguyen   
Author URI: http://tremocoi.org.vn/
*/

/* The activation hook is executed when the plugin is activated. */
register_activation_hook(__FILE__,'historychildren_activation');

/* This function is executed when the user activates the plugin */
function historychildren_activation(){  wp_schedule_event(time(), 'daily', 'historychildren_hook');}

/* The deactivation hook is executed when the plugin is deactivated */
register_deactivation_hook(__FILE__,'historychildren_deactivation');

/* This function is executed when the user deactivates the plugin */
function historychildren_deactivation(){  wp_clear_scheduled_hook('historychildren_hook');}

/* We add a function of our own to the my_hook action.add_action('my_hook','my_function'); */
add_action('historychildren_hook','historychildren_function');

 /* This is the function that is executed by the hourly recurring action my_hook */
function historychildren_function()
{  
	historychildren_main_process();
}

//filter children update at 30*6 days ago
function historychildren_filter_day(){
	global $wpdb;
    $where .= $wpdb->prepare( " AND DATEDIFF(NOW(), post_date) = 180");
    return $where;
}
function historychildren_get_all(){			
	$child_args = array(
		'post_type'     	=> 'tre-mo-coi',
	  	'post_status'   	=> 'pending',
		'posts_per_page'=>-1,
		'numberposts'=>-1,
		'suppress_filters' 	=> false,
	);
	add_filter( 'posts_where', 'historychildren_filter_day' ); 	
	$allchild = get_posts( $child_args );
	remove_filter( 'posts_where', 'historychildren_filter_day' );	
	wp_reset_postdata(); 
	return $allchild;
}

function historychildren_main_process(){
	$allchild = historychildren_get_all();
	if($allchild != null && count($allchild) > 0):
		foreach($allchild as $onechild){
			historychildren_email_alert($onechild);
		//$current = "";
		//$current .= $onechild->post_author."|".$onechild->post_date."|".$onechild->post_title.$onechild->ID." child<br />";
		//echo $current;
		}
	endif;
}

function historychildren_email_alert($demand){
		$user = get_user_by('id', $demand->post_author);	
		$user_id = $user->ID;	
		$user_firstname = stripslashes($user->user_firstname); 
		$user_lastname = stripslashes($user->user_lastname); 
		$user_email = stripslashes($user->user_email); 		
		$to  = $user_email;		
		$subject = 'Thông tin trẻ mồ côi đang chờ đón yêu thương';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
		$linka = '<a href="'.home_url().'/cap-nhat-tre/?unsubscripbe='.base64_encode($demand->ID."|".md5($user_id.$user_email."aJ#FTUkk")).'" style="color:orange;">tại đây.</a>';
		$message ="Chào bạn, <br />Cảm ơn bạn thời gian qua đã cung cấp thông tin về trẻ ".$demand->post_title." (cách đây 6 tháng) tại website tremocoi.org.vn, nếu trẻ đã tìm được cha mẹ, hãy giúp chúng tôi cập nhật thông tin<br />";
		$message .= "Bạn vui lòng cập nhật thông tin trẻ ".$linka;
		$message .= "<br /> Một lần nữa chúng tôi cảm ơn sự đóng góp của bạn. <br /> Thân ái, <br/> BQT website tremocoi.org.vn.";
		
		// Additional headers
		$headers .= 'To: '.$user_name.' <'. $user_email .'>' . "\r\n";
		$headers .= 'From: TreMoCoi <tremocoi.org.vn@gmail.com>' . "\r\n";
		
		$b64subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
		$headers .= 'Subject: '. $b64subject . "\r\n";
		
		
		// Mail it		
		wp_mail( $to, $subject, $message, $headers );

}
add_filter( 'page_template', 'historychild_page_template' );
function historychild_page_template( $page_template )
{
    if ( is_page( 'cap-nhat-tre' ) ) {
        $page_template = dirname( __FILE__ ) . '/page-historychildren.php';
    }
    return $page_template;
}
 add_filter( 'cron_schedules', 'cron_add_5min1' );

 function cron_add_5min1( $schedules ) {
    $schedules['5min1'] = array(
        'interval' => 10,
        'display' => __( 'Once every five minutes' )
    );
    return $schedules;
 }
?>