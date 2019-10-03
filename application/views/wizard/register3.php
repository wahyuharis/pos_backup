<div class="login-form">
	<?php
	$idpr = $this->session->userdata('prov_business');
	$idkb = $this->session->userdata('kab_business');
	$idkc = $this->session->userdata('kec_business');
	$provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
	$regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
	$districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array(); ?>
	<form method="POST" id="validationForm" class="form form-login" action="<?php echo base_url(); ?>home/step3" autocomplete="off">
		<h2>Step 3/7 : Detail Bisnis</h2>
		<!-- <div class="form-group">
			<label for="">Deskripsi Bisnis</label>
			<textarea name="description_business" class="form-control" required><?php echo $this->session->userdata('desc_business'); ?></textarea>
		</div> -->
		<div class="form-group">
			<label for="">Provinsi</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
				<select name="provinsi" id="provinsi" onchange="selectWilayah()" class="form-control">
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
		</div>
		<div class="form-group">
			<label for="">Kabupaten</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
				<select name="kabupaten" id="kabupaten-kota" onchange="selectWilayah()" class="form-control">
					<?php if ($idkb == NULL) {; ?>
						<option value="0">-- Pilih Kabupaten --</option>
					<?php } else {; ?>
						<option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
					<?php }; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="">Kecamatan/Kota</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></div>
				<select name="kecamatan" id="kecamatan" onchange="selectWilayah()" class="form-control">
					<?php if ($idkc == NULL) {; ?>
						<option value="0">-- Pilih Kecamatan --</option>
					<?php } else {; ?>
						<option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
					<?php }; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="">Alamat</label>
			<textarea cols="30" rows="5" class="form-control" name="alamat_business" required><?php echo $this->session->userdata('ala_business'); ?></textarea>
		</div>
		<div class="form-group">
			<label for="">No Telp</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white">+62</div>
				<input id="no-telp" type="text" class="form-control phone" name="tlp_bisnis" value="<?php echo $this->session->userdata('tlp_business'); ?>" required>
			</div>
			<em id="error-no-telp"></em>
		</div>
		<!-- <div class="form-group">
			<label for="">Email</label>
			<input type="text" id="email" class="form-control" name="email_bisnis" value="<?php echo $this->session->userdata('email_business'); ?>" required>
		</div> -->
		<br />
		<?php $pro = $this->session->userdata('prov_business'); ?>
		<?php $kab = $this->session->userdata('kab_business'); ?>
		<?php $kec = $this->session->userdata('kec_business'); ?>
		<div class="form-group">
			<a href="<?php echo base_url(); ?>home/register2" class="btn btn-default">
				<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a> <button class="btn btn-primary" id="bsub" <?php if (($pro == NULL) || ($kab == NULL) || ($kec == NULL)) {; ?>style="display:none;" <?php }; ?> type="submit">Next Data Owner <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
		</div>
	</form>
</div>
<script type="text/javascript">
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
	$(function() {
		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('home/ambil_data'); ?>",
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


		$('#validationForm').validate({
			rules: {
				// description_business: {
				// 	required: true
				// },
				alamat_business: {
					required: true
				},
				tlp_bisnis: {
					required: true,
					minlength: 9
				}
				// email_bisnis: {
				// 	required: true,
				// 	email: true
				// }
			},
			messages: {
				// description_business: {
				// 	required: "Silahkan isi deskripsi bisnis Anda"
				// },
				alamat_business: {
					required: "Silahkan isi alamat bisnis Anda"
				},
				tlp_bisnis: {
					required: "Silahkan isi nomor telepon bisnis Anda",
					minlength: "Silahkan isi format nomor telepon yang benar"
				}
				// email_bisnis: {
				// 	required: "Silahkan isi email bisnis Anda",
				// 	email: "Mohon masukan alamat email yg benar"
				// }
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.prop("id") === "no-telp") {
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

		$("input[name='tlp_bisnis']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
	})
</script>

<script type="text/javascript">
	function selectWilayah() {
		var e = document.getElementById("provinsi");
		var provinsi = e.options[e.selectedIndex].value;

		var e = document.getElementById("kabupaten-kota");
		var kabupaten = e.options[e.selectedIndex].value;

		var e = document.getElementById("kecamatan");
		var kecamatan = e.options[e.selectedIndex].value;

		var sub = document.getElementById('bsub');

		if ((provinsi != "0") && (kabupaten != "0") && (kecamatan != "0")) {
			sub.style.display = "inline";
		} else {
			sub.style.display = "none";
		}
	}
</script>