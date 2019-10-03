<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Tambah Outlet</h4>
		</div>
		<div class="panel-body">
			<form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/outlet/insert_outlet" autocomplete="off">
				<div class="form">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Nama Outlet</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
									<input type="text" name="nama_outlet" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label for="">Provinsi</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
									<select name="provinsi" id="provinsi" class="form-control">
										<option value="">-- Pilih Provinsi --</option>
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
										<option value="">-- Pilih Kabupaten --</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">Kecamatan/Kota</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
									<select name="kecamatan" id="kecamatan" class="form-control">
										<option value="">-- Pilih Kota --</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="">No Telp</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white">+62</span>
									<input type="text" name="telp" id="no-telp" class="form-control" required>
								</div>
								<!-- <div id="error-phone"></div> -->
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<label for="">Alamat</label>
								<textarea name="alamat" cols="30" rows="5" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label for="">Kode Pos</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-telegram" aria-hidden="true"></i></span>
									<input type="text" name="zip" class="form-control">
								</div>
							</div>
							<?php $id_business = $this->session->userdata('id_business'); ?>
							<?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
							<div class="form-group">
								<label for="">Bisnis</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
									<?php foreach ($bus as $rw) : ?>
										<input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
										<input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="">Pajak</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-tags" aria-hidden="true"></i></span>
									<select name="tax" class="form-control" required>
										<option value="">-- Pilih Metode Pajak --</option>
										<option value="0">Tidak Kena Pajak</option>
										<!-- <option value="1">Pajak Per Item</option> -->
										<option value="2">Pajak Per Transaksi</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<hr />
					<a href="<?php echo base_url(); ?>backoffice/outlet" type="button" class="btn btn-default"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
					<button type="submit" id="bsub" class="btn btn-primary"> <i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require_once('validation_form.php') ?>

<!-- <script type="text/javascript">
    function checkPhone()
    {
        var phone = document.getElementById('telp');
        var butt = document.getElementById('bsub');
        var message = document.getElementById('error-phone');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
    
        if(phone.value.length >= 10)
        {
            message.style.color = goodColor;
            message.innerHTML = "No telephone sudah memenuhi syarat"
            butt.disabled = false;
        }
        else
        {
            message.style.color = badColor;
            message.innerHTML = "No telephone minimal 10 digit"
            butt.disabled = true; 
            return;
        }
    }  
</script> -->

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