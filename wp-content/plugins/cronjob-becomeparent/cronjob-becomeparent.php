<?php   
/*   
Plugin Name: Cronjob Become Parent Plugin
Plugin URI: http://tremocoi.org.vn/   
Description: A plugin to run "become parent" crontasks.   
Version: 1.0.0 
Author: Ha Nguyen   
Author URI: http://tremocoi.org.vn/
*/

/* The activation hook is executed when the plugin is activated. */
register_activation_hook(__FILE__,'becomeparent_activation');

/* This function is executed when the user activates the plugin */
function becomeparent_activation(){  wp_schedule_event(time(), 'fivesecondly', 'becomeparent_hook');}

/* The deactivation hook is executed when the plugin is deactivated */
register_deactivation_hook(__FILE__,'becomeparent_deactivation');

/* This function is executed when the user deactivates the plugin */
function becomeparent_deactivation(){  wp_clear_scheduled_hook('becomeparent_hook');}

/* We add a function of our own to the my_hook action.add_action('my_hook','my_function'); */
add_action('becomeparent_hook','becomeparent_function');

 /* This is the function that is executed by the hourly recurring action my_hook */
function becomeparent_function()
{  
	global $gmdate; $gmdate = get_now_in_option_gmt_offset();
	
//	$cronjob = get_cronjob(); 
	
//	$children = get_waiting_children();
		
	map_old_demands_new_children();
//	
	map_new_demands_all_children();

//	$demand = get_post(262);
////	var_dump($demand);
//	
//	$children_args = array(
////				'ID' 					=> 261,
//				'post_type'				=> 'tre-mo-coi',
//				'post_status' 			=> 'private',
//			    'meta_query' 			=> array(
//										        'relationship' 		=> 'AND',
//										        array(
//										            'key'   => 'orphan_birthday',
//										            'value' => "/2010",#   %C\\%%",
//										        	'compare' => "LIKE"
//										        ),
//										        $gender_arr
//			    							)
//			);
//	$children = get_posts($children_args);
//
////			$customPosts = new WP_Query($children_args);
////			echo "Last SQL-Query: {$customPosts->request}";
//	
//	becomeparent_email( "map_old_demands_new_children", $demand, $children );
	
//	update_cronjob($cronjob);

	$gmdate = null;
}






function get_cronjob()
{   	
	$post_args = array(
	  	'post_author'   => 1,
	  	'post_type'     => 'cronjob-becomeparent',
	  	'post_title'    => 'Cronjob Đón nhận yêu thương thực hiện ngày %',
	);
	
	query_posts($post_args);
	
	if(have_posts()) : $cronjob = the_post(); 
	else : $cronjob = wp_insert_post( $post_args );
	endif;
	
	return $cronjob;
}

function get_waiting_children()
{
	$children_args = array(
		'post_type'				=> 'tre-mo-coi',
		'post_status' 			=> 'waiting',
	);			
	
	return get_posts( $children_args );
}


function post_where_days_ago( $where = '' ) 
{
    global $wpdb;
	global $gmdate;
    
    $where .= $wpdb->prepare( " AND DATE(post_date) < DATE(%s)", $gmdate );
 
    return $where;
}


function post_where_today( $where = '' ) 
{
    global $wpdb;
	global $gmdate;
    
    $where .= $wpdb->prepare( " AND DATE(post_date) = DATE(%s)", $gmdate );
 
    return $where;
}

function map_old_demands_new_children()
{  	
	echo "<br><br>===============================================================================<br>
		MAPPING OLD DEMANDS WITH NEW CHILDREN: <br>";
	global $gmdate;
	
	echo "<br><br>Demand:<br>";
	// get demands			
	$demand_args = array(
		'post_type'     	=> 'nhan-con-nuoi',
	  	'post_status'   	=> 'private',
		'suppress_filters' 	=> false,
		'meta_query'		=> array(
									'relationship' 			=> 'AND',
									array(
										'key' 	=> 'orphan_ncn_finished_date',
										'value' => $gmdate,
										'compare' => '>='
										),
									),
	);
	
	add_filter( 'posts_where', 'post_where_days_ago' ); 	
	
	$demands = get_posts( $demand_args ); //( $demand_args );
	
//	echo $GLOBALS['wp_query']->request;
//	die();
	 
	// Important to avoid modifying other queries
	remove_filter( 'posts_where', 'post_where_days_ago' );	
	
	echo "<br><br>";
	wp_reset_postdata(); 
	var_dump($demands);
	
	
	// Find children for each demand
	foreach( $demands as $demand ) :		
				
		$birthyear = get_post_meta($demand->ID, "orphan_ncn_nam_sinh", true);
		$gender = get_post_meta($demand->ID, "orphan_ncn_gioi_tinh", true);
		$gender_arr = null;
		if($gender == "Nam" || $gender == "Nữ"):
			$gender_arr = array(
						            'key'   => 'orphan_gender',
						            'value' => $gender
						        );
        endif;

		$children_args = array(
			'post_type'				=> 'tre-mo-coi',
			'post_status' 			=> 'private',
		    'meta_query' 			=> array(
									        'relationship' 		=> 'AND',
									        array(
									            'key'   => 'orphan_birthday',
									            'value' => "/".$birthyear,
									        	'compare' => "LIKE"
									        ),
									        $gender_arr
		    							)
		);
		
		echo "<br><br>Children:<br>";
		add_filter( 'posts_where', 'post_where_today' ); 
//		$children = new WP_Query($children_args);
//		$children = get_posts($children_args);	
		$get_posts1 = new WP_Query;
		$children = $get_posts1->query($children_args);	 
		remove_filter( 'posts_where', 'post_where_today' );	
		
		
		// Send email to user
		becomeparent_email("map_old_demands_new_children", $demand, $children);
	endforeach; 
}

