<script>
	$(document).ready(function() {

		$('#validationForm').validate({
			rules: {
				nama_customer: {
					required: true
				},
				email_customer: {
					required: true,
					email: true,

				},
				telp_customer: {
					required: true,
					minlength: 9
				},
				provinsi: {
					required: true
				},
				kabupaten: {
					required: true
				},
				kecamatan: {
					required: true
				},
				outlet: {
					required: true
				},
			},
			messages: {
				nama_customer: {
					required: "Silahkan masukkan nama customer",
				},
				email_customer: {
					required: "Silahkan masukkan email customer",
					email: "Mohon masukkan email yang benar",
					// remote: "Email sudah ada, silahkan masukkan email yang lain."
				},
				telp_customer: {
					required: "Silahkan masukkan telephone customer",
					minlength: "Format telephone salah"
				},
				provinsi: {
					required: "Silahkan pilih provinsi",
				},
				kabupaten: {
					required: "Silahkan pilih kabupaten",
				},
				kecamatan: {
					required: "Silahkan pilih kecamatan",
				},
				outlet: {
					required: "Silahkan pilih outlet",
				},
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				} else {
					error.insertAfter(element);
				}
				//error.insertAfter(element);
			},

			highlight: function(element, errorClass, validClass) {
				$(element).parents(".form-group").addClass("has-error").removeClass("has-success");
			},

			unhighlight: function(element, errorClass, validClass) {
				$(element).parents(".form-group").removeClass("has-error");
			}
		});

		$("input[name='telp_customer']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});

	});
</script>