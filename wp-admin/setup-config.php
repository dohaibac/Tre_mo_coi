<?php
/**
 * Tạo tập tin wp-config.php
 *
 * Thư mục mẹ phải có quyền ghi để tập tin wp-cònfig.php có thể được tạo ra
 * thông qua trang này
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * Chúng ta đang cài đặt.
 *
 * @package WordPress
 */
define('WP_INSTALLING', true);

/**
 * We are blissfully unaware of anything.
 */
define('WP_SETUP_CONFIG', true);

/**
 * Disable error reporting
 *
 * Set this to error_reporting( E_ALL ) or error_reporting( E_ALL | E_STRICT ) for debugging
 */
error_reporting(0);

/**#@+
 * These three defines are required to allow us to use require_wp_db() to load
 * the database class while being wp-content/db.php aware.
 * @ignore
 */
define('ABSPATH', dirname(dirname(__FILE__)).'/');
define('WPINC', 'wp-includes');
define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
define('WP_DEBUG', false);
/**#@-*/

require_once(ABSPATH . WPINC . '/load.php');
require_once(ABSPATH . WPINC . '/compat.php');
require_once(ABSPATH . WPINC . '/functions.php');
require_once(ABSPATH . WPINC . '/classes.php');
require_once(ABSPATH . WPINC . '/version.php');

if (!file_exists(ABSPATH . 'wp-config-sample.php'))
	wp_die('Xin lỗi, không tìm thấy tập tin wp-config-sample.php. Hãy tải tập tin đó lên vào trong thư mục của WordPress.');

$configFile = file(ABSPATH . 'wp-config-sample.php');

// Kiểm tra xem tập tin wp-config.php đã được tạo chưa
if (file_exists(ABSPATH . 'wp-config.php'))
	wp_die("<p>Tập tin 'wp-config.php' đã tồn tại. Nếu bạn muốn thay đổi các thông tin trong tập tin này, hãy xóa tập tin đó đi và <a href='install.php'>cài đặt mới</a>.</p>");

// Kiểm tra xem tập tin wp-config.php có tồn tại trong thư mục chủ và không phải là của một bản cài khác
if (file_exists(ABSPATH . '../wp-config.php') && ! file_exists(ABSPATH . '../wp-settings.php'))
wp_die("<p>Tập tin 'wp-config.php' đã tồn tại tại thư mục mẹ của thư mục WordPress. Nếu bạn muốn thay đổi các thông tin trong tập tin này, hãy xóa tập tin đó đi và <a href='install.php'>cài đặt mới</a>.</p>");

if ( version_compare( $required_php_version, phpversion(), '>' ) )
	wp_die( sprintf( /*WP_I18N_OLD_PHP*/'Bạn đang sử dụng PHP phiên bản %1$s nhưng WordPress yêu cầu phiên bản %2$s.'/*/WP_I18N_OLD_PHP*/, phpversion(), $required_php_version ) );

if ( !extension_loaded('mysql') && !file_exists(ABSPATH . 'wp-content/db.php') )
	wp_die( /*WP_I18N_OLD_MYSQL*/'Phiên bản PHP của bạn thiếu phần hỗ trợ MySQL.'/*/WP_I18N_OLD_MYSQL*/ );

if (isset($_GET['step']))
	$step = $_GET['step'];
else
	$step = 0;

/**
 * Hiển thị cài đặt cho wp-config.php.
 *
 * @ignore
 * @since 2.3.0
 * @package WordPress
 * @subpackage Installer_WP_Config
 */
function display_header() {
	header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WordPress &rsaquo; Thiết lập tập tin cấu hình</title>
<link rel="stylesheet" href="css/install.css" type="text/css" />

</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>
<?php
}//end function display_header();

