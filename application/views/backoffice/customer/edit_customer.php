<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Edit Customer</h4>
        <hr/>
        <div class="form">
            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/customer/update_customer">
                <div class="row">
                    <?php foreach ($customer as $row) : ?>
                        <?php
							$provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$row->province_id'")->row_array();
							$regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$row->regencies_id'")->row_array();
							$districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$row->district_id'")->row_array(); ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="idctm" style="display:none;" value="<?php echo $row->idctm; ?>" readonly>
                                <label for="">Nama Customer</label>
                                <input type="text" class="form-control" name="nama_customer" value="<?php echo $row->nama_pelanggan; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Email Customer</label>
                                <input type="text" class="form-control" name="email_customer" value="<?php echo $row->email_pelanggan; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Telp Customer 1</label>
                                <input type="text" class="form-control" name="telp_customer1" value="<?php echo $row->telp_pelanggan; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Telp Customer 2</label>
                                <input type="text" class="form-control" name="telp_customer2" value="<?php echo $row->telepon_pelanggan2; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Provinsi</label>
                                <select name="provinsi" id="provinsi" class="form-control">
                                    <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                                    <?php foreach ($comprov as $rw) : ?>
                                        <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kabupaten</label>
                                <select name="kabupaten" id="kabupaten-kota" class="form-control">
                                    <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Kecamatan/Kota</label>
                                <select name="kecamatan" id="kecamatan" class="form-control">
                                    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
-->

<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit Customer</h4>
		</div>
		<div class="panel-body">
			<form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/customer/update_customer">
				<div class="form">
					<?php foreach ($customer as $row) : ?>
						<div class="row">
							<?php
								$provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$row->province_id'")->row_array();
								$regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$row->regencies_id'")->row_array();
								$districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$row->district_id'")->row_array(); ?>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="idctm" style="display:none;" value="<?php echo $row->idctm; ?>" readonly>
									<label for="">Nama Customer</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-user" aria-hidden="true"></i></span>
										<input type="text" class="form-control" name="nama_customer" value="<?php echo $row->nama_pelanggan; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="">Email Customer</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
										<input type="text" class="form-control" name="email_customer" value="<?php echo $row->email_pelanggan; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="">Telp Customer 1</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white">+62</span>
										<input id="no-telp" type="text" class="form-control" name="telp_customer" value="<?php echo $row->telp_pelanggan; ?>">
									</div>
								</div>
								<!-- <div class="form-group">
									<label for="">Telp Customer 2</label>
									<input type="text" class="form-control" name="telp_customer2" value="<?php echo $row->telepon_pelanggan2; ?>">
								</div> -->
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="">Provinsi</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
										<select name="provinsi" id="provinsi" class="form-control">
											<option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
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
										<select name="kabupaten" id="kabupaten-kota" class="form-control">
											<option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="">Kecamatan/Kota</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
										<select name="kecamatan" id="kecamatan" class="form-control">
											<option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<hr />
					<a href="<?php echo base_url(); ?>backoffice/customer" type="button" class="btn btn-default"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
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