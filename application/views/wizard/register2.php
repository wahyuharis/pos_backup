<div class="login-form">
	<form method="POST" id="validationForm" class="form form-login" action="<?php echo base_url(); ?>home/step2" autocomplete="off">
		<h2>Step 2/7 : Nama Bisnis</h2>
		<div class="form-group">
			<label for="">Apa Nama Bisnis Anda ?</label>
			<div class="input-group">
				<div class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></div>
				<input type="text" id="nama_business" name="nama_business" value="<?php echo $this->session->userdata('nama_business'); ?>" class="form-control" placeholder="Nama Business" required>
			</div>
		</div>
		<br />
		<div class="form-group">
			<a href="<?php echo base_url(); ?>home/register" class="btn btn-default">
				<i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a> <button class="btn btn-primary" id="bsub" type="submit"> Next Detail Bisnis <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
		</div>
		</i>
</div>

<script>
	$(function() {
		$('#validationForm').validate({
			rules: {
				nama_business: {
					required: true
				}
			},
			messages: {
				nama_business: {
					required: "Silahkan isi nama bisnis Anda"
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

	});
</script>