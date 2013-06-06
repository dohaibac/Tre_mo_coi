(function($) {
    $.fn.onEnter = function(func) {
        this.bind('keypress', function(e) {
            if (e.keyCode == 13) func.apply(this, [e]);    
        });               
        return this; 
     };
})(jQuery);

$(document).ready(function(){		
	$('#tmc_user_panel').html($('#tmc_user_panel_data').html());
	$("#tmc_login_button").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}, afterShow: function(){$('#tmc_username').focus();}});
	$("#tmc_register_button").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}});
	
	$('#tmc_username').onEnter( function() {login();});
	$('#tmc_password').onEnter( function() {login();});
	$('#tmc_rememberme').onEnter( function() {login();});
	$("#tmc_login_submit_button").click(function(){
		login();
	});
	
	function login(){
				var username = $.trim($('#tmc_username').val());
		var pwd = $.trim($('#tmc_password').val());
		var rememberme = $('#tmc_rememberme').is(':checked') ? 'forever' : null;
		
		if(username == '' || pwd == ''){
			$('#tmc_login_error_container').show();
			return;
		}
		
		$('#tmc_login_form').hide();
		$('#tmc_login_waiting').show();
		$('#tmc_login_error_container').hide();
		
		jQuery.post(
		   ajaxurl, 
		   {
			  action:'tmc_login',
			  log: username, pwd: pwd, rememberme: rememberme
		   }, 
		   function(response){
				var result = jQuery.parseJSON(response);
				if(result.Success){
					location.href = result.Redirect;
				}else{
					$('#tmc_login_error_container').text('Tên đăng nhập/mật khẩu không đúng.');
					$('#tmc_login_error_container').show();
					$('#tmc_login_form').show();
					$('#tmc_login_waiting').hide();
				}
		   }
		);
	}
});
