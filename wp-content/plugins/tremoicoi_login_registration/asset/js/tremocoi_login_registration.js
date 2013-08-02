jQuery(document).ready(function(){		
	jQuery('#tmc_user_panel').html(jQuery('#tmc_user_panel_data').html());
	jQuery("#tmc_login_button").fancybox({scrolling: 'no', helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}, afterShow: function(){jQuery('#tmc_username').focus();}, beforeShow: function(){jQuery('#login #tmc_login_error_container').hide();}});
	jQuery("#tmc_register_button").fancybox({scrolling: 'no', beforeShow: function(){
		jQuery('#tmc_register_form_container').show();
		jQuery('#tmc_register_waiting').hide();
		jQuery('#tmc_register_error_container').hide();
		jQuery('#tmc_register_success').hide();
	}, autoDimensions : false,fitToView: false, helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}});
	
	jQuery('#tmc_username').onEnter( function() {login();});
	jQuery('#tmc_password').onEnter( function() {login();});
	jQuery('#tmc_rememberme').onEnter( function() {login();});
	jQuery("#tmc_login_submit_button").click(function(){login();});
	jQuery("#tmc_register_submit_button").click(function(){register();return false;});
	
	jQuery('#tmc_login_form_signup_link').click(function(){
		jQuery.fancybox.close();
		jQuery("#tmc_register_button").trigger("click");
	});
	
	
	var tmc_register_validator = jQuery('#tmc_register_form').bind("invalid-form.validate", function() {
         jQuery("#tmc_register_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
		 jQuery("#tmc_register_error_container").show();
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
	
	jQuery('#tmc_register_reset_button').click(function() {
		jQuery('#tmc_register_form').find("input[type=text], input[type=password], textarea").val("");
		jQuery('#txt-username').focus();
		jQuery("#tmc_register_form").data('validator').resetForm();
		jQuery('#tmc_register_error_container').css({display:"none"});
		return false;
	});
	
	function login(){
		var username = jQuery.trim(jQuery('#tmc_username').val());
		var pwd = jQuery.trim(jQuery('#tmc_password').val());
		var rememberme = jQuery('#tmc_rememberme').is(':checked') ? 'forever' : null;
		
		jQuery('#tmc_login_error_container').html('Bạn phải nhập đầy đủ thông tin.');
		
		if(username == '' || pwd == ''){
			jQuery('#tmc_login_error_container').show();
			return;
		}
		
		jQuery('#tmc_login_form').hide();
		jQuery('#tmc_login_waiting').show();
		jQuery('#tmc_login_error_container').hide();
		
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
					jQuery('#tmc_login_error_container').text('Tên đăng nhập/mật khẩu không đúng.');
					jQuery('#tmc_login_error_container').show();
					jQuery('#tmc_login_form').show();
					jQuery('#tmc_login_waiting').hide();
				}
		   }
		);
	}
	
	function register(){
		
	  if(tmc_register_validator.form()){
		 var username = jQuery.trim(jQuery('#txt-username').val());
		 var email = jQuery.trim(jQuery('#txt-mail').val());
		 var pwd = jQuery.trim(jQuery('#txt-pwd').val());
		 var first_name = jQuery.trim(jQuery('#txt-firstname').val());
		 var last_name = jQuery.trim(jQuery('#txt-lastname').val());
		 var address = jQuery.trim(jQuery('#txt-address').val());
		 var district = jQuery.trim(jQuery('#txt-district').val());
		 var province = jQuery.trim(jQuery('#txt-province').val());
		 var phone = jQuery.trim(jQuery('#txt-phone').val());
		 var captcha = jQuery.trim(jQuery('#txt-captcha').val());
		 var captcha_prefix = jQuery('#captcha_prefix').val();
		 
		jQuery('#tmc_register_form_container').hide();
		jQuery('#tmc_register_waiting').show();
		jQuery('#tmc_register_error_container').hide();
		 
		 jQuery.post(
		   ajaxurl, 
		   {
			  action:'tmc_register',
			  user_login: username, email: email, pwd: pwd,
			  first_name: first_name, last_name: last_name, address: address, district: district, province: province, phone: phone, captcha: captcha, captcha_prefix: captcha_prefix
		   }, 
		   function(response){
				var result = jQuery.parseJSON(response);
				jQuery('#txt-captcha').removeClass('error');
				jQuery('#tmc_register_waiting').hide();
				console.log(result);
				if(result.errors)
				{
					var errors = jQuery(document.createElement('ul'));
					
					if(result.errors.captcha)
					{
						errors.append('<li>Mã bảo mật không đúng.</li>');
						jQuery('#captcha_prefix').val(result.captcha.prefix);
						jQuery('#captcha_file').attr('src', result.captcha.file);
						jQuery('#txt-captcha').addClass('error');
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
					jQuery("#tmc_register_error_container").html('');
					jQuery("#tmc_register_error_container").append(errors);
					jQuery("#tmc_register_error_container").show();
					
					jQuery('#tmc_register_form_container').show();
				}
				else{
					jQuery('#tmc_register_success').html('Chúc mừng bạn đã đăng ký thành công, chúng tôi đã gửi cho bạn một email kích hoạt tài khoản đến địa chỉ <i>' + email + '</i>. Hãy kiểm tra và kích hoạt tài khoản trước khi bạn có thể đăng thông tin lên website.');
					jQuery('#tmc_register_success').show();
				}
		   }
		);
	  }
	  
	  jQuery.fancybox.reposition();
	}
});

(function(jQuery) {
    jQuery.fn.onEnter = function(func) {
        this.bind('keypress', function(e) {
            if (e.keyCode == 13) func.apply(this, [e]);    
        });               
        return this; 
     };
})(jQuery);
