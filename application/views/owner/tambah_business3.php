<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Step 3 : Tambah Data Backofficer</h4>
        Backofficer adalah orang yang bertanggung jawab menjalankan usaha anda.
        <hr/>
        <div class="form">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>owner/business/step3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" value="<?php echo $this->session->userdata('nama_kar'); ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">No Telp</label>
                            <input type="text" id="telp" onkeyup="checkPhone(); return false;" name="telp" value="<?php echo $this->session->userdata('telp_kar'); ?>" class="form-control">
                            <div id="error-phone"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email Karyawan</label>
                            <input type="text" id="email" name="email_karyawan" value="<?php echo $this->session->userdata('email_kar'); ?>" class="form-control">
                            <div id="error-email"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Password * Ulangi</label>
                            <input type="password" id="type_pass" name="retype" onkeyup="checkPass(); return false;" class="form-control">
                            <div id="error-nwl"></div>
                        </div>
                        <input type="text" name="kode_user" value="<?php echo $kode; ?>" class="form-control" readonly>
                    </div>
                </div>

                <hr/>
                <a href="<?php echo base_url(); ?>owner/business/tambah_business2" class="btn btn-primary">< Back</a>
                <button type="submit" id="bsub" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
-->

<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4>Step 3 : Tambah Data Backofficer</h4>
			Backofficer adalah orang yang bertanggung jawab menjalankan usaha anda.
		</div>
	</div>
	<div class="form">
		<form id="form-business" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>owner/business/step3">
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Nama Backofficer</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-id-card" aria-hidden="true"></i></div>
									<input type="text" placeholder="Nama Backofficer" name="nama_karyawan" value="<?php echo $this->session->userdata('nama_kar'); ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="">No Telp</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white">+62</div>
									<input type="text" placeholder="89-909" id="no-telp" name="telp" value="<?php echo $this->session->userdata('telp_kar'); ?>" class="form-control">
								</div>
								<!-- <div id="error-phone"></div> -->
							</div>
							<div class="form-group">
								<label for="">Username</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-user" aria-hidden="true"></i></div>
									<input type="text" id="username" name="username" value="<?php echo $this->session->userdata('username_kar'); ?>" class="form-control">
								</div>
								<!-- <div id="error-email"></div> -->
							</div>
							<!-- <div class="form-group">
								<label for="">Email Karyawan</label>
								<input type="text" id="email" name="email_karyawan" value="<?php //echo $this->session->userdata('email_kar'); 
																							?>" class="form-control">
								<div id="error-email"></div>
							</div> -->
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Password</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
									<input type="password" id="password" name="password" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label for="">Password * Ulangi</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
									<input type="password" id="type_pass" name="retype" class="form-control">
								</div>
								<!-- <div id="error-nwl"></div> -->
							</div>
							<input type="text" style="display: none;" name="kode_user" value="<?php echo $kode; ?>" class="form-control" readonly>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="form-group">
								<a href="<?php echo base_url(); ?>owner/business/tambah_business2" class="btn btn-primary">
									<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a> <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#form-business').validate({
		rules: {
			nama_karyawan: {
				required: true
			},
			telp: {
				required: true,
				minlength: 9
			},
			username: {
				required: true,
				remote: {
					url: "<?= base_url('owner/business/cekUsrExist') ?>",
					type: "post"
				}
			},
			password: {
				required: true
			},
			retype: {
				equalTo: "#password"
			}
		},
		messages: {
			nama_karyawan: {
				required: "Silahkan masukkan nama backofficer"
			},
			telp: {
				required: "Silahkan masukkan nomor telephone",
				minlength: "Format telephone salah"
			},
			username: {
				required: "Silahkan masukkan username",
				remote: "Username sudah ada, silahkan masukkan username lainnya",
			},
			password: {
				required: "Silahkan masukkan password"
			},
			retype: {
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
	})

	$("input[name='telp']").keypress(function(e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	// function validateEmail() {
	// 	var emailText = document.getElementById('email').value;
	// 	var errorm = document.getElementById('error-email');
	// 	var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
	// 	if (pattern.test(emailText)) {
	// 		return true;
	// 	} else {
	// 		errorm.style.color = "#ff6666";
	// 		errorm.innerHTML = "Mohon masukan alamat email yg benar"
	// 		return false;
	// 	}
	// }

	// window.onload = function() {
	// 	document.getElementById('validationForm').onsubmit = validateEmail;
	// }
</script>

<script type="text/javascript">
	// function checkPass() {
	// 	var pass1 = document.getElementById('password');
	// 	var pass_new = document.getElementById('type_pass');
	// 	var butt = document.getElementById('bsub');
	// 	var message = document.getElementById('error-nwl');
	// 	var goodColor = "#66cc66";
	// 	var badColor = "#ff6666";

	// 	if (pass1.value == pass_new.value) {
	// 		message.style.color = goodColor;
	// 		message.innerHTML = "Password sudah cocok"
	// 		butt.disabled = false;
	// 	} else {
	// 		message.style.color = badColor;
	// 		message.innerHTML = " Password tidak cocok"
	// 		butt.disabled = true;
	// 		return;
	// 	}
	// }

	// function checkPhone() {
	// 	var phone = document.getElementById('telp');
	// 	var butt = document.getElementById('bsub');
	// 	var message = document.getElementById('error-phone');
	// 	var goodColor = "#66cc66";
	// 	var badColor = "#ff6666";

	// 	if (phone.value.length >= 10) {
	// 		message.style.color = goodColor;
	// 		message.innerHTML = "No telephone sudah memenuhi syarat"
	// 		butt.disabled = false;
	// 	} else {
	// 		message.style.color = badColor;
	// 		message.innerHTML = "No telephone minimal 10 digit"
	// 		butt.disabled = true;
	// 		return;
	// 	}
	// }
</script>