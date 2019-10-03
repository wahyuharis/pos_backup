<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/logo2.PNG">
	<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
	<title>AIO POS</title>

	<!-- CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/app.css">


	<!-- JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
</head>

<body class="loading">
	<div class="login-container">
		<div class="login-cover">
			<img src="https://images.pexels.com/photos/935756/pexels-photo-935756.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" class="bg">
			<div class="login-intro">
				<h2>AIO POS</h2>
				<?php if ($this->uri->segment(1) == 'administrator') { ?>

					<p style="font-size:18px">
						Halaman Login Administrator
					</p>

				<?php } else { ?>

					<br /><br /><br />
					<p style="font-size:18px">
						Halaman login, silahkan mengisi email dan password anda untuk dapat masuk ke dalam sistem kami jangan lupa periksa login anda sebagai siapa.
					</p>
					<p>
						<ul>
							<li>Jika anda mendapatkan kendala anda dapat hubungi kami di :</li><br>
							<li><a href="#"><i class="fa fa-phone"></i></a></li>+6287820596000<br>
							<li><a href="#"><i class="fa fa-whatsapp"></i></a></li>+6287820596000
						</ul>
					</p>
				<?php } ?>

			</div>
		</div>
		<div class="login-form">
			<?php
			$action = "";
			if ($this->uri->segment(1) == 'administrator') {
				$action = base_url('administrator/login');
			} else {
				$action = base_url('home/login');
			}

			?>
			<form id="form-login" class="form form-login" method="POST" action="<?= $action ?>" autocomplete="off">
				<?php if ($this->uri->segment(1) == 'administrator') { ?>
					<h2>Sign In Administrator</h2>
				<?php } else { ?>
					<h2>Sign In</h2>
					<div class="form-group">
						<label for="">Login As</label>
						<div class="input-group">
							<div class="input-group-addon" style="background-color: white"><i class="fa fa-id-card" aria-hidden="true"></i></div>
							<select name="login" class="form-control" id="login">
								<option value="1"> Owner </option>
								<option value="2"> Backofficer </option>
							</select>
						</div>
					</div>
				<?php } ?>
				<div id="form-group-email" class="form-group" style="display: block">
					<label for="">Email</label>
					<div class="input-group">
						<div class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></div>
						<input type="email" name="email" class="form-control" placeholder="email" required>
					</div>
				</div>
				<div id="form-group-usr" class="form-group" style="display: none">
					<label for="">Username</label>
					<div class="input-group">
						<div class="input-group-addon" style="background-color: white"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
						<input type="text" name="username" class="form-control" placeholder="username" required>
					</div>
				</div>
				<div class="form-group">
					<label for="">Password</label>
					<div class="input-group">
						<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
						<input type="password" name="password" class="form-control" placeholder="password" required>
					</div>
				</div>
				<?php if ($this->uri->segment(1) != 'administrator') { ?>
					<div class="text-right" id="text-forgot-password">
						<i><a href="<?= base_url('forgot_password') ?>">Forgot Password?</a></i>
					</div>
					<br />

				<?php } ?>
				<div class="form-group">
					<button class="btn btn-primary" type="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> LOGIN</button>
					<!--
                            <a href="<?php echo base_url(); ?>home/register" class="btn btn-default">REGISTER</a>
                        -->
				</div>
			</form>
		</div>
	</div>
	<?php $message = $this->session->flashdata('message'); ?>
	<div class="modal fade" id="failed-login">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-warning fa-5x text-warning"></i>
					<br /><br />
					<p>
						Login gagal silahkan periksa email dan dan password anda.
						<?php if ($this->uri->segment(1) != 'administrator') {
							echo "Jangan lupa periksa user group.";
						} ?>

					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="no-access">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-warning fa-5x text-warning"></i>
					<br /><br />
					<p>
						Maaf anda tidak di ijinkan mengakses halaman yang ingin anda akses.
					</p>
				</div>
			</div>
		</div>
	</div>

	<?php
	if ($this->session->flashdata('msg-reset-password')) { ?>
		<div class="modal fade" id="failed-reset">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body text-center">
						<i class="fa fa-warning fa-5x text-warning"></i>
						<br /><br />
						<p>
							<?= $this->session->flashdata('msg-reset-password'); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<script>
		$(function() {
			$('#form-login').validate({
				rules: {
					email: {
						required: true,
						email: true
					},
					username: {
						required: true,
					},
					password: {
						required: true
					}
				},
				messages: {
					email: {
						required: "email harus diisi",
						email: "mohon masukkan email yang benar",
					},
					username: {
						required: "username harus diisi",
					},
					password: {
						required: "password harus diisi"
					}

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
				}
			});

			$('#login').change(function() {
				if ($(this).val() == 1) {
					$('#form-group-email').css('display', 'block')
					$('#form-group-usr').css('display', 'none')
					$('#text-forgot-password').css('display', 'block')
					$('input[name=email]').attr('required', 'required')
					$('input[name=username]').removeAttr('required')
				} else {
					$('#form-group-email').css('display', 'none')
					$('#form-group-usr').css('display', 'block')
					$('#text-forgot-password').css('display', 'none')
					$('input[name=email]').removeAttr('required')
					$('input[name=username]').attr('required', 'required')
				}
			});

		});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#<?php echo $message; ?>").modal('show');

			setTimeout(function() {
				$('#<?php echo $message; ?>').modal('hide');
			}, 2000);

			setTimeout(function() {
				$('#ifrm').remove();
			}, 1000);
		});

		$(document).ready(function() {
			$("#failed-reset").modal('show');

			setTimeout(function() {
				$('#failed-reset').modal('hide');
			}, 2000);

			setTimeout(function() {
				$('#ifrm').remove();
			}, 1000);
		});
	</script>
</body>

</html>