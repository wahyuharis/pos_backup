<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit Karyawan</h4>
		</div>
		<div class="panel-body">
			<div class="form">
				<form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/user/update_karyawan">
					<div class="row">
						<?php foreach ($karyawan as $row) : ?>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Nama Karyawan</label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-address-card" aria-hidden="true"></i></div>
										<input type="text" name="nama_karyawan" value="<?php echo $row->nama_user; ?>" class="form-control" placeholder="Nama Karyawan" required>
										<input type="text" name="id_karyawan" style="display : none;" value="<?php echo $row->iduser; ?>" readonly>
										<?php $ids_karyawan = $row->iduser; ?>
									</div>
								</div>

								<div class="form-group">
									<label for="">Username</label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
										<input type="text" name="username" value="<?php echo $row->username; ?>" class="form-control" placeholder="Username" required>
									</div>
								</div>
								<?php $out = $row->idoutlet; ?>
								<div class="form-group">
									<label for="">Outlet</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
										<select name="outlet" id="" class="form-control">
											<option value="">-- Pilih Outlet --</option>
											<?php foreach ($comout as $rw) : ?>
												<option value="<?php echo $rw->idoutlet; ?>" <?php if ($rw->idoutlet == $out) echo 'selected="selected"'; ?>>
													<?php echo $rw->name_outlet; ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<?php $rl = $row->role_user;
									$role_sess = $this->session->userdata('role_user'); ?>
								<div class="form-group">
									<label for="">Role</label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-users" aria-hidden="true"></i></div>
										<select name="role" class="form-control" id="role_dropdown">
											<?php if ($role_sess == '2') { ?>
												<option value="3" <?php if ($rl == "3") echo 'selected'; ?>>Kasir</option>
											<?php } else { ?>
												<option value="" disabled<?php if ($rl == "0") echo 'selected'; ?>>-- Pilih Role --</option>
												<option value="2" <?php if ($rl == "2") echo 'selected'; ?>>Backofficer</option>
												<option value="3" <?php if ($rl == "3") echo 'selected'; ?>>Kasir</option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="">No Telp</label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-phone" aria-hidden="true"></i></div>
										<input type="text" id="telp" value="<?php echo $row->telp_user; ?>" name="telp" class="form-control" placeholder="No Telp" required>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<!-- <div class="form-group" id="email">
									<label for="">Email Karyawan</label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></div>
										<input type="text" id="email" value="<?php //echo $row->email_user; 
																					?>" name="email_karyawan" placeholder="Email Karyawan" class="form-control" readonly>
									</div>

								</div> -->
								<div class="form-group">
									<label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
										<input type="password" id="password" name="password" placeholder="Password" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="">Ulangi Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
									<div class="input-group">
										<div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
										<input type="password" id="type_pass" name="retype" placeholder="Confirm Password" class="form-control">
									</div>
								</div>
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
						<?php endforeach; ?>
					</div>

					<hr />
					<a href="<?php echo base_url(); ?>backoffice/user" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
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
	// 	} else {
	// 		$('#email').show();
	// 	}

	//}
</script>

<script type="text/javascript">
	//  function validateEmail()
	//  {
	//      var emailText = document.getElementById('email').value;
	//      var errorm = document.getElementById('error-email');
	//      var pattern = /^[a-zA-Z0-9\-_]+(\.[a-zA-Z0-9\-_]+)*@[a-z0-9]+(\-[a-z0-9]+)*(\.[a-z0-9]+(\-[a-z0-9]+)*)*\.[a-z]{2,4}$/;
	//      if (pattern.test(emailText))
	//      {
	//          return true;
	//      } else
	//      {
	//          errorm.style.color = "#ff6666";
	//          errorm.innerHTML = "Mohon masukan alamat email yg benar"
	//          return false;
	//      }
	//  }

	//  window.onload = function ()
	//  {
	//      document.getElementById('validationForm').onsubmit = validateEmail;
	//  }
</script>

<script type="text/javascript">
	//  function checkPass()
	//  {
	//      var pass1 = document.getElementById('password');
	//      var pass_new = document.getElementById('type_pass');
	//      var butt = document.getElementById('bsub');
	//      var message = document.getElementById('error-nwl');
	//      var goodColor = "#66cc66";
	//      var badColor = "#ff6666";

	//      if (pass1.value == pass_new.value)
	//      {
	//          message.style.color = goodColor;
	//          message.innerHTML = "Password sudah cocok"
	//          butt.disabled = false;
	//      } else
	//      {
	//          message.style.color = badColor;
	//          message.innerHTML = " Password tidak cocok"
	//          butt.disabled = true;
	//          return;
	//      }
	//  }

	//  function checkPhone()
	//  {
	//      var phone = document.getElementById('telp');
	//      var butt = document.getElementById('bsub');
	//      var message = document.getElementById('error-phone');
	//      var goodColor = "#66cc66";
	//      var badColor = "#ff6666";

	//      if (phone.value.length >= 10)
	//      {
	//          message.style.color = goodColor;
	//          message.innerHTML = "No telephone sudah memenuhi syarat"
	//          butt.disabled = false;
	//      } else
	//      {
	//          message.style.color = badColor;
	//          message.innerHTML = "No telephone minimal 10 digit"
	//          butt.disabled = true;
	//          return;
	//      }
	//  }
</script>