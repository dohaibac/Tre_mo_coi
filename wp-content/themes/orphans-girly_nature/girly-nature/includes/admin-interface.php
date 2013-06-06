<?php
/* 
Version: 1.10 (Last modified: 2010-08-12)
Ref: http://wpshout.com/create-an-advanced-options-page-in-wordpress/
*/


function tl_theme_menu() {
	global $tpinfo,$tp_options;
	if(isset($_GET['page']) && $_GET['page'] == basename(__FILE__)) {
		if(isset($_REQUEST['action']) && 'save' == $_REQUEST['action']){
			foreach ($tp_options as $value) {
				if($value['type'] == 'checkbox'){
					$thevalue=isset($_REQUEST[$value['id']])? $_REQUEST[$value['id']]:'false';
					update_option( $value['id'], $thevalue);
				}elseif(isset($value['id'])){//for rest, eg. select, textarea, text (data to be store should have an ID (option name)
					$thevalue=isset($_REQUEST[$value['id']])? $_REQUEST[$value['id']]:'';
					update_option( $value['id'], $thevalue);
				}
			}
			header("Location: themes.php?page=".basename(__FILE__)."&saved=true");
         die;
		}elseif(isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
			foreach ($tp_options as $value) {
				delete_option( $value['id'] );
			}
			header("Location: themes.php?page=".basename(__FILE__)."&reset=true");
			die;
		}
	}	
	/* 
	add_theme_page( page_title, menu_title, capability, file, [function]);
	ref: http://codex.wordpress.org/Roles_and_Capabilities
	*/
	add_theme_page($tpinfo['themename']."Theme Options", $tpinfo['themename'], 'edit_themes', basename(__FILE__), 'tl_theme_interface');
}

function tl_theme_interface() {
    global $tpinfo, $tp_options;
    if ( isset($_REQUEST['saved']) ) echo '<div id="message" class="updated fade"><p><strong>'.$tpinfo['themename'].' settings saved.</strong></p></div>';
    if ( isset($_REQUEST['reset']) ) echo '<div id="message" class="updated fade"><p><strong>'.$tpinfo['themename'].' settings reset.</strong></p></div>';
    
?>
<div class="wrap">
<?php 
if ( function_exists('screen_icon') ) screen_icon();
$tmp = get_theme_data(TEMPLATEPATH . '/style.css');
$tmp = $tmp['Version'];
?>
<h2><?php echo $tpinfo['themename']." v". $tmp ; ?> Options</h2>

<form method="post" action="">
	<table class="form-table">
	<?php 
		foreach ($tp_options as $value) { 
			switch ( $value['type'] ) {

				case 'text':
					echo '<tr valign="top">';
					echo '<th scope="row"><label for="'.$value['id'].'">'.$value['name'].'</label></th>';
					$tmp=(get_option( $value['id'])!="")? stripslashes(get_option($value['id'])):$value['std'];
					echo '<td><input name="'.$value['id'].'" id="'.$value['id'].'" type="text" size="'.$value['options']['size'].'" value="'.$tmp.'" />'.$value['desc'].'</td>';
					echo '</tr>';
				break;

			case 'select':
				echo '<tr valign="top">';
				echo '<th scope="row"><label for="'.$value['id'].'">'.$value['name'].'</label></th>';
				echo '<td><select name="'.$value['id'].'" id="'.$value['id'].'">';
					$select_setting = get_option( $value['id']);
					foreach ($value['options'] as $option){
						if(!empty($select_setting)){
							$tmp=($option == $select_setting)? ' selected="selected"':'';
						}else{
							$tmp=($option == $value['std'])? ' selected="selected"':'';
						}
						echo "<option{$tmp}>{$option}</option>";
						
					}
				echo '</select>'.$value['desc'].'</td>';
				echo '</tr>';
			break;
		
			case 'textarea':
				$ta_options = $value['options'];
				echo '<tr valign="top">';
					echo '<th scope="row"><label for="'.$value['id'].'">'.$value['name'].'</label></th>';
					echo '<td><textarea name="'.$value['id'].'" id="'.$value['id'].'" cols="'.$ta_options['cols'].'" rows="'.$ta_options['rows'].'">';
					echo (get_option($value['id']) != "")? stripslashes(get_option($value['id'])): $value['std'];
					echo "</textarea><br/>{$value['desc']}</td>";
				echo '</tr>';
			break;
		
			case 'heading':
				echo "</table>{$value['desc']}<table class=\"form-table\">";
			break;

		case 'radio':
			echo '<tr valign="top">';
			echo '<th scope="row">'.$value['name'].'</th>';
			echo '<td>';
				foreach ($value['options'] as $key=>$option){
					$radio_setting = get_option($value['id']);
					if(!empty($radio_setting)){
						$checked = ($key == $radio_setting)? ' checked="checked"':'';
					}else{
						$checked = ($key == $value['std'])? ' checked="checked"':'';
					}
					echo "<input type=\"radio\" name=\"{$value['id']}\" id=\"{$value['id']}{$key}\" value=\"{$key}\"{$checked}/><label for=\"{$value['id']}{$key}\">{$option}</label><br />";
				}
			echo '</td>';
			echo '</tr>';
		break;
		
		case 'checkbox':
			echo '<tr valign="top">';
			echo "<th scope=\"row\">{$value['name']}</th>";
				echo '<td>';
					$checkbox_setting=get_option($value['id']);
					if(!empty($checkbox_setting)){
						$checked = ($checkbox_setting=="true")? ' checked="checked"':'';
					}else{
						$checked = ($value['std']=="true")? ' checked="checked"':'';
					}
					echo "<input type=\"checkbox\" name=\"{$value['id']}\" id=\"{$value['id']}\" value=\"true\"{$checked}/>";
					echo "<label for=\"{$value['id']}\">{$value['desc']}</label>";
				echo '</td>';
			echo '</tr>';
		break;

		default:
		break;
	}
}
?>

	</table>

	<p class="submit">
		<input name="save" type="submit" value="Save changes" />    
		<input type="hidden" name="action" value="save" />
	</p>
</form>
<form method="post" action="">
	<p class="submit submit-footer">
		<input name="reset" type="submit" value="Reset" />
		<input type="hidden" name="action" value="reset" />
	</p>
</form>

<div class="widefat" style="padding:5px;font-style:italic;"><strong><?php echo $tpinfo['themename'];?> Wordpress Theme is designed by <a href="http://www.templatelite.com">TemplateLite.com</a>.</strong></div>
</div>
<?php
}
add_action('admin_menu', 'tl_theme_menu');
?>