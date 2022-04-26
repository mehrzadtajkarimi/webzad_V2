<script>
function adminlogin()
{
	var request_login = $("#phone-number").val();
	var model = '^09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}'
	if (request_login.match(model))
	{
		var form_login = $('#form-login');
		var url = form_login.data('action_url');
		$("#login").fadeOut(function(){
			$("#login_loading").fadeIn();
			$.ajax({
				type: 'post',
				url: url,
				data: form_login.serialize(), // serializes the form's elements.
				success: function(msg) {
					$("#login_loading").fadeOut(function(){
						$("#token").fadeIn();				
					});
				},
				error: function() {
					$("#login_loading").text('خطای اتصال! از کارکردِ صحیحِ اینترنتتان اطمینان حاصل کرده و مجدداً تلاش کنید.');
					$("#login").fadeIn();
				}
			});
		});
	}
	else alert('موبایل را با ارقام لاتین بصورت یازده رقمی بدونِ اسپیس، خط فاصله یا نظایر اینها وارد کنید');
}
$(document).ready(function() {
	new WOW().init();
	$("#token-number").keyup(function(e) {
		var request_token = $("#token-number").val();
		var num_4 = '1000|[1-9][0-9][0-9][0-9]'
		if (request_token.match(num_4)) {
			var form_token = $('#form-token');
			// var url = form_token.attr('action');
			form_token.submit();
		}

	});
	if ($('#user-province').val() != "") {
		var province_id = $('#user-province').val();
		var city_id = $("#user-city").attr('data-city-id');
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>admin/user/city/" + province_id,
			data: province_id,
			success: function(response) {
				var response_array = JSON.parse(response);
				$("#user-city").empty();
				response_array.forEach(function(i) {
					if (i.id == city_id) {
							$('#user-city').append('<option value="' + i.id + '" selected>' + i.name + '</option>');
					} else {
							$('#user-city').append('<option value="' + i.id + '">' + i.name + '</option>');
					}
				})
			}
		});
	}
	
	$('#user-province').change(function() {
		var id = $(this).val();
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>admin/user/city/" + id,
			data: id,
			success: function(response) {
				var response_array = JSON.parse(response);
				$("#user-city").empty();
				response_array.forEach(function(i) {
						$('#user-city').append('<option value="' + i.id + '">' + i.name + '</option>');
				})
			}
		});
	});
});
</script>