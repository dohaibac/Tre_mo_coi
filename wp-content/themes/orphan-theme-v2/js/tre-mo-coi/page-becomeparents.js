function email_duration(obj)
{ 
	$("#email_duration").html($(obj).text());
}


$(document).ready(function(){

	function becomeparents(){
		
	  if(becomeparents_validator.form()){
		  
		  $("#waiting").show();

		  var txt_address = $.trim($("#txt_address").val());
		  var txt_district = $.trim($("#txt_district").val());
		  var txt_province = $.trim($("#txt_province").val());
		  var txt_phone = $.trim($("#txt_phone").val());
		  var txt_phone_static = $.trim($("#txt_phone_static").val());
		  var txt_job = $.trim($("#txt_job").val());
		  var txt_income = $.trim($("#txt_income").val());
		  var txt_email = $.trim($("#txt_email").val());
		  var txt_reason = $.trim($("#txt_reason").val());
		  var rbn_email_duration = $('input:radio[name=rbn_email_duration]:checked').val();
		  var sel_birthyear = $("#sel_birthyear option:selected").val();
          
		  var rbn_gender = $('input:radio[name=rbn_gender]:checked').val();
		  var txt_note = $.trim($("#txt_note").val());
		  var captcha_prefix = $.trim($("#captcha_prefix").val());
		  var txt_captcha = $.trim($("#txt_captcha").val());
		  
		  jQuery.post(
			  action_ajax_url, 
			   {
				  action:'insert_becomeparents',
				  txt_address: txt_address, txt_district: txt_district, txt_province: txt_province,
				  txt_phone: txt_phone, txt_phone_static: txt_phone_static, txt_job: txt_job, txt_income: txt_income, 
				  txt_email: txt_email,
				  txt_reason: txt_reason, rbn_email_duration: rbn_email_duration, sel_birthyear: sel_birthyear, rbn_gender: rbn_gender, txt_note: txt_note,
				  captcha_prefix: captcha_prefix, txt_captcha: txt_captcha
			   }, 
			   function(response){

					$('#txt_captcha_error').hide();
					$('#txt_captcha_error_label').hide();
					$("#becomeparents_error_container").html('');
					$("#becomeparents_error_container").hide();
					
					var result = jQuery.parseJSON(response);
					if(result.errors)
					{
						var errors = $(document.createElement('ul'));
						
						if(result.errors.captcha_error)
						{
							$('#txt_captcha_error').show();
							$('#txt_captcha_error_label').show();
						}
					}
					else{
						
						$('#becomeparents_success').fancybox({scrolling: 'no', beforeShow: function(){
							$('#email-and-duration').html('<i><b>' + txt_email + '</b></i> trong vòng <i><b>'+  rbn_email_duration+'</b></i> tháng.');
							$('#becomeparents_success').show();
						}, autoDimensions : false,fitToView: false, helpers: {title : {type : 'outside'}, overlay : { speedOut : 0}}});
						$("#becomeparents_success").trigger('click');
					}
					
					$("#waiting").hide();

					$('#captcha_prefix').val(result.captcha_new.prefix);
					$('#captcha_file').attr('src', result.captcha_new.file);
					$('#txt_captcha').val("");
			   }
			);
	  }
	}
	
	$("#becomeparents_submit_button").click(function(){becomeparents();return false;});
	
	becomeparents_validator = $('#becomeparents_form').bind("invalid-form.validate", function() {
		
		 $("#txt_captcha_error").hide();
         $("#becomeparents_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
		 $("#becomeparents_error_container").show();
     }).validate({
    	 
        rules:{
          'txt_name': "required",
          'txt_email': {required: true, email: true},
          'txt_address': "required",
          'txt_district': "required",        
          'txt_province': "required",          
          'txt_phone': {required:true, number: true, maxlength: 11, minlength: 10},
          'txt_phone_static': {number: true, maxlength: 11, minlength: 9},
		  'txt_job': "required",	
		  'txt_captcha': "required"
        },
        messages: {
        	
          'txt_name': "Nhập họ và tên.",
          'txt_email': {required: "Nhập email.", email: "Địa chỉ email không hợp lệ."},
          'txt_address': "Nhập địa chỉ (số nhà, tên đường, thôn, xóm, phường xã).",
          'txt_district': "Nhập quận (huyện).",
          'txt_province': "Nhập tỉnh (thành), Đất nước.",
          'txt_phone': {required: "Nhập số điện thoại liên hệ.", number: "Nhập các chữ số hợp lệ.", maxlength: "Độ dài tối đa của số điện thoại là 11 ký tự.", minlength: "Độ dài tối thiểu của số điện thoại là 10 ký tự."},
          'txt_phone_static': {number: "Nhập các chữ số hợp lệ.", maxlength: "Độ dài tối đa của số điện thoại là 11 ký tự.", minlength: "Độ dài tối thiểu của số điện thoại là 9 ký tự."},
          'txt_job': "Nhập nghề nghiệp.",
          'txt_captcha': "Nhập mã bảo mật."
        },
        wrapper : 'div',
        debug: false
      });
	
	$("#txt_captcha").keyup(function(){

		 $("#txt_captcha_error").hide();
	});
	
	$("#edit_email").click(function(){
		
		$("#txt_email").removeAttr("disabled");
		$(this).hide();
		$("#save_email").show();
	});
	
	$("#save_email").click(function(){
		
		$("#waiting").show();
		
		$("#txt_email").attr("disabled", true);
		
		  var txt_email = $.trim($("#txt_email").val());
		  
		  jQuery.post(
			  action_ajax_url, 
			   {
				  action:'edit_email',
				  txt_email: txt_email
			   }, 
			   function(response){
					var result = jQuery.parseJSON(response);
					if(result.errors)
					{
						var errors = $(document.createElement('ul'));
						
						errors.append('<li>Xin lỗi hệ thống chưa thể lưu nhu cầu của bạn. Vui lòng <a href='+document.domain+'"/lien-he">liên hệ với người quản trị</a> để biết thêm chi tiết.</li>');
						
						errors.css({margin:0,padding:0,listStylePosition:'inside'});
						$("#becomeparents_error_container").html('');
						$("#becomeparents_error_container").append(errors);
						$("#becomeparents_error_container").show();

						$('#becomeparents_success_container').html('');
						$('#becomeparents_success_container').hide();
					}
					else{
						$('#becomeparents_success_container').html('Bạn đã sửa thành công địa chỉ email.');
						$('#becomeparents_success_container').show();
					}
					
					$("#waiting").hide();
			   }
			);
		  
		$(this).hide();
		$("#edit_email").show();
	});
	
	
	$("#back_to_home").click(function(){

		parent.parent.jQuery.fancybox.close();
		window.location.replace(site_url);
	});
	
	
	$("#back_to_previous_page").click(function(){
		
		parent.parent.jQuery.fancybox.close();
		window.history.back();
	});
});