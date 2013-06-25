function email_duration(obj)
{ 
	$("#email_duration").html($(obj).text());
}

$(document).ready(function(){	
			
	$("#becomeparents_submit_button").click(function(){becomeparents();return false;});
	
	var becomeparents_validator = $('#becomeparents_form').bind("invalid-form.validate", function() {
		
         $("#becomeparents_error_container").text("Bạn cần phải điền đầy đủ và hợp lệ các thông tin bên dưới.");
		 $("#tmc_register_error_container").show();
     }).validate({
    	 
        rules:{
          'txt_name': "required",
          'txt_email': {required: true, email: true},
          'txt_address': "required",
          'txt_district': "required",        
          'txt_province': "required",          
          'txt_phone': {required:true, number: true, maxlength: 11, minlength: 9},
		  'txt_job': "required",		  
		  'txt-captcha': "required"
        },
        messages: {
        	
          'txt_name': "Nhập họ và tên.",
          'txt_email': {required: "Nhập email.", email: "Địa chỉ email không hợp lệ."},
          'txt_address': "Nhập địa chỉ (số nhà, tên đường, thôn, xóm, phường xã)",
          'txt_district': "Nhập quận (huyện)",
          'txt_province': "Nhập tỉnh (thành), Đất nước",
          'txt_phone': {required: "Nhập số điện thoại liên hệ.", number: "Nhập các chữ số hợp lệ", maxlength: "Độ dài tối đa của số điện thoại là 11 ký tự, minlength: "Độ dài tối thiểu của số điện thoại là 9 ký tự"},
          'txt_job': "Nhập nghề nghiệp.",
		  'txt-captcha': "Nhập mã bảo mật."
        },
        wrapper : 'div',
        debug: false
      });
	
	function becomeparents(){
		
	  if(becomeparents_validator.form()){
		  $('#becomeparents_form').submit();
	  }
	}
});