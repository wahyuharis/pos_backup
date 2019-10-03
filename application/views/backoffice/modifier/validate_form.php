<!-- validation form -->
<script>
	$(function() {
		$('#form-produk').validate({
			ignore: "",
			rules: {
				nama_modifier: {
					required: true
				},
				// produk: {
				// 	required: true
				// },
				is_sub_modifier: {
					required: true
				}
			},
			messages: {
				nama_modifier: {
					required: "Silahkan masukkan nama modifier"
				},
				// produk: {
				// 	required: "Produk belum dicentang"
				// },
				is_sub_modifier: {
					required: "Pilihan modifier tidak boleh kosong"
				}

			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.prop("type") == "checkbox") {
					// error.insertAfter( element.parent( "label" ) );
					error.appendTo('#error-prod')
				} else if (element.prop("type") == "hidden") {
					error.appendTo('#error-sub')
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

		// $("input[name='harga_modifier']").keypress(function(e) {
		// 	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		// 		return false;
		// 	}
		// });
	});
</script>
