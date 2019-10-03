<div class="login-form">
	<?php
	$idbt = $this->session->userdata('typ_business');
	$btype = $this->db->query("SELECT * FROM businesstype_setup WHERE idtb='$idbt'")->row_array(); ?>
	<form method="POST" id="validationForm" class="form form-login" action="<?php echo base_url(); ?>home/step1">
		<h2>Step 1/7 : Tipe Bisnis & Stok Bisnis</h2>
		<div class="form-group">
			<label for="">Apakah Tipe Bisnis Anda ?</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
				<select id="type_bus" name="business_type" onchange="selectType()" class="form-control" required>
					<?php if ($idbt == NULL) {; ?>
						<option value="0">-- Pilih Tipe Bisnis --</option>
					<?php } else {; ?>
						<option value="<?php echo $btype['idtb']; ?>"><?php echo $btype['namatype_business']; ?></option>
					<?php }; ?>
					<?php foreach ($comtype as $rw) : ?>
						<option value="<?php echo $rw->idtb; ?>"><?php echo $rw->namatype_business; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="">Apakah Bisnis Anda Akan Menggunakan Stok ?</label>
			<?php $stok = $this->session->userdata('stok'); ?>
			<select id="stok" name="stok" class="form-control" required>

				<!-- Ternary Code -->
				<option value="" <?= $stok == NULL ? 'selected' : '' ?>>-- Pilih Metode Stok --</option>
				<option value="2" <?= $stok == 2 ? 'selected' : '' ?>>Ya</option>
				<option value="1" <?= $stok == 1 ? 'selected' : '' ?>>Tidak</option>
				<!-- <?php if ($stok == NULL) {; ?>
	        		<option value="0" selected>-- Pilih Metode Stok --</option>
	        		<option value="2">Ya</option>
	        		<option value="1">Tidak</option>
	        	<?php } elseif ($stok == 1) {; ?>
	        		<option value="0">-- Pilih Metode Stok --</option>
	        		<option value="2">Ya</option>
	        		<option value="1" selected>Tidak</option>
	        	<?php } else {; ?>
	        		<option value="0">-- Pilih Metode Stok --</option>
	        		<option value="2" selected>Ya</option>
	        		<option value="1">Tidak</option>
	        	<?php }; ?> -->
			</select>
			<?php if ($this->session->userdata('unik_idbisnis') == NULL) {; ?>
				<input type="text" style="display:none;" name="id_new" value="<?php echo $idbusiness; ?>" readonly>
			<?php } else {; ?>
				<input type="text" style="display:none;" name="id_new" value="<?php echo $this->session->userdata('unik_idbisnis'); ?>" readonly>
			<?php }; ?>
		</div>
		<br />
		<?php $tb = $this->session->userdata('typ_business'); ?>
		<div class="form-group">
			<button class="btn btn-primary" <?php if ($tb == NULL) {; ?> style="display: none;" <?php }; ?> id="bsub" type="submit">Next Nama Bisnis <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
		</div>
	</form>
</div>

<script type="text/javascript">
	function selectType() {
		var e = document.getElementById("type_bus");
		var variant = e.options[e.selectedIndex].value;
		var sub = document.getElementById('bsub');

		if (variant != "0") {
			sub.style.display = "block";
		} else {
			sub.style.display = "none";
		}
	}

	// function validStok() {
	// 	if ($('#stok').val() == 0) {
	// 		$('#error-stok').text('Pemilihan Stok Harus Diisi').css('color', '#ff6666');
	// 		return false;
	// 	}
	// };

	// window.onload = function()
	// {
	//     document.getElementById('validationForm').onsubmit = validStok;
	// }
	$(function() {
		$('#validationForm').validate({
			rules: {
				stok: {
					required: true
				}
			},
			messages: {
				stok: {
					required: "Silahkan pilih penggunaan stok"
				}
			},
			errorElement: "em",
			errorPlacement: function(error, element) {
				// Add the `help-block` class to the error element
				error.addClass("help-block");
				error.css('color', '#ff6666');

				if (element.prop("type") === "checkbox") {
					error.insertAfter(element.parent("label"));
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

	});
</script>