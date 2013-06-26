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
		  var rbn_email_duration = $.trim($("#rbn_email_duration").val());
		  var txt_birthyear = $.trim($("#txt_birthyear").val());
		  var rbn_gender = $.trim($("#rbn_gender").val());
		  var txt_note = $.trim($("#txt_note").val());
		  var captcha_prefix = $.trim($("#captcha_prefix").val());
		  var txt_captcha = $.trim($("#txt_captcha").val());
		  var rbn_email_duration = $.trim($("#rbn_email_duration").val());
		  
		  jQuery.post(
			  action_ajax_url, 
			   {
				  action:'insert_becomeparents',
				  txt_address: txt_address, txt_district: txt_district, txt_province: txt_province,
				  txt_phone: txt_phone, txt_phone_static: txt_phone_static, txt_job: txt_job, txt_income: txt_income, 
				  txt_email: txt_email,
				  txt_reason: txt_reason, rbn_email_duration: rbn_email_duration, txt_birthyear: txt_birthyear, rbn_gender: rbn_gender, txt_note: txt_note,
				  captcha_prefix: captcha_prefix, txt_captcha: txt_captcha
			   }, 
			   function(response){
					var result = jQuery.parseJSON(response);
					if(result.errors)
					{
						var errors = $(document.createElement('ul'));
						
						if(result.errors.captcha_error)
						{
//							errors.append('<li>'+ result.errors.captcha_error +'</li>');
							$('#captcha_prefix').val(result.captcha_new.prefix);
							$('#captcha_file').attr('src', result.captcha_new.file);
							$('#txt-captcha').val();
							$('#txt_captcha_error').show();
							$('#txt_captcha_error_label').show();
						}
//						else
//						{
//							errors.append('<li>Xin lỗi hệ thống chưa thể lưu nhu cầu của bạn. Vui lòng <a href='+document.domain+'"/lien-he">liên hệ với người quản trị</a> để biết thêm chi tiết.</li>');
//						}
//						
//						errors.css({margin:0,padding:0,listStylePosition:'inside'});
//						$("#becomeparents_error_container").html('');
//						$("#becomeparents_error_container").append(errors);
//						$("#becomeparents_error_container").show();
//
//						$('#becomeparents_success_container').html('');
//						$('#becomeparents_success_container').hide();
					}
					else{

						$('#txt_captcha_error').hide();
						$('#becomeparents_success_container').html('Chúc mừng bạn đã đăng ký nhận thông tin trẻ thành công. Chúng tôi đã sẽ gửi cho bạn email những trẻ phù hợp với nhu cầu của ban đến địa chỉ <i>' + txt_email + '</i> trong vòng '+  rbn_email_duration+' tháng. Hãy kiểm tra và hủy chức năng nhận email theo đường dẫn ngay trong email mà bạn nhận được.');
						$('#becomeparents_success_container').show();
					}
					
					$("#waiting").hide();
			   }
			);
	  }
	}
	
	$("#becomeparents_submit_button").click(function(){becomeparents();return false;});
	
	becomeparents_validator = $('#becomeparents_form').bind("invalid-form.validate", function() {
		
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
		  'txt-captcha': "required",
          'txt_phone_static': {number: true}
        },
        messages: {
        	
          'txt_name': "Nhập họ và tên.",
          'txt_email': {required: "Nhập email.", email: "Địa chỉ email không hợp lệ."},
          'txt_address': "Nhập địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)",
          'txt_district': "Nhập quận (huyện)",
          'txt_province': "Nhập tỉnh (thành), Đất nước",
          'txt_phone': {required: "Nhập số điện thoại liên hệ.", number: "Nhập các chữ số hợp lệ", maxlength: "Độ dài tối đa của số điện thoại là 11 ký tự", minlength: "Độ dài tối thiểu của số điện thoại là 10 ký tự"},
          'txt_phone_static': {number: "Nhập các chữ số hợp lệ", maxlength: "Độ dài tối đa của số điện thoại là 11 ký tự", minlength: "Độ dài tối thiểu của số điện thoại là 9 ký tự"},
          'txt_job': "Nhập nghề nghiệp.",
		  'txt-captcha': "Nhập mã bảo mật.",
          'txt_phone_static': {number: "Nhập các chữ số hợp lệ"}
        },
        wrapper : 'div',
        debug: false
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
});