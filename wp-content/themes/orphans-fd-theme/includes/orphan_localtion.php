<?php 
/**
* Orphan - Location
* Description 	: Management City, District, Communes
* Prefix		: orphan
* Package		: orphan
*/

/* Global */
global $wpdb,$table_orphan_cities, $table_orphan_districts, $table_orphan_communes ; 	
$table_orphan_cities  	= $wpdb->prefix . "localtion_cities";
$table_orphan_districts = $wpdb->prefix . "localtion_districts";
$table_orphan_communes 	= $wpdb->prefix . "localtion_communes";

/**
* Function name	: orphan_get_city
* Description 	: Get city by conditions
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Get city by conditions
*/
function orphan_get_city($city_id = null){
	global $wpdb,$table_orphan_cities;
	return $wpdb->get_results('select * from '.$table_orphan_cities.' ORDER BY `'.$table_orphan_cities.'`.`name` ASC; ',ARRAY_A);
}

/**
* Function name	: orphan_get_districts
* Description 	: Get districts by conditions
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Get city by districts
*/
function orphan_get_districts($city_id = null){
	global $wpdb,$table_orphan_districts;
	$where = isset($city_id) ? ' WHERE city_id='.$city_id : '';
	return $wpdb->get_results('select * from '.$table_orphan_districts.$where.' ORDER BY `'.$table_orphan_districts.'`.`name` ASC; ',ARRAY_A);
}

/**
* Function name	: orphan_get_communes
* Description 	: Get communes by conditions
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Get communes by conditions
*/
function orphan_get_communes($district_id = null){
	global $wpdb,$table_orphan_communes;
	$where = isset($district_id) ? ' WHERE district_id='.$district_id : '';
	return $wpdb->get_results('select * from '.$table_orphan_communes.$where.' ORDER BY `'.$table_orphan_communes.'`.`name` ASC; ',ARRAY_A);
}

/**
* Function name:	orphan_html_selectbox_get_city
* Description : 	Get Localtion by condition
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Get Localtion by condition
*/
function orphan_html_selectbox_localtion($option = null){
	global $wpdb,$table_orphan_cities;
	$type			= $option['type_localtion'];
	$name_selectbox	= $option['name_selectbox']; 
	$selected_value = $option['selected_value'];
	$load_data		= $option['load_data'];
	$enable_load_ajax= $option['enable_load_ajax'];
	$html = '';
	$results = array();
	$default_option = 'Tỉnh/Thành';
	$str_type = '';
	if($type == 'city'){
		$str_type = 'district';
		if($load_data){
			$results = orphan_get_city($selected_value);
		}
	} else if($type == 'commune'){
		$default_option = 'Xã/Phường';
		if($load_data){
			$results = orphan_get_communes($selected_value);
		}
	} else if($type == 'district'){
		$str_type = "commune";
		$default_option = 'Huyện/Quận';
		if($load_data){
			$results = orphan_get_districts($selected_value);
		}
	}
	$disable = '';
	if($load_data == false){
		$disable = 'DISABLED';
	}
	$ajax_action = '';
	if($enable_load_ajax == true){
		$ajax_action = 'onchange="orphan_onchange_selectbox(\''. $name_selectbox.'\'); return false;" ';
	}
	$children_id = isset($option['children_id']) ? $option['children_id'] : '';
	$html .= '<select datachild="'.$children_id.'" data="'.$str_type.'" '.$ajax_action.' id="'.$name_selectbox.'"  name="'.$name_selectbox.'"><option value="">'.$default_option.'</option>';
	if($results){
		foreach($results as $item){
			$selected = '';
			if(isset($selected_value) && $selected_value == $item['ID']){
				$selected = ' slected="selected" ';
			}
			$html .=  '<option '.$selected.' value="'.$item['ID'].'">'.$item['name'].'</option>';
		}
	}
	$html .= '</select>';							
	
	return $html;
}

/**
* Function name:	orphan_ajax_load_localtion_to_selectbox
* Description : 	ajax load localtion by conditions
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			ajax load localtion by conditions
*/
function orphan_ajax_load_localtion_to_selectbox(){
	
	$results['message'] = 'Data is empty';
	$results['status'] = 'false';
	$results['default_option'] = '';
	$results['data'] = null;
	$data = array();
	$type_localtion = isset($_POST['type_localtion']) ? $_POST['type_localtion'] : null;
	$id_selected = isset($_POST['id_selected']) ? $_POST['id_selected'] : null;
	if($type_localtion == 'city'){
		$data = orphan_get_city($id_selected);
	} else if($type_localtion == 'commune'){
		$data = orphan_get_communes($id_selected);
		$results['default_option'] = 'Xã/Phường';
	} else if($type_localtion == 'district'){
		$data = orphan_get_districts($id_selected);
		$results['default_option'] = 'Huyện/Quận';
	}
	if($data){
		$results['message'] = 'Result data';
		$results['status'] = 'true';
		$results['data'] = $data;
	}
	die(orphan_get_json($results));
	
}
// creating Ajax call for WordPress  
add_action( 'wp_ajax_nopriv_orphan_ajax_load_localtion_to_selectbox', 'orphan_ajax_load_localtion_to_selectbox' );  
add_action( 'wp_ajax_orphan_ajax_load_localtion_to_selectbox', 'orphan_ajax_load_localtion_to_selectbox' );
?>