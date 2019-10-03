<!-- validation form -->
<script>
	$(function() {
		$('#validationForm').validate({
			rules: {
				nama_sales_type: {
					required: true
				},
				outlet: {
					required: true
				},
				'tip[]': {
					required: true
				}
			},
			messages: {
				nama_sales_type: {
					required: "Silahkan masukkan sales type"
				},
				outlet: {
					required: "Silahkan pilih outlet"
				},
				'tip[]': {
					required: "Tip belum dicentang"
				}
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.prop("type") === "checkbox") {
					// error.insertAfter( element.parent( "table" ) );
					error.appendTo('#error-checkbox')
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
			}
		});

		$("input[name='telp']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	});
</script>