<div class="login-form">
	<form method="POST" id="validationForm" class="form form-login" action="<?php echo base_url(); ?>home/step6" autocomplete="off">
		<h2>Step 6/7 : Input Backoffficer</h2>
		<div class="form-group">
			<label for="">Nama Backofficer</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-id-card" aria-hidden="true"></i></div>
				<input type="text" name="nama_kar" value="<?php echo $this->session->userdata('nama_kar'); ?>" class="form-control" placeholder="Backofficer" required>
			</div>
		</div>
		<div class="form-group">
			<label for="">Telp Backofficer</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white">+62</div>
				<input type="text" name="telp_kar" maxlength="13" id="no-telp" value="<?php echo $this->session->userdata('telp_kar'); ?>" class="form-control" required>
			</div>
			<em id="error-no-telp"></em>
		</div>
		<!-- <div class="form-group">
            <label for="">Email Backofficer</label>
            <input type="text" name="email_kar" value="<? php // echo $this->session->userdata('email_kar'); 
														?>" class="form-control" required>
            <div id="error-email"></div> 
        </div> -->
		<div class="form-group">
			<label for="">Username</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
				<input type="text" id="username" name="username" class="form-control" required>
			</div>
			<!-- <div id="error-pjg"></div> -->
		</div>
		<div class="form-group">
			<label for="">Password</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
				<input type="password" id="password" name="password" class="form-control" required>
			</div>
			<!-- <div id="error-pjg"></div> -->
		</div>
		<div class="form-group">
			<label for="">Password * Ulangi</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
				<input type="password" id="type_pass" name="retype" class="form-control" required>
			</div>
			<!-- <div id="error-nwl"></div> -->
		</div>
		<?php if ($this->session->userdata('kode_bo') == NULL) {; ?>
			<input type="text" style="display:none;" name="kode_bo" value="<?php echo $kode; ?>" readonly>
		<?php } else {; ?>
			<input type="text" style="display:none;" name="kode_bo" value="<?php echo $this->session->userdata('kode_bo'); ?>" readonly>
		<?php }; ?>
		<br />
		<div class="form-group">
			<a href="<?php echo base_url(); ?>home/register5" class="btn btn-default">
				<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a> <button class="btn btn-primary" id="bsub" type="submit">Konfirmasi <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
		</div>
	</form>
</div>
<script type="text/javascript">
	$(function() {
		$('#validationForm').validate({
			rules: {
				nama_kar: {
					required: true
				},
				telp_kar: {
					required: true,
					minlength: 9
				},
				// email_kar: {
				//     required: true,
				//     email: true
				// },
				username: {
					required: true,
					remote: {
						url: '<?= base_url(
									'home/cekUsrExist'
								) ?>',
						type: 'post'
					}

				},
				password: {
					required: true,
					minlength: 6
				},
				retype: {
					required: true,
					equalTo: "#password"
				},
			},
			messages: {
				nama_kar: {
					required: "Silahkan isi nama Backofficer"
				},
				telp_kar: {
					required: "Silahkan isi nomor telepone Backofficer",
					minlength: "Silahkan isi format nomor telepon yang benar"
				},
				// email_kar: {
				//     required: "Silahkan isi email Backofficer",
				//     email: "Mohon masukan alamat email yg benar",
				// },
				username: {
					required: "Silahkan isi username backofficer",
					remote: "Username sudah ada, silahkan isi username lain",
				},
				password: {
					required: "Password harus diisi",
					minlength: "Panjang password minimal 6 karakter"
				},
				retype: {
					required: "Password konfirmasi harus diisi",
					equalTo: "Password tidak sama"
				}
			},

			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				} else if (element.prop("id") === "no-telp") {
					error.appendTo('#error-no-telp')
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

		$('#no-telp').focusout(function() {
			function phoneFormat() {
				phone = phone.replace(/[^0-9]/g, '');
				phone = phone.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
				return phone;
			}
			var phone = $(this).val();
			phone = phoneFormat(phone);
			$(this).val(phone);
		});
		$("input[name='telp_kar']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	});
	// function validateEmail()
	// {
	//     var emailText = document.getElementById('email').value;
	//     var errorm = document.getElementById('error-email');
	//     var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
	//     if (pattern.test(emailText))
	//     {
	//         return true;
	//     }
	//     else
	//     {
	//         errorm.style.color = "#ff6666";
	//         errorm.innerHTML = "Mohon masukan alamat email yg benar"
	//         return false;
	//     }
	// }

	// window.onload = function()
	// {
	//     document.getElementById('validationForm').onsubmit = validateEmail;
	// }
</script>

<script type="text/javascript">
	//   function checkPass()
	//   {
	//       var pass1 = document.getElementById('password');
	//       var pass_new = document.getElementById('type_pass');
	//       var butt = document.getElementById('bsub');
	//       var message = document.getElementById('error-nwl');
	//       var message2 = document.getElementById('error-pjg');
	//       var goodColor = "#66cc66";
	//       var badColor = "#ff6666";

	//       if(pass1.value.length > 5)
	//       {
	//         message2.style.color = goodColor;
	//         message2.innerHTML = "Password sudah memenuhi syarat"

	//         if(pass1.value == pass_new.value)
	//         {
	//             message.style.color = goodColor;
	//             message.innerHTML = "Password sudah cocok"
	//             butt.disabled = false;
	//         }
	//         else
	//         {
	//             message.style.color = badColor;
	//             message.innerHTML = " Password tidak cocok"
	//             butt.disabled = true; 
	//             return;
	//         }
	//     }
	//     else
	//     {
	//         message2.style.color = badColor;
	//         message2.innerHTML = " Password minimal 6 character!"
	//         butt.disabled = true; 
	//         return;
	//     }
	// }

	// function checkPhone()
	// {
	//   var phone = document.getElementById('telp');
	//   var butt = document.getElementById('bsub');
	//   var message = document.getElementById('error-phone');
	//   var goodColor = "#66cc66";
	//   var badColor = "#ff6666";

	//   if(phone.value.length >= 10)
	//   {
	//       message.style.color = goodColor;
	//       message.innerHTML = "No telephone sudah memenuhi syarat"
	//       butt.disabled = false;
	//   }
	//   else
	//   {
	//       message.style.color = badColor;
	//       message.innerHTML = "No telephone minimal 10 digit"
	//       butt.disabled = true; 
	//       return;
	//   }
	// }
</script>