<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Tambah Customer</h4>
		</div>
		<div class="panel-body">
			<form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/customer/insert_customer">
				<div class="form">
					<div class="row">
						<?php
						// $provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$row->province_id'")->row_array();
						// $regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$row->regencies_id'")->row_array();
						// $districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$row->district_id'")->row_array(); 
						?>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Nama Customer</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-user" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="nama_customer" placeholder="Nama Customer" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Email Customer</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email_customer" placeholder="Email Customer" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Telp Customer</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white">+62</span>
									<input id="no-telp" type="text" maxlength="13" class="form-control" name="telp_customer" placeholder="Telp Customer" required>
								</div>
							</div>
							<!-- <div class="form-group">
								<label for="">Telp Customer 2</label>
								<input type="text" class="form-control" name="telp_customer2">
							</div> -->
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Provinsi</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
									<select name="provinsi" id="provinsi" class="form-control" required>
										<option value="">--pilih provinsi</option>
										<?php foreach ($comprov as $rw) : ?>
											<option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Kabupaten</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
									<select name="kabupaten" id="kabupaten-kota" class="form-control" required>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Kecamatan/Kota</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
									<select name="kecamatan" id="kecamatan" class="form-control" required>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Outlet</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
									<select name="outlet" id="outlet" class="form-control" required>
										<option value="">--pilih outlet</option>
										<?php foreach ($outlet as $rw) : ?>
											<option value="<?php echo $rw->idoutlet; ?>"><?php echo $rw->name_outlet; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<hr />
					<a href="<?php echo base_url(); ?>backoffice/customer" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
					<button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(function() {
		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('backoffice/bisnis/ambil_data'); ?>",
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
						console.log(respond)
						$("#kabupaten-kota").html(respond);
					}
				})
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
</script>
<?php require_once('validation.php') ?>