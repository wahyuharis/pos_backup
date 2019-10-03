<!-- validation form -->

<script>
	$(function() {
		$('#validationForm').validate({
			rules: {
				nama_karyawan: {
					required: true
				},
				username: {
					required: true,
					remote: {
						url: '<?= base_url(
									'backoffice/user/cekUsrExist/' . $this->uri->segment(3) . '/' . $ids_karyawan
								) ?>',
						type: 'post'
					}
				},
				role: {
					required: true
				},
				telp: {
					required: true,
					minlength: 10
				},
				// email_karyawan: {
				// 	required: true,
				// 	email: true
				// },
				outlet: {
					required: true
				},
				password: function() {
					if (<?= $this->uri->segment(3) ?> != 'edit_karyawan') {
						return {
							required: true,
							minlength: 6
						}
					} else {
						return {
							required: false
						}
					}
				},
				retype: {
					equalTo: '#password'
				}
			},
			messages: {
				nama_karyawan: {
					required: "Silahkan masukkan nama karyawan"
				},
				username: {
					required: "Silahkan masukkan username",
					remote: "Username sudah ada, silahkan masukkan username yang lain."
				},
				outlet: {
					required: "Silahkan pilih outlet"
				},
				role: {
					required: "Silahkan pilih role"
				},
				telp: {
					required: "Silahkan masukkan nomor telepon karyawan",
					minlength: "Nomor telepon minimal 10 digits"
				},
				// email_karyawan: {
				// 	required: "Silahkan masukkan email karyawan",
				// 	email: "Mohon masukkan email yang benar"
				// },
				password: {
					required: "Silahkan masukkan password",
					minlength: "Password minimal 6 karakter"
				},
				retype: {
					equalTo: "Password tidak cocok"
				}

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
		});

		$("input[name='telp']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	});
</script>
