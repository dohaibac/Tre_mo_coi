<?php

/*
Plugin Name: Broken Rss Feed Fixer
Description: this plugin is designed to fix broken rss feeds caused by forcing ads or any other type of extra unwanted elements added into your rss feed, Broken Rss Feed Fixer will frequently update a new rss feed file called 'rss.xml' you can use this file as your new rss feed file for feedburner or any thing else.
Version:  1.0
Author: Ramy Sarwat
*/

/////////////////////////////////////////
// adding default values
function broken_rss_feed_fixer_init() {
	$broken_rss_feed_fixer_init = array();
	$broken_rss_feed_fixer_init['interval'] = '30';
	add_option('broken_rss_feed_fixer_init', $broken_rss_feed_fixer_init);
}

function broken_rss_feed_fixer_lastupdate() {
	$broken_rss_feed_fixer_lastupdate = array();
	$broken_rss_feed_fixer_lastupdate['last_update'] = time();
	add_option('broken_rss_feed_fixer_lastupdate', $broken_rss_feed_fixer_lastupdate);
}
 
add_action('init','broken_rss_feed_fixer_init');
add_action('init','broken_rss_feed_fixer_lastupdate');
/////////////////////////////////////////


/////////////////////////////////////////
// adding control panel menu
function broken_rss_feed_fixer_admin() {
    if (function_exists('add_options_page')) {
    	add_options_page('Broken Rss Feed Fixer Options', 'Rss Feed Fixer', 8, basename(__FILE__), 'manage_broken_rss_feed_fixer');
    }
}

add_action('admin_menu', 'broken_rss_feed_fixer_admin');
/////////////////////////////////////////


/////////////////////////////////////////
// adding admin page
function manage_broken_rss_feed_fixer() {
	//array contain the languages available
	$langs = array(
		'30'=>'30',
		'60'=>'60',
		'180'=>'180',
		'3600'=>'3600'
	);
 
	//submitting the data
	if(!empty($_POST['Submit'])) {	
	$broken_rss_feed_fixer_init = array();
	$broken_rss_feed_fixer_init['interval'] = addslashes($_POST['lang']);
	update_option('broken_rss_feed_fixer_init', $broken_rss_feed_fixer_init);

	}
$lastupdate_options = get_option('broken_rss_feed_fixer_lastupdate');
	//Printing the administrator content
	$weather_options = get_option('broken_rss_feed_fixer_init');
	echo '
<form method="post" action="'.$_SERVER['REQUEST_URI'].'"> ';
	echo '
<div class="wrap">';
	screen_icon();
	echo '
<h2>Broken Rss Feed Fixer Options</h2>
 
';
	echo '
<table class="form-table">';
	echo '
<tr>
<td>';
echo "<b>this plugin is designed to fix broken rss feeds caused by forcing ads or any other type of extra unwanted elements added into your rss feed, Broken Rss Feed Fixer will frequently update a new rss feed file called 'rss.xml' you can use this file as your new rss feed file for feedburner or any thing else.</b><br>";

$frequency_in_seconds = $weather_options['interval'] * 60;
$time_difference = time() - $lastupdate_options['last_update'];

echo "<br>Current Server Time: ". date("H:i:s");
echo '<br>Last Update: '.date('H:i:s', $lastupdate_options['last_update']);
echo "<br>Next Update: " . floor(($frequency_in_seconds - $time_difference)/60).' minutes';

	echo '<br><br>Rss Update Frequency:
<select name="lang">';
	do {
		echo '<option value="'.stripslashes(current($langs)).'"'.((current($langs)==$weather_options['interval']) ? ' selected="selected"' : '').'>'.stripslashes(current($langs)).'</option>';
	}while($ab = next($langs));
	echo '</select> mintues';

	echo '</td>
</tr>
 
';
	echo '</table>
 
';
	echo '
<p class="submit">
<input type="submit" name="Submit" class="button" value="Save Changes" />
 
';
	echo '</div>
 
';
	echo '</form>
 
';

echo'<center><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="JGGGC3VM986U2">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></center>';

}

/////////////////////////////////////////


/////////////////////////////////////////
// broken rss feed fixer function
function run_broken_rss_feed_fixer() {

$lastsucessupdate = get_option('broken_rss_feed_fixer_lastupdate');
$updatefreq = get_option('broken_rss_feed_fixer_init');

$frequency_in_seconds = $updatefreq['interval'] * 60;
$time_difference = time() - $lastsucessupdate['last_update'];
$timetoupdate = $frequency_in_seconds - $time_difference ;

$brff_blogurl = get_bloginfo('url'); 
$brff_blogpath = dirname(get_theme_root()); 
$brff_blogpath = dirname($brff_blogpath); 
if($timetoupdate < 1)
{

$broken_rss_feed_fixer_lastupdate = array();
$broken_rss_feed_fixer_lastupdate['last_update'] = time();
update_option('broken_rss_feed_fixer_lastupdate', $broken_rss_feed_fixer_lastupdate);

$content=file_get_contents($brff_blogurl."/wp-rss2.php");
$array = split("<?xml ", $content);
$array2 = split("</rss>", $array[1]);
$myFile = $brff_blogpath."/rss.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "<?xml ".$array2[0]."</rss>";
fwrite($fh, $stringData);
fclose($fh);
}



}
/////////////////////////////////////////


/////////////////////////////////////////
// add script auto run
add_action ( 'wp_footer', 'run_broken_rss_feed_fixer' );
/////////////////////////////////////////
?>