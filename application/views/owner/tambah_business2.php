<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Step 2 : Tambahkan Outlet</h4>
        <hr/>
        <form method="POST" id="validationForm" action="<?php echo base_url(); ?>owner/business/step2">
            <div class="form">
                <?php
				$idpr = $this->session->userdata('prov_out');
				$idkb = $this->session->userdata('kab_out');
				$idkc = $this->session->userdata('kec_out');
				$provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
				$regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
				$districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array(); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Outlet</label>
                            <input type="text" name="nama_outlet" class="form-control" value="<?php echo $this->session->userdata('nama_out'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control">
                                <?php if ($idpr == NULL) {; ?>
                                    <option value="0">-- Pilih Provinsi --</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                                <?php }; ?>
                                <?php foreach ($comprov as $rw) : ?>
                                    <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten-kota" class="form-control">
                                <?php if ($idkb == NULL) {; ?>
                                    <option value="0">-- Pilih Kabupaten --</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kecamatan/Kota</label>
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <?php if ($idkc == NULL) {; ?>
                                    <option value="0">-- Pilih Kecamatan --</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">No Telp</label>
                            <input type="text" name="telp" id="telp" onkeyup="checkPhone(); return false;" class="form-control" value="<?php echo $this->session->userdata('telp_out'); ?>">
                            <div id="error-phone"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" cols="30" rows="5" class="form-control"><?php echo $this->session->userdata('ala_out'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Pos</label>
                            <input type="text" name="zip" class="form-control" value="<?php echo $this->session->userdata('zip_out'); ?>">
                        </div>
                    </div>
                    <?php $pjk = $this->session->userdata('pjk_out'); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Pajak</label>
                            <select name="tax" class="form-control">
                                <option value="0" <?php if ($pjk == "0") echo 'selected'; ?>>-- Pilih Metode Pajak --</option>
                                <option value="0" <?php if ($pjk == "0") echo 'selected'; ?>>Tidak Kena Pajak</option>
                                <option value="1" <?php if ($pjk == "1") echo 'selected'; ?>>Pajak Per Item</option>
                                <option value="2" <?php if ($pjk == "2") echo 'selected'; ?>>Pajak Per Transaksi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr/>
                <a href="<?php echo base_url(); ?>owner/business/tambah_business" class="btn btn-primary">< Back</a>
                <button type="submit" id="bsub" class="btn btn-primary">Next Tambah Karyawan ></button>
            </div>
        </form>
    </div>
</div>
-->

<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4>Step 2 : Tambahkan Outlet</h4>
		</div>
	</div>
	<?php
	$idpr = $this->session->userdata('prov_out');
	$idkb = $this->session->userdata('kab_out');
	$idkc = $this->session->userdata('kec_out');
	$provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
	$regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
	$districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array(); ?>
	<div class="form">
		<form id="form-business" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>owner/business/step2">
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Nama Outlet</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></div>
									<input type="text" name="nama_outlet" placeholder="Nama Outlet" class="form-control" value="<?php echo $this->session->userdata('nama_out'); ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Provinsi</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
									<select name="provinsi" id="provinsi" class="form-control" required>
										<?php if ($idpr == NULL) {; ?>
											<option value="">-- Pilih Provinsi --</option>
										<?php } else {; ?>
											<option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
										<?php }; ?>
										<?php foreach ($comprov as $rw) : ?>
											<option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Kabupaten</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
									<select name="kabupaten" id="kabupaten-kota" class="form-control" required <?php if ($idkb == NULL) {; ?> <option value="">-- Pilih Kabupaten --</option>
									<?php } else {; ?>
										<option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
									<?php }; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Kecamatan/Kota</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
									<select name="kecamatan" id="kecamatan" class="form-control" required>
										<?php if ($idkc == NULL) {; ?>
											<option value="">-- Pilih Kecamatan --</option>
										<?php } else {; ?>
											<option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
										<?php }; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">No Telepon</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white">+62</div>
									<input type="text" name="telp" id="telp" class="form-control" value="<?php echo $this->session->userdata('telp_out'); ?>">
								</div>
								<!-- <div id="error-phone"></div> -->
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Alamat</label>
								<textarea name="alamat" cols="30" rows="5" class="form-control"><?php echo $this->session->userdata('ala_out'); ?></textarea>
							</div>
							<div class="form-group">
								<label for="">Kode Pos</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-telegram" aria-hidden="true"></i></div>
									<input type="text" name="zip" maxlength="5" class="form-control" value="<?php echo $this->session->userdata('zip_out'); ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="">Pajak</label>
								<div class="input-group">
									<div class="input-group-addon" style="background-color: white"><i class="fa fa-tag" aria-hidden="true"></i></div>
									<select name="tax" class="form-control">
										<option value="" <?php if ($pjk == "0") echo 'selected'; ?>>-- Pilih Metode Pajak --</option>
										<option value="0" <?php if ($pjk == "0") echo 'selected'; ?>>Tidak Kena Pajak</option>
										<option value="2" <?php if ($pjk == "2") echo 'selected'; ?>>Pajak Per Transaksi</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="form-group">
								<a href="<?php echo base_url(); ?>owner/business/tambah_business" class="btn btn-primary">
									<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a> <button type="submit" id="bsub" class="btn btn-primary">Next Tambah Karyawan <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
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

<script type="text/javascript">
	$(function() {
		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('backoffice/outlet/ambil_data'); ?>",
			cache: false,
		});
		$("#provinsi").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kabupaten',
						id: value
					},
					success: function(respond) {
						$("#kabupaten-kota").html(respond);
					}
				})
			}
		});
		$("#kabupaten-kota").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kecamatan',
						id: value
					},
					success: function(respond) {
						$("#kecamatan").html(respond);
					}
				})
			}
		})
	})

	$(function() {
		$('#form-business').validate({
			rules: {
				nama_outlet: {
					required: true
				},
				alamat: {
					required: true
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
				telp: {
					required: true,
					minlength: 9
				},

				tax: {
					required: true
				}
			},
			messages: {
				nama_outlet: {
					required: "Silahkan masukkan nama outlet"
				},
				alamat: {
					required: "Silahkan masukkan alamat"
				},
				provinsi: {
					required: "Silahkan pilih provinsi"
				},
				kabupaten: {
					required: "Silahkan pilih kabupaten"
				},
				kecamatan: {
					required: "Silahkan pilih provinsi"
				},
				telp: {
					required: "Silahkan masukkan nomor telephone",
					minlength: "Format telephone salah",
				},
				tax: {
					required: "Silahkan pilih metode stok"
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
		$("input[name='zip']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	})
</script>