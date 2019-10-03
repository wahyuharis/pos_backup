<div class="wrapper">
	<?php
	$idou = $this->session->userdata('outlet_kar');
	$outlet = $this->db->query("SELECT * FROM outlet WHERE idoutlet='$idou'")->row_array();
	$ids_karyawan = null;
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Tambah Karyawan</h4>
		</div>
		<div class="panel-body">
			<div class="form">
				<form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/user/insert_karyawan" autocomplete="off">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Nama Karyawan</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-address-card" aria-hidden="true"></i></div>
									<input id="nama_karyawan" type="text" name="nama_karyawan" value="<?php echo $this->session->userdata('nama_kar'); ?>" class="form-control custom-error" placeholder="Nama Karyawan" required>
								</div>

							</div>
							<div class="form-group">
								<label for="">Username</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
									<input id="username" type="text" name="username" value="" class="form-control" placeholder="Username" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Outlet</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
									<select name="outlet" id="outlet_dropdown" class="form-control">
										<?php if ($idou == NULL) {; ?>
											<option value="">-- Pilih Outlet --</option>
										<?php } else {; ?>
											<option value="<?php echo $outlet['idoutlet']; ?>"><?php echo $outlet['name_outlet']; ?></option>
										<?php }; ?>
										<?php foreach ($comout as $rw) : ?>
											<option value="<?php echo $rw->idoutlet; ?>"><?php echo $rw->name_outlet; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<?php $rol = $this->session->userdata('role_kar');
							$role_sess = $this->session->userdata('role_user');

							$whr = array(
								'idbusiness' => $this->session->userdata('id_business'),
								'role_user' => 2,
								'status_user' => 1,
								'del' => 1,
							);
							$count_user = $this->db->get_where('user', $whr)->num_rows();
							//echo $count_user;
							// echo $this->uri->segment(3);
							//echo $this->session->userdata('id_business');

							?>
							<!-- <div class="form-group">
								<label for="">Role</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-users" aria-hidden="true"></i></div>
									<select name="role" class="form-control" id="role_dropdown">
										<?php if ($role_sess == '2') { ?>
											<option value="3" <?php if ($rol == "3") echo 'selected'; ?>>Kasir</option>
										<?php } else { ?>
											<option value="" <?php if ($rol == "0") echo 'selected'; ?>>-- Pilih Role --</option>
											<option value="2" <?php if ($rol == "2") echo 'selected'; ?>>Backofficer</option>
											<option value="3" <?php if ($rol == "3") echo 'selected'; ?>>Kasir</option>
										<?php } ?>
									</select>
								</div>
							</div> -->
							<div class="form-group">
								<label for="">Role</label>

								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-users" aria-hidden="true"></i></div>
									<select name="role" class="form-control" id="role_dropdown">
										<?php if ($role_sess == '2') { ?>
											<option value="3" <?php if ($rol == "3") echo 'selected'; ?>>Kasir</option>
										<?php } else { ?>
											<option value="" <?php if ($rol == "0") echo 'selected'; ?>>-- Pilih Role --</option>

											<option value="2" <?php if ($rol == "2") echo 'selected'; ?>>Backofficer</option>

											<option value="3" <?php if ($rol == "3") echo 'selected'; ?>>Kasir</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">No Telp</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="icon fa fa-phone"></i></div>
									<input type="text" id="telp" name="telp" value="<?php echo $this->session->userdata('telp_kar'); ?>" placeholder="No. Telp" class="form-control custom-error" required>
									<!-- <div id="error-phone"></div> -->
								</div>

							</div>
						</div>
						<div class="col-md-6">
							<!-- <div class="form-group" id="email">
								<label for="">Email Karyawan</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></div>
									<input type="text" name="email_karyawan" value="<?php echo $this->session->userdata('email_kar'); ?>" placeholder="Email Karyawan" class="form-control" required>
								</div>
								<div id="error-email"></div>
							</div> -->
							<div class="form-group">
								<label for="">Password</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
									<input id="password" type="password" id="password" name="password" class="form-control" placeholder="Password" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Password * Ulangi</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
									<input type="password" id="type_pass" name="retype" placeholder="Confirm Password" class="form-control">
								</div>
							</div>
							<input type="text" style="display:none;" name="kode_karyawan" value="<?php echo $kode; ?>" required>
							<?php $id_business = $this->session->userdata('id_business'); ?>
							<?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
							<div class="form-group">
								<label for="">Bisnis</label>
								<?php foreach ($bus as $row) : ?>
									<input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
									<input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<hr />
					<a href="<?php echo base_url(); ?>backoffice/user" type="button" class="btn btn-default"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
					<button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?php require_once('validation.php') ?>
<script type="text/javascript">
	// $(document).ready(function() {
	// 	getSelected()

	// 	$('#role_dropdown').change(function() {
	// 		getSelected()
	// 	});
	// })

	// function getSelected() {
	// 	if ($('#role_dropdown').find(":selected").val() == 3) {
	// 		$('#email').hide();
	// 		$('#email input[name=email_karyawan]').attr("disabled", "disabled");
	// 	} else {
	// 		$('#email').show();
	// 		$('#email input[name=email_karyawan]').removeAttr("disabled");
	// 	}

	}
</script>

<!-- <script type="text/javascript">
    function validateEmail()
    {
        var emailText = document.getElementById('email').value;
        var errorm = document.getElementById('error-email');
        var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
        if (pattern.test(emailText))
        {
            return true;
        } else
        {
            errorm.style.color = "#ff6666";
            errorm.innerHTML = "Mohon masukan alamat email yg benar"
            return false;
        }
    }

    window.onload = function ()
    {
        document.getElementById('validationForm').onsubmit = validateEmail;
    }
</script>

<script type="text/javascript">
    function checkPass()
    {
        var pass1 = document.getElementById('password');
        var pass_new = document.getElementById('type_pass');
        var butt = document.getElementById('bsub');
        var message = document.getElementById('error-nwl');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";

        if (pass1.value == pass_new.value)
        {
            message.style.color = goodColor;
            message.innerHTML = "Password sudah cocok"
            butt.disabled = false;
        } else
        {
            message.style.color = badColor;
            message.innerHTML = " Password tidak cocok"
            butt.disabled = true;
            return;
        }
    }

    function checkPhone()
    {
        var phone = document.getElementById('telp');
        var butt = document.getElementById('bsub');
        var message = document.getElementById('error-phone');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";

        if (phone.value.length >= 10)
        {
            message.style.color = goodColor;
            message.innerHTML = "No telephone sudah memenuhi syarat"
            butt.disabled = false;
        } else
        {
            message.style.color = badColor;
            message.innerHTML = "No telephone minimal 10 digit"
            butt.disabled = true;
            return;
        }
    }
</script> -->