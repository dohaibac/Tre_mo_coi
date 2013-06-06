<?php
/* =============================== Ad 125 widget ======================================*/
class ads160 extends WP_Widget{
	function ads160(){
		$widget_ops = array('classname' => 'widget_templatelite_ads160','description' => 'Sidebar Ad widget with max width=150px');
		//$control_ops = array('width' => 300, 'height' => 300);
		$control_ops = array('width' => 300);
		$this->WP_Widget('templatelite_ads160', 'TemplateLite: Ad w160', $widget_ops, $control_ops);
	}
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$adscode = $instance['adscode'];

		echo $before_widget;
		if ( $title )    	echo $before_title . $title . $after_title;

		echo '<div class="widget_ads160">' . $adscode ."</div>";
		echo $after_widget;
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = trim(strip_tags($new_instance['title']));	//$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['adscode'] =trim($new_instance['adscode']);	//$instance['adscode'] = strip_tags(stripslashes($new_instance['adscode']));
		return $instance;
	}
	function form($instance){
		$default = array('title'=>'Advertisement', 'adscode'=>'<a href="http://www.templatelite.com/"><img src="'.get_bloginfo('template_directory').'/images/ads125.jpg" alt="ads 125"/></a>');
		$instance = wp_parse_args((array)$instance, $default);
		$title = $instance['title']; //$title = esc_attr($instance['title']);
		$adscode = $instance['adscode'];

		echo '<p><label for="'.$this->get_field_id('title').'">Title (Optional):</label>';
			echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></p>';
		
		echo '<p><label for="'.$this->get_field_id('title').'">Ad Code:</label>';
			echo '<br/>Place your ad code below<textarea class="widefat" cols="30" rows="10" id="'.$this->get_field_id('adscode').'" name="'.$this->get_field_name('adscode').'">'.$adscode.'</textarea>';
	}
}	// END class ads_125xany

class ads250 extends WP_Widget{
	function ads250(){
		$widget_ops = array('classname' => 'widget_templatelite_ads250','description' => 'Sidebar Ad widget with max width=250px, please try the sample');
		//$control_ops = array('width' => 300, 'height' => 300);
		$control_ops = array('width' => 300);
		$this->WP_Widget('templatelite_ads250', 'TemplateLite: Ad w250', $widget_ops, $control_ops);
	}
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$adscode = $instance['adscode'];

		echo $before_widget;
		if ( $title )    	echo $before_title . $title . $after_title;

		echo '<div class="widget_ads250">' . $adscode ."</div>";
		echo $after_widget;
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = trim(strip_tags($new_instance['title']));	//$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['adscode'] =trim($new_instance['adscode']);	//$instance['adscode'] = strip_tags(stripslashes($new_instance['adscode']));
		return $instance;
	}
	function form($instance){
		$default = array('title'=>'Advertisement', 'adscode'=>'Sample:<br/><a href="http://www.templatelite.com/"><img src="'.get_bloginfo('template_directory').'/images/ads125.jpg" alt="ads 125"/></a><a href="http://www.templatelite.com/"><img src="'.get_bloginfo('template_directory').'/images/ads125_2.jpg" alt="ads 125"/></a><br/><a href="http://www.templatelite.com/"><img src="'.get_bloginfo('template_directory').'/images/ads250x250.jpg" alt="ads 250 x 250"/></a>');
		$instance = wp_parse_args((array)$instance, $default);
		$title = $instance['title']; //$title = esc_attr($instance['title']);
		$adscode = $instance['adscode'];

		echo '<p><label for="'.$this->get_field_id('title').'">Title (Optional):</label>';
			echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></p>';
		
		echo '<p><label for="'.$this->get_field_id('title').'">Ad Code:</label>';
			echo '<br/>Place your ad code below<textarea class="widefat" cols="30" rows="10" id="'.$this->get_field_id('adscode').'" name="'.$this->get_field_name('adscode').'">'.$adscode.'</textarea>';
	}
}	// END class ads_125xany

function reg_widgets() {
	if(!is_blog_installed()) return;
	register_widget('ads160');
	//register_widget('ads250');
}
add_action('widgets_init', 'reg_widgets');
?>
