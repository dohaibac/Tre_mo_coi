<?php   
/*   
Plugin Name: Import data Tre mo coi from Excel
Plugin URI: http://tremocoi.org.vn/   
Description: Allow user import data tre-mo-coi from excel file.   
Version: 1.0
Author: Long Nguyen   
Author URI: http://tremocoi.org.vn/
*/
add_filter( 'page_template', 'import_excel_page_template' );
function import_excel_page_template( $page_template )
{
    if ( is_page( 'nhap-danh-sach-tre' ) ) {
        $page_template = dirname( __FILE__ ) . '/page-import-excel.php';
    }
    return $page_template;
}
add_action('insert_excel_link','tmc_insert_excel_mt');
function tmc_insert_excel_mt(){
	echo '<br/><p style="color:red;font-size:0.9em;padding-left:10px;"><strong>Chú ý: Bạn có thể thêm nhiều trẻ theo danh sách từ file Excel <a href="'.home_url("nhap-danh-sach-tre").'">tại đây</a></strong></p>';
}
?>