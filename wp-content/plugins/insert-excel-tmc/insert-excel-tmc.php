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
?>