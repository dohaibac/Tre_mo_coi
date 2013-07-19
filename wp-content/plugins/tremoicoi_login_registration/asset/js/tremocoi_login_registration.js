$(document).ready(function(){		
	$('#tmc_user_panel').html($('#tmc_user_panel_data').html());
	$("#tmc_login_button").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}, afterShow: function(){$('#tmc_username').focus();}, beforeShow: function(){jQuery('#login #tmc_login_error_container').hide();}});
	$("#tmc_register_button").fancybox({scrolling: 'no', beforeShow: function(){
		$('#tmc_register_form_container').show();
		$('#tmc_register_waiting').hide();
		$('#tmc_register_error_container').hide();
		$('#tmc_register_success').hide();
	}, autoDimensions : false,fitToView: false, helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}});
	
	$('#tmc_username').onEnter( function() {login();});
	$('#tmc_password').onEnter( function() {login();});
	$('#tmc_rememberme').onEnter( function() {login();});
	$("#tmc_login_submit_button").click(function(){login();});
	$("#tmc_register_submit_button").click(function(){register();return false;});
	
	$('#tmc_login_form_signup_link').click(function(){
		$.fancybox.close();
		$("#tmc_register_button").trigger("click");
	});
	
	
	var tmc_register_validator = $('#tmc_register_form').bind("invalid-form.validate", function() {
         $("#tmc_register_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
		 $("#tmc_register_error_container").show();
     }).validate({
        rules:{
          'txt-username': "required",
          'txt-email': {required: true, email: true},
          'txt-pwd': {required: true, minlength: 5},
          'txt-confirm-pwd': {required:true, equalTo: "#txt-pwd"},
		  'txt-firstname': "required",
		  'txt-lastname': "required",
		  'txt-captcha': "required"
        },
        messages: {
          'txt-username': "Nhập Tên đăng nhập.",
          'txt-email': {required: "Nhập email.", email: "Địa chỉ email không hợp lệ."},
          'txt-pwd': {required:"Nhập mật khẩu.", minlength: "Mật khẩu bạn nhập quá ngắn."},
          'txt-confirm-pwd': {equalTo: "Xác nhận mật khẩu không đúng.", required: "Nhập lại mật khẩu."},
		  'txt-captcha': "Nhập mã bảo mật.",
		  'txt-firstname': "Nhập tên",
		  'txt-lastname': "Nhập họ và tên lót"
        },
        wrapper : 'div',
        debug: false
      });
	
	$('#tmc_register_reset_button').click(function() {
		$('#tmc_register_form').find("input[type=text], input[type=password], textarea").val("");
		$('#txt-username').focus();
		$("#tmc_register_form").data('validator').resetForm();
		$('#tmc_register_error_container').css({display:"none"});
		return false;
	});
	
	function login(){
		var username = $.trim($('#tmc_username').val());
		var pwd = $.trim($('#tmc_password').val());
		var rememberme = $('#tmc_rememberme').is(':checked') ? 'forever' : null;
		
		$('#tmc_login_error_container').html('Bạn phải nhập đầy đủ thông tin.');
		
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
					if(tmc_backurl == '')
						location.href = result.Redirect;
					else
						location.href = tmc_backurl;
				}else{
					$('#tmc_login_error_container').text('Tên đăng nhập/mật khẩu không đúng.');
					$('#tmc_login_error_container').show();
					$('#tmc_login_form').show();
					$('#tmc_login_waiting').hide();
				}
		   }
		);
	}
	
	function register(){
		
	  if(tmc_register_validator.form()){
		 var username = $.trim($('#txt-username').val());
		 var email = $.trim($('#txt-mail').val());
		 var pwd = $.trim($('#txt-pwd').val());
		 var first_name = $.trim($('#txt-firstname').val());
		 var last_name = $.trim($('#txt-lastname').val());
		 var address = $.trim($('#txt-address').val());
		 var district = $.trim($('#txt-district').val());
		 var province = $.trim($('#txt-province').val());
		 var phone = $.trim($('#txt-phone').val());
		 var captcha = $.trim($('#txt-captcha').val());
		 var captcha_prefix = $('#captcha_prefix').val();
		 
		$('#tmc_register_form_container').hide();
		$('#tmc_register_waiting').show();
		$('#tmc_register_error_container').hide();
		 
		 jQuery.post(
		   ajaxurl, 
		   {
			  action:'tmc_register',
			  user_login: username, email: email, pwd: pwd,
			  first_name: first_name, last_name: last_name, address: address, district: district, province: province, phone: phone, captcha: captcha, captcha_prefix: captcha_prefix
		   }, 
		   function(response){
				var result = jQuery.parseJSON(response);
				$('#txt-captcha').removeClass('error');
				$('#tmc_register_waiting').hide();
				console.log(result);
				if(result.errors)
				{
					var errors = $(document.createElement('ul'));
					
					if(result.errors.captcha)
					{
						errors.append('<li>Mã bảo mật không đúng.</li>');
						$('#captcha_prefix').val(result.captcha.prefix);
						$('#captcha_file').attr('src', result.captcha.file);
						$('#txt-captcha').addClass('error');
					}
					else
					{
						if(result.errors.invalid_username)
							errors.append('<li>Tên đăng nhập không hợp lệ.</li>');
						if(result.errors.username_exists)
							errors.append('<li>Tên đăng nhập này đã tồn tại.</li>');
						if(result.errors.email_exists)
							errors.append('<li>Email này đã tồn tại.</li>');
					}
					
					errors.css({margin:0,padding:0,listStylePosition:'inside'});
					$("#tmc_register_error_container").html('');
					$("#tmc_register_error_container").append(errors);
					$("#tmc_register_error_container").show();
					
					$('#tmc_register_form_container').show();
				}
				else{
					$('#tmc_register_success').html('Chúc mừng bạn đã đăng ký thành công, chúng tôi đã gửi cho bạn một email kích hoạt tài khoản đến địa chỉ <i>' + email + '</i>. Hãy kiểm tra và kích hoạt tài khoản trước khi bạn có thể đăng thông tin lên website.');
					$('#tmc_register_success').show();
				}
		   }
		);
	  }
	  
	  $.fancybox.reposition();
	}
});

(function($) {
    $.fn.onEnter = function(func) {
        this.bind('keypress', function(e) {
            if (e.keyCode == 13) func.apply(this, [e]);    
        });               
        return this; 
     };
})(jQuery);