switch($step) {
	case 0:
		display_header();
?>

<p>Chào mừng bạn đến với WordPress. Trước khi bắt đầu, bạn cần cung cấp thông tin về cơ sở dữ liệu. Bạn hãy chuẩn bị các thông tin sau trước khi tiếp tục.</p>
<ol>
	<li>Tên cơ sở dữ liệu</li>
	<li>Tài khoản để kết nối với cơ sở dữ liệu</li>
	<li>Mật khẩu của tài khoản</li>
	<li>Máy chủ của cơ sở dữ liệu</li>
	<li>Tiền tố của bảng (nếu bạn muốn cài nhiều WordPress chung trong một cơ sở dữ liệu) </li>
</ol>
<p><strong>Vì lí do nào đó mà tập tin cấu hình không tạo ra tự động được, bạn đừng lo lắng. Hãy điền những thông tin này vào tập tin cấu hình mẫu. Bạn có thể mở tập tin <code>wp-config-sample.php</code> với chương trình chỉnh sửa văn bản, điền thông tin về cơ sở dữ liệu, và lưu lại dưới tên <code>wp-config.php</code>. </strong></p>
<p>Nếu bạn không có các thông tin này, hãy liên hệ với nhà cung cấp dịch vụ web của bạn. Nếu bạn đã sẵn sàng&hellip;</p>

<p class="step"><a href="setup-config.php?step=1" class="button">Nhập thông tin về cơ sở dữ liệu!</a></p>
<?php
	break;

	case 1:
		display_header();
	?>
<form method="post" action="setup-config.php?step=2">
	<p>Bạn hãy điền thông tin về cơ sở dữ liệu. Nếu bạn không chắc chắn về các thông tin sau, hãy liên hệ nhà cung cấp dịch vụ web của bạn. </p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Tên cơ sở dữ liệu</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="wordpress" /></td>
			<td>Tên của cơ sở dữ liệu mà bạn muốn dùng cho WordPress. </td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">Tài khoản</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="username" /></td>
			<td>Tài khoản để kết nối với cơ sở dữ liệu MySQL</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Mật khẩu</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" /></td>
			<td>...và mật khẩu của tài khoản.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Máy chủ cơ sở dữ liệu</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>Bạn phải liên hệ với nhà cung cấp host để có được thông tin này trong trường hợp bạn không sử dụng được <code>localhost</code>.</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">Tiền tố của bảng</label></th>
			<td><input name="prefix" id="prefix" type="text" id="prefix" value="wp_" size="25" /></td>
			<td>Nếu bạn muốn dùng chung một cơ sở dữ liệu cho nhiều WordPress, hãy thay đổi tiền tố của bảng.</td>
		</tr>
	</table>
	<?php if ( isset( $_GET['noapi'] ) ) { ?><input name="noapi" type="hidden" value="true" /><?php } ?>
	<p class="step"><input name="submit" type="submit" value="Tiếp tục" class="button" /></p>
</form>
<?php
	break;

	case 2:
	$dbname  = trim($_POST['dbname']);
	$uname   = trim($_POST['uname']);
	$passwrd = trim($_POST['pwd']);
	$dbhost  = trim($_POST['dbhost']);
	$prefix  = trim($_POST['prefix']);
	if ( empty($prefix) )
		$prefix = 'wp_';

	// Validate $prefix: it can only contain letters, numbers and underscores
	if ( preg_match( '|[^a-z0-9_]|i', $prefix ) )
		wp_die( /*WP_I18N_BAD_PREFIX*/'<strong>LỖI</strong>: "Tiền tố cho bảng" chỉ có thể chứa số, chữ và dấu gạch chân.'/*/WP_I18N_BAD_PREFIX*/ );

	// Test the db connection.
	/**#@+
	 * @ignore
	 */
	define('DB_NAME', $dbname);
	define('DB_USER', $uname);
	define('DB_PASSWORD', $passwrd);
	define('DB_HOST', $dbhost);
	/**#@-*/

	// We'll fail here if the values are no good.
	require_wp_db();
	if ( !empty($wpdb->error) )
		wp_die($wpdb->error->get_error_message());

	// Fetch or generate keys and salts.
	$no_api = isset( $_POST['noapi'] );
	require_once( ABSPATH . WPINC . '/plugin.php' );
	require_once( ABSPATH . WPINC . '/l10n.php' );
	require_once( ABSPATH . WPINC . '/pomo/translations.php' );
	if ( ! $no_api ) {
		require_once( ABSPATH . WPINC . '/class-http.php' );
		require_once( ABSPATH . WPINC . '/http.php' );
		wp_fix_server_vars();
		/**#@+
		 * @ignore
		 */
		function get_bloginfo() {
			return ( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . str_replace( $_SERVER['PHP_SELF'], '/wp-admin/setup-config.php', '' ) );
		}
		/**#@-*/
		$secret_keys = wp_remote_get( 'https://api.wordpress.org/secret-key/1.1/salt/' );
	}

	if ( $no_api || is_wp_error( $secret_keys ) ) {
		$secret_keys = array();
		require_once( ABSPATH . WPINC . '/pluggable.php' );
		for ( $i = 0; $i < 8; $i++ ) {
			$secret_keys[] = wp_generate_password( 64, true, true );
		}
	} else {
		$secret_keys = explode( "\n", wp_remote_retrieve_body( $secret_keys ) );
		foreach ( $secret_keys as $k => $v ) {
			$secret_keys[$k] = substr( $v, 28, 64 );
		}
	}
	$key = 0;

	foreach ($configFile as $line_num => $line) {
		switch (substr($line,0,16)) {
			case "define('DB_NAME'":
				$configFile[$line_num] = str_replace("database_name_here", $dbname, $line);
				break;
			case "define('DB_USER'":
				$configFile[$line_num] = str_replace("'username_here'", "'$uname'", $line);
				break;
			case "define('DB_PASSW":
				$configFile[$line_num] = str_replace("'password_here'", "'$passwrd'", $line);
				break;
			case "define('DB_HOST'":
				$configFile[$line_num] = str_replace("localhost", $dbhost, $line);
				break;
			case '$table_prefix  =':
				$configFile[$line_num] = str_replace('wp_', $prefix, $line);
				break;
			case "define('AUTH_KEY":
			case "define('SECURE_A":
			case "define('LOGGED_I":
			case "define('NONCE_KE":
			case "define('AUTH_SAL":
			case "define('SECURE_A":
			case "define('LOGGED_I":
			case "define('NONCE_SA":
				$configFile[$line_num] = str_replace('put your unique phrase here', $secret_keys[$key++], $line );
				break;
		}
	}
	if ( ! is_writable(ABSPATH) ) :
		display_header();
?>
<p>Xin lỗi, tôi không thể sửa tập tin <code>wp-config.php</code>.</p>

<p>Bạn có thể tự tạo tập tin <code>wp-config.php</code> và sao chép văn bản sau vào tập tin đó.</p>
<textarea cols="98" rows="15" class="code"><?php
		foreach( $configFile as $line ) {
			echo htmlentities($line, ENT_COMPAT, 'UTF-8');
		}
?></textarea>

<p>Sau khi bạn đã tạo tập tin này, bạn hãy ấn "Cài đặt."</p>
<p class="step"><a href="install.php" class="button">Cài đặt</a></p>
<?php
	else :
		$handle = fopen(ABSPATH . 'wp-config.php', 'w');
		foreach( $configFile as $line ) {
			fwrite($handle, $line);
		}
		fclose($handle);
		chmod(ABSPATH . 'wp-config.php', 0666);
		display_header();
?>
<p>Hoàn hảo! WordPress giờ đã có thể kết nối vởi cơ sở dữ liệu với các thông tin bạn cung cấp. Nếu bạn sẵn sàng, đã đến lúc&hellip;</p>

<p class="step"><a href="install.php" class="button">Cài đặt WordPress của bạn</a></p>
<?php
	endif;
	break;
}
?>
</body>
</html>
