<!-- Right Nav Section -->
<ul class="right">
	<li class="has-form">
		<form  method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
			<div class="row collapse">
				<div class="small-7 columns" style="position: relative;">
					<input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" type="text" placeholder="Nhập từ khóa..."/>
					<span class="tooltip" style="display: none;left: 0;min-width: 140px;width: 140px;position: absolute;top: 41px;visibility: visible; font-size:12px;">Vui lòng nhập từ khóa<span class="nub"></span></span>
				</div>
				<div class="small-5 columns">
					<button id="search_button" 
							class="alert button"
							href="javascript:void(0);">Tìm kiếm</button>
				</div>
			</div>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("form#searchform #s").hover( function(e) {
					if(jQuery.trim(jQuery(this).val()) ==''){
						jQuery('form#searchform span.tooltip').fadeIn();
					} else {
						jQuery('form#searchform span.tooltip').fadeOut();
					}
				}, function(){
					jQuery('form#searchform span.tooltip').fadeOut();
				});
				jQuery("form#searchform #s").bind('input', function() { 
					if(jQuery.trim(jQuery(this).val()) ==''){
						jQuery('form#searchform span.tooltip').fadeIn();
					} else {
						jQuery('form#searchform span.tooltip').fadeOut();
					}
				});
				jQuery("form#searchform #s").focusout( function(e) {
					jQuery('form#searchform span.tooltip').fadeOut();
				});
				jQuery('form#searchform').submit(function(){
					var keyword = jQuery.trim(jQuery('form#searchform #s').val());
					if(keyword == ''){
						jQuery('form#searchform span.tooltip').fadeIn();
						jQuery('form#searchform #s').focus();
						return false;
					} else {
						jQuery('form#searchform span.tooltip').fadeOut();
					}
				});
			});
		</script>
	</li>
</ul>