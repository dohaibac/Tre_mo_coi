<!--Beggin .Begin Album-->
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_gallery') ) :endif;?>
<script language="javascript">
$(".album").jCarouselLite({
	btnNext: ".album .prev",
	btnPrev: ".album .next",
	speed: 1000,
	scroll: 5,
	visible: 5,
	beforeStart: function(){$('#album ul').css('left', '0px');}
});
</script>
<!--End Album -->