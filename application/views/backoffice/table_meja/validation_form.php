<script>
	$(function() {



		$('#validationForm').validate({
			rules: {
				no_meja: {
					required: true,
					// remote: {
					// 	url: "<?php echo base_url('backoffice/table_meja/cekTableExist') ?>",
					// 	type: "post",
					// }
				},
				idgroup: {
					required: true
				},
				idoutlet: {
					required: true
				},
			},
			messages: {
				no_meja: {
					required: "Silahkan isi nomor meja",
					// remote: "Nomor meja sudah ada. Silahkan masukkan nomor meja yang lain."
				},
				idgroup: {
					required: "Silahkan pilih group meja"
				},
				idoutlet: {
					required: "Silahkan pilih outlet"
				},
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.parent("label"));
				} else if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				} else {
					error.insertAfter(element);
				}
			},

			highlight: function(element, errorClass, validClass) {
				$(element).parents(".form-group").addClass("has-error").removeClass("has-success");
			},

			unhighlight: function(element, errorClass, validClass) {
				$(element).parents(".form-group").removeClass("has-error");
			},
			submitHandler: function(form) {
				form.submit();
			}
		})
	});
</script>