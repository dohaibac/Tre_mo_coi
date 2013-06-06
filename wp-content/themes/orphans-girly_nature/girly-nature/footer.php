<!-- #footer start-->
<?php global $tpinfo;?>
		<div class="clear"></div>
	</div></div></div><!--  #container_btm, #container_top, #container -->
	<div id="footer">
		<div id="footer_credit">
			&copy; <?php echo date("Y");?> - <?php bloginfo('name'); ?> is powered by <a href="http://wordpress.org/">WordPress</a><br/>
			<?php /*Please leave 1 credit line to the theme designer. Thanks.*/ theme_credit();?><br/>
		</div>
	</div><!-- #footer-->
</div></div></div><!-- #base_btm ,#base_top, #base -->
</div><!-- #bg_btm -->
</div><!-- #bg_top -->
<div class="hide-div"><?php echo !empty($tpinfo['templatelite_analytics'])? stripslashes($tpinfo['templatelite_analytics']):"";?></div>
<?php wp_footer();?>
</body>
</html>
