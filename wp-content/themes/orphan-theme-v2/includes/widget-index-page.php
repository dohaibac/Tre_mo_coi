<?php
class Wg_Index_Page extends WP_Widget{
	//khoi tao
	function Wg_Index_Page(){
		parent::WP_Widget(
			'Wg_Index_Page_Widget', 
			'01. Hiển thị tin trên trang chủ/Sidebar',
			array(
				'description'=>'Hiển thị thông tin theo tùy chọn(Dùng cho sidebar: Home Page, sidebar_bottom và sidebar_main)'
			));
	}
	function widget( $args, $instance ) { 
		global $wp_registered_sidebars;
        extract($args); 
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], 
            $instance, $this->id_base); 
        $text = apply_filters( 'widget_text', $instance['text'], $instance ); 
		$option_show = apply_filters( 'widget_option_show_post', $instance['option_show_post'], $instance ); 
		$option_chuyen_muc = apply_filters( 'widget_chuyen_muc', $instance['chuyen_muc'], $instance ); 
		$option_show_image = apply_filters( 'widget_option_game', $instance['option_show_image'], $instance ); 
		$show_excerpt = apply_filters( 'widget_show_excerpt', $instance['show_excerpt'], $instance ); 
		$show_position = apply_filters( 'widget_show_position', $instance['show_position'], $instance ); 
		$show_excerpt_enable = apply_filters( 'show_excerpt_enable', $instance['show_excerpt_enable'], $instance ); 
		
		$show_excerpt = ($show_excerpt == null || $show_excerpt <1) ? 20 : $show_excerpt;
		$option_show = ($show_excerpt == null || $option_show <1) ? 4 : $option_show;
        echo $before_widget; 
		$category_post = null;
		$taxonomy = 'category';
		if(isset($option_chuyen_muc) && $option_chuyen_muc>0){
			$category_post = get_term( $option_chuyen_muc, $taxonomy );
		}
		if (empty( $title ) ) { 
			if(isset($category_post)){
				$link_title = $category_post->name.'<a  class="read-more" href="'.get_term_link($category_post->slug,$taxonomy).'">Xem tiếp...</a>';
			} else {
				
				$link_title = 'Chuyên mục tin tức';
			}
		} else {
			if(isset($category_post)){
				$link_title = $title.'<a  class="read-more" href="'.get_term_link($category_post->slug,$taxonomy).'">Xem tiếp</a>';
			} else {
				$link_title = $title;
			}
		}

		 echo $before_title . $link_title. $after_title;
			$post_type = 'post';
			$args = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'showposts' => $option_show,
				'order'	=>'DESC'
			);
			
		if(isset($category_post)){
			$args['cat'] = $option_chuyen_muc;
		}
		$post_in_category = new WP_Query();
		$post_in_category->query($args);
		while($post_in_category->have_posts()) : $post_in_category->the_post(); 
			$size_image = 'width="129" height="89"';
			$large_class = 9;
			$small_class = 3;
			if($show_position == 'sidebar'){
				$large_class = 8;
				$small_class = 4;
				$size_image = 'width="80" height="55"';
			}
			
			echo '<div class="row">';
			if($option_show_image == 'default')	{
				$image = orphan_get_post_thumbnai();
				if($image == ''){
					$large_class = 12;
				} else {
					echo '<div class="large-'.$small_class.' columns">
						<a href="'.get_permalink().'"><img '.$size_image.' src="'.$image.'" class="thumb" alt="'.get_the_title().'"></a>
					</div>';
				}
				
			} else {
				$large_class = 12;
			}
			echo '<div class="large-'.$large_class.' columns">
					<h3><a title="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a></h3>';
			if($show_excerpt_enable == 'default'){
					echo '<p>';
					the_content_rss('',true,'',$show_excerpt);
					echo '</p>';
			}
			echo '</div>
				</div>';
		endwhile; wp_reset_query(); 
        echo $after_widget; 
    }
	
	function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']); 
		
		if ( current_user_can('unfiltered_html') ) {
			$instance['text'] =  $new_instance['text']; 
			$instance['option_show_post'] = $new_instance['option_show_post'];
			$instance['chuyen_muc'] = $new_instance['chuyen_muc'];
			$instance['option_show_image'] = $new_instance['option_show_image'];
			$instance['show_excerpt'] = $new_instance['show_excerpt'];
			$instance['show_excerpt_enable'] = $new_instance['show_excerpt_enable'];
			$instance['show_position'] = $new_instance['show_position'];
			}
		else{
			$instance['option_show_post'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['option_show_post']) ) 
			); 
			$instance['chuyen_muc'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['chuyen_muc']) ) 
			); 
			$instance['text'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['text']) ) 
			); 
			$instance['option_show_image'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['option_show_image']) ) 
			); 
			$instance['show_excerpt'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['show_excerpt']) ) 
			); 
			$instance['show_position'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['show_position']) ) 
			);
			$instance['show_excerpt_enable'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['show_excerpt_enable']) ) 
			); 
		}
		return $instance; 
	}
	function form( $instance ) { 
			$instance = wp_parse_args( (array) $instance, 
				array( 'title' => '', 'text' => '','option_show_post'=>'', 'chuyen_muc' =>'' , 'show_excerpt' => '', 'show_excerpt_enable' =>'', 'show_position'=>'') ); 
			$title = strip_tags($instance['title']); 
			$text = format_to_edit($instance['text']); 
			$option_show_post = format_to_edit($instance['option_show_post']); 
			$option_show_chuyen_muc = format_to_edit($instance['chuyen_muc']);
			$option_show_image = format_to_edit($instance['option_show_image']);
			$show_excerpt = format_to_edit($instance['show_excerpt']); 
			$show_excerpt_enable = format_to_edit($instance['show_excerpt_enable']); 
			$show_position = format_to_edit($instance['show_position']); 
			$option_show_args = array(
				'default' => 'Hiển thị',
				'no-image' => 'Không hiển',
			);
			$option_position_args = array(
				'home-page' => 'Trên trang chủ',
				'sidebar' => 'Trên sidebar',
			);
			$option_excerpt_args = array(
				'default' => 'Hiển thị',
				'no-description' => 'Không hiển thị',
			);
			$show_excerpt = ($show_excerpt == null || $show_excerpt <1) ? 20 : $show_excerpt;
	?> 
			<p> 
				<label for="<?php echo $this->get_field_id('title'); ?>"> 
					<?php _e('Title:'); ?> </label> 
				<input class="widefat" 
					id="<?php echo $this->get_field_id('title'); ?>" 
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo  esc_attr($title);?>" /> 
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('chuyen_muc'); ?>"> 
					<?php _e('Chọn chuyên mục:'); ?> </label> 
				<?php wp_dropdown_categories(array('hide_empty' =>1, 'show_count'=> 1, 'selected' => trim($option_show_chuyen_muc),'hide_if_empty' => true, 'taxonomy' => 'category', 'id' => $this->get_field_id('chuyen_muc'), 'name' => $this->get_field_name('chuyen_muc'), 'orderby' => 'name', 'hierarchical' => true)); ?> 	
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('show_position'); ?>"> 
					<?php _e('Vị trí hiển thị:'); ?> </label> 
				<select name="<?php echo $this->get_field_name('show_position')?>" id="<?php echo $this->get_field_id('show_position'); ?>">
					<?php foreach ($option_position_args as $key=> $value){ ?>
							<option value="<?php echo $key ?>" <?php if($key==trim($show_position)){?> selected="selected" <?php }?>><?php echo $value ?></option>
					<?php }; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('show_excerpt_enable'); ?>"> 
					<?php _e('Hiển thị tóm tắt:'); ?> </label> 
				<select name="<?php echo $this->get_field_name('show_excerpt_enable')?>" id="<?php echo $this->get_field_id('show_excerpt_enable'); ?>">
					<?php foreach ($option_excerpt_args as $key=> $value){ ?>
							<option value="<?php echo $key ?>" <?php if($key==trim($show_excerpt_enable)){?> selected="selected" <?php }?>><?php echo $value ?></option>
					<?php }; ?>
				</select>
			</p>
			<p> 
				<label for="<?php echo $this->get_field_id('show_excerpt'); ?>"> 
					<?php _e('Số từ tóm tắt bài viết:'); ?> </label> 
				<input style="width: 50px" id="<?php echo $this->get_field_id('show_excerpt'); ?>" 
					name="<?php echo $this->get_field_name('show_excerpt'); ?>" type="number"
					value="<?php echo  ($show_excerpt);?>" /> 
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('option_show_post'); ?>"><?php _e('Số lượng:'); ?></label>
				<select name="<?php echo $this->get_field_name('option_show_post')?>" id="<?php echo $this->get_field_id('option_show_post'); ?>">
					<?php for ( $i=3 ; $i<=20 ; $i++ ) : ?>
							<option value="<?php echo $i ?>" <?php if($i==trim($option_show_post)){?> selected="selected" <?php }?>><?php echo $i ?></option>
					<?php endfor; ?>
				</select>
			</p> 
			<p>
				<label for="<?php echo $this->get_field_id('option_show_image'); ?>"> 
					<?php _e('Hiển thị ảnh:'); ?> </label> 
				<select name="<?php echo $this->get_field_name('option_show_image')?>" id="<?php echo $this->get_field_id('option_show_image'); ?>">
					<?php foreach ($option_show_args as $key=> $value){ ?>
							<option value="<?php echo $key ?>" <?php if($key==trim($option_show_image)){?> selected="selected" <?php }?>><?php echo $value ?></option>
					<?php }; ?>
				</select>
			</p>
			
			
	<?php 
		} 
} 
  
register_widget('Wg_Index_Page'); 
if(function_exists('register_sidebar')){
	 register_sidebar(array(
	  'name' => 'Home Page',
	  'description' => 'Sidebar for widget: 01. Hiển thị tin trên trang chủ',
	  'before_widget'  => '<div id="widget_id_%1$s" class="row shadow-box">',
	  'after_widget'  => '</div></div>',
	  'before_title'  => '<h2>',
	  'after_title'   => '</h2><div class="box-content list-2">'
	 ));
}