function map_new_demands_all_children()
{  	
	echo "<br><br>===============================================================================<br>
		MAPPING NEW DEMANDS WITH ALL CHILDREN: <br>";
	global $gmdate;
	
	echo "<br><br>Demand:<br>";
	// get demands			
	$demand_args = array(
		'post_type'     	=> 'nhan-con-nuoi',
	  	'post_status'   	=> 'private',
		'suppress_filters' 	=> false,
		'meta_query'		=> array(
									'relationship' 			=> 'AND',
									array(
										'key' 	=> 'orphan_ncn_finished_date',
										'value' => $gmdate,
										'compare' => '>='
										),
									),
	);
	
	add_filter( 'posts_where', 'post_where_today' ); 	
	
	$demands = get_posts( $demand_args ); //( $demand_args );
	
//	echo $GLOBALS['wp_query']->request;
//	die();
	 
	// Important to avoid modifying other queries
	remove_filter( 'posts_where', 'post_where_today' );	
	
	echo "<br><br>";
	wp_reset_postdata(); 
	var_dump($demands);
	
	
	// Find children for each demand
	foreach( $demands as $demand ) :		
				
		$birthyear = get_post_meta($demand->ID, "orphan_ncn_nam_sinh", true);
		$gender = get_post_meta($demand->ID, "orphan_ncn_gioi_tinh", true);
		$gender_arr = null;
		if($gender == "Nam" || $gender == "Nữ"):
			$gender_arr = array(
						            'key'   => 'orphan_gender',
						            'value' => $gender
						        );
        endif;

		$children_args = array(
			'post_type'				=> 'tre-mo-coi',
			'post_status' 			=> 'private',
		    'meta_query' 			=> array(
									        'relationship' 		=> 'AND',
									        array(
									            'key'   => 'orphan_birthday',
									            'value' => "/".$birthyear,
									        	'compare' => "LIKE"
									        ),
									        $gender_arr
		    							)
		);
		
		echo "<br><br>Children:<br>";
//		$children = new WP_Query($children_args);
//		$children = get_posts($children_args);	
		$get_posts1 = new WP_Query;
		$children = $get_posts1->query($children_args);	 
		
		
		// Send email to user
		becomeparent_email("map_new_demands_all_children", $demand, $children);
	endforeach; 
}

function update_cronjob($cronjob)
{
	$date = new DateTime();
	
	$post_args = array(
		'ID' 			=> $cronjob->ID,
	  	'post_title'    => 'Cronjob Đón nhận yêu thương thực hiện ngày '.date_format($date, 'Y-m-d'),
	);
	
	$cronjob = wp_update_post( $post_args );
}




if ( !function_exists('becomeparent_email') ) :
	
	function becomeparent_email( $mapping_type, $demand, $children = null )
	{
		if($mapping_type == "map_old_demands_new_children" && (is_null($children) || count($children) == 0))
			return;
			
		$user = get_user_by('id', $demand->post_author);		
		$user_firstname = stripslashes($user->user_firstname); 
		$user_lastname = stripslashes($user->user_lastname); 
		$user_email = stripslashes($user->user_email); 
		$child_gender = get_post_meta($demand->ID, "orphan_ncn_gioi_tinh", true);
		$child_gender = str_replace("/"," hoặc ",$child_gender);
		$child_gender = str_replace("Nữ","Gái",$child_gender);
		$child_gender = str_replace("Nam","Trai",$child_gender);
		$birthyear = get_post_meta($demand->ID, "orphan_ncn_nam_sinh", true);
		
		$to  = $user_email;		
		$subject = 'Thông tin trẻ mồ côi đang chờ đón yêu thương';
		
		// message
		$message = '
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Thông tin trẻ mồ côi đang chờ đón yêu thương</title>
		<style>
		h1 {color: #547159 !important; font-size: 48px; text-shadow: 1px 1px 1px #fff; font-family: Georgia, "Times New Roman", Times, serif; margin: 0; padding: 0;}
		h2 {color: #9faf78 !important; font-size: 30px; margin-bottom: 10px; font-family: Georgia, "Times New Roman", Times, serif; padding: 0;}
		.content p {font-size: 13px; color: #686f64; font-family: Arial, Helvetica, sans-serif; padding: 0; margin: 0 0 10px 0;}
		.content ul, .content ol{margin:0 0 0 30px; padding:0;}
		.content ul li, .content ol li{font-size: 13px; color: #686f64; font-family: Arial, Helvetica, sans-serif; padding: 0; margin: 0 0 10px 0;}
		.content a {color: #9faf78 !important; text-decoration: underline !important;}
		.content a:hover {color: #9faf78 !important; text-decoration: underline !important;}
		.footer p {color: #fff; font-size: 13px; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
		table.table-border-tpo, .table-border-tpo tr, .table-border-tpo td{
			border:1px solid #888888;
			text-align:left;
			font-size:13px;
		}
		</style>
		
		<!--[if gte mso 9]>
		<style type="text/css">
		.body{background: #353732 url("http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/body-bg.jpg");}	     
		.case {background:none;}
		</style>
		<![endif]-->
		</head>
		<body style="background-color:#58A9F0; background-image: url(http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/bg.png); background-repeat: repeat-x;" class="body" marginheight="0" topmargin="0" marginwidth="0" leftmargin="0">
		
		<!--100% body table-->
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#58A9F0; background-image: url(http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/bg.png); background-repeat: repeat-x;" >
		  <tr>
		    <td class="case" style="background: url(http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/bg_header.png) no-repeat scroll center 0 transparent;"><!--[if gte mso 9]>
		                <td style="background: none;">
		                <![endif]--> 
		      <!--header text-->
		      
		      <table id="top" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		        <tr>
		          <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		              <tr>
		                <td valign="middle" align="center" style="text-align:center;"> 
		                		<a href="#"> <img src="http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/logo.png" alt="logo" /></a>
		                </td>
		              </tr>
		            </table></td>
		        </tr>
		      </table>
		      <!--/header text--> 
		      
		      <!--masthead-->
		      
		      <table style="background: none repeat scroll 0 0 #FFFFFF;border-radius: 4px 4px 0px 0px;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		        <tr>
		          <td style="background: #ECFAFE;border-radius: 4px 4px 0px 0px;" valign="top" height="77"><!--date-->
		            
		            
		            <!--title-->
		            
		            <table width="600" border="0" cellspacing="0" cellpadding="00">
		              <tr>
		                <td height="25"></td>
		              </tr>
		              <tr>
		                <td><h1 style="font-size:28px;text-align:center;display:block;">
		                    <singleline label="Title">Đón Nhận Yêu Thương</singleline>
		                  </h1></td>
		              </tr>
		            </table>
		            <!--/title--></td>
		        </tr>
		      </table>
		      <!--/masthead--> 
		      
		      <!--top intro-->
		      
		      <table style="background: #ECFAFE;border-top:2px solid blue;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		        <tr>
		          <td height="35"><!--break-->
		            
		            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		              <tr>
		                <td height="30">&nbsp;</td>
		              </tr>
		            </table>
		            <!--/break-->
		            
		            <repeater>
		            <table class="content" width="540" border="0" align="center" cellpadding="0" cellspacing="0">
		              <tr>
		                <td style="text-align:center;"> 
		                  <h2 style="font-size:18px;">
		                    <singleline label="Title">Thông tin trẻ mồ côi đang chờ đón yêu thương</singleline>
		                  </h2>                 
		                  <multiline label="Description">
		                  <p style="text-align:left;">
			                  Xin chào '. $user_firstname. ' '. $user_lastname .',
			                  <br />
			                  Bạn đã đăng ký nhận thông tin về trẻ mồ côi là một bé '. $child_gender .', sinh năm '. $birthyear .'.
			                  <br />';
		                  if($children):
		$message .=         	
								'Dưới đây là những trẻ phù hợp với nhu cầu tìm kiếm của bạn:
		            			<table class="table-border-tpo" style = "border-collapse:collapse;text-align:left" border="1" align="left">
				                  	<tr>
				                  		<td>STT</td>
				                  		<td>Tên trẻ</td>
				                  		<td>Giới tính</td>
				                  		<td>Năm sinh</td>
				                  		<td>Ảnh hiện tại</td>
				                  		<td>Người bảo trợ</td>
				                  		<td>Điện thoại</td>
				                  		<td>Email</td>
				                  	</tr>';
	$i = 0;
	foreach ($children as $child):
		$i ++;
		$message .=         	
				                  	'<tr>
				                  		<td>'. $i .'</td>
				                  		<td>'. $child->post_title .'</td>
				                  		<td>'. $child->orphan_gender .'</td>
				                  		<td>'. substr($child->orphan_birthday, -4) .'</td>		                  		
				                  		<td></td>		                  		
				                  		<td></td>
				                  		<td></td>
				                  		<td></td>
				                  	</tr>';
	endforeach;
		$message .=         				                  	
			                  '</table>
			                  <br />
			                  Bạn tham khảo thông tin trên và liên lạc với người bảo trợ để gặp gỡ và tìm hiểu thêm về trẻ.
			                  ';
		                  else:
		$message .=           'Hiện nay chưa có trẻ nào phù hợp với nhu cầu tìm kiếm của bạn. Chúng tôi sẽ gửi bạn thư báo ngay khi có thông tin mới.
			                  ';		                  
		                  endif;
		$message .=         			
		                  	  'Hoặc mời liên lạc với <a href="demo.evizi.com/tre_mo_coi/lien-he" title="trẻ mồ côi">chúng tôi</a> để biết thêm chi tiết.
				              <br />Chúc bạn sớm tìm được thiên thần nhỏ yêu thương của mình!
			                  <br />
			                  http://tremocoi.org.vn
			                  <br /><br />
			                  Cảm ơn bạn đã sử dụng website tremocoi.org.vn
		                  
		                  </p>
		                  </multiline>
		                    <br />
		                </td>
		              </tr>
		              <!--line-->    
		              <tr>
		              	<td valign="top" align="center" height="25">
		              	<hr />
		              	<p align="right" style="float:right; clear:both; margin: 0; padding: 0;"><a href="#top"><img src="http://demo.evizi.com/tre_mo_coi/wp-content/themes/orphan-theme-v2/images/up.gif" height="22" width="21" alt="back to top" border="0" /></a></p>
		              	</td>
		              </tr>
		              <!--/line--> 
		            </table>
		            </repeater>
		            
		                        <!--break-->
		            
		            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		              <tr>
		                <td height="20">&nbsp;</td>
		              </tr>
		            </table>
		            <!--/break-->
		          </td>
		        </tr>
		      </table>
		      <!--/top intro--> 
		 
		      
		      <!--footer-->
		      
		      <table class="footer" style="color:white; font-size:13px;background: #1979EC;border-radius: 0px 0px 4px 4px;border-top:2px solid blue;box-shadow: 0 0 3px #888888;overflow: hidden;" width="600" border="0" align="center" cellpadding="20" cellspacing="0">
		        <tr>
		          <td class="footer" valign="top"><multiline label="Description">
		          <p>
						Nếu gia đình bạn đã nhận nuôi trẻ, dù trong hay ngoài hệ thống của chúng tôi, phiền bạn hồi âm hoặc <a href="http://demo.evizi.com/tre_mo_coi/lien-he">liên hệ</a> với chúng tôi, để thông tin của gia đình cũng như con bạn được bảo mật tuyệt đối.
						Tuy nhiên, chúng tôi cũng rất vinh hạnh nếu được đăng thông tin phản hồi về hình ảnh, thông tin cuộc sống hạnh phúc của trẻ tại gia đình bạn để rung động thêm nhiều con tim nữa cùng tạo nên hạnh phúc cho trẻ thơ.
		          </p>
		          </multiline>
		          <hr/>
		          <p>
						Website tremocoi.org.vn giúp kết nối những gia đình mong muốn có con nuôi, những tấm lòng vàng với những trẻ em mồ côi, bị bỏ rơi, vô cùng khao khát tình cảm yêu thương gia đình.          
		          </p>
		          </multiline>
		          <hr/>
		            <p>
		            
		             	Nếu cảm thấy những email như thế này làm phiền bạn và bạn không muốn nhận thông tin từ website nữa, vui lòng hủy chức năng gửi email 
		              <unsubscribe style="color:#dee7c6; text-decoration: underline;">tại đây.</unsubscribe>
		            </p></td>
		        </tr>
		      </table>
		      <!--footer--> 
		      
		      <!--break-->
		      
		      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		        <tr>
		          <td height="25">&nbsp;</td>
		        </tr>
		      </table>
		      <!--/break--></td>
		  </tr>
		</table>
		<!--/100% body table-->
		</body>
		</html>
		';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
		
		// Additional headers
		$headers .= 'To: '.$user_name.' <'. $user_email .'>' . "\r\n";
		$headers .= 'From: TreMoCoi <tremocoi.org.vn@gmail.com>' . "\r\n";
		
		$b64subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
		$headers .= 'Subject: '. $b64subject . "\r\n";

		
		// Mail it		
		wp_mail( $to, $subject, $message, $headers );
	}
endif;














add_filter( 'posts_request', 'dump_request' );

function dump_request( $input ) {

    var_dump($input);

    return $input;
}
?>