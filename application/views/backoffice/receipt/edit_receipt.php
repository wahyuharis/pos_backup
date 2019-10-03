<div class="wrapper">
	<div class="receipt-view">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-5">
						<form method="POST" id="select-outlet">
							<div class="form-group">
								<label style="color: grey">OUTLET</label>
								<div class="input-group">
									<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
									<select class="form-control" name="outlet_id" id="outlet-id-select">
										<?php foreach ($outlet as $o) { ?>
											<option <?= $o->idoutlet == $this->session->userdata('outlet-id-selected') ? 'selected' : '' ?> value="<?= $o->idoutlet ?>"><?= $o->name_outlet ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="receipt-no-data" style="display: none;">
					<div class="panel-body">
						<form method="POST" id="form-generate" action="<?= base_url('backoffice/receipt/generate') ?>">
							<input type="hidden" name="idoutlet" id="outlet-id-generate">
							<button type="submit" class="btn btn-primary"><i class="fa fa-gear"></i> Generate Receipt</button>
						</form>
					</div>
				</div>
			</div>
			<div id="receipt-exist">
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-sm-12">
								<div class="panel-heading">
									<h4>RECEIPT INFO</h4>
								</div>
							</div>
							<div class="panel-body">
								<form method="POST" enctype="multipart/form-data" action="<?php echo base_url('backoffice/receipt/update_receipt'); ?>" id=submitForm>
									<div class="col-md-12">
										<div class="receipt-info">
											<input type="hidden" name="receipt_id_form">
											<input type="hidden" name="outlet_id_form">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
													<input id="form-outlet" type="text" class="form-control" name="name_outlet" disabled='disabled'>
												</div>
											</div>
											<div class="form-group">
												<!-- <label for="">Alamat</label> -->
												<div class="input-group">
													<span class="input-group-addon" style="background-color: white"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
													<input type="text" name="alamat_outlet" class="form-control" placeholder="Alamat" required>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
															<select class="form-control" name="province_id" id="province_id" required>
																<?php foreach ($provinsi as $row) { ?>
																	<option value="<?= $row->id; ?>"><?= $row->name ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
															<select class="form-control" name="regencies_id" id="regencies_id" required>
																<!-- <option value="" selected disabled="disabled">Pilih Kota</option> -->
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-7">
													<div class="form-group">
														<!-- <label for="">Phone</label> -->
														<div class="input-group">
															<div class="input-group-addon" style="background-color: white">+62</div>
															<input id="no-telp" type="text" maxlength="13" class="form-control" name="telp_outlet" placeholder="812-0908" required>
														</div>
														<em id="error-no-telp"></em>
													</div>
												</div>
												<div class="col-md-5">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-telegram" aria-hidden="true"></i></span>
															<input type="text" class="form-control" name="zip_outlet" placeholder="Zip" required>
														</div>
														<!-- <label for="">Kodepos</label> -->
													</div>
												</div>
											</div><br>
											<h4>SOCIAL MEDIA</h4>
											<hr>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-link" aria-hidden="true"></i></span>
															<input type="text" class="form-control" name="website_business" value="<?php echo $business->website_business; ?>" placeholder="Website Info">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-facebook" aria-hidden="true"></i></span>
															<input type="text" class="form-control" name="facebook_business" value="<?php echo $business->facebook_business; ?>" placeholder="Facebook Info">
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-instagram" aria-hidden="true"></i></span>
															<input type="text" class="form-control" name="instagram_business" value="<?php echo $business->instagram_business; ?>" placeholder="Instagram Info">
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon" style="background-color: white"><i class="fa fa-twitter" aria-hidden="true"></i></span>
															<input type="text" class="form-control" name="twitter_business" value="<?php echo $business->twitter_business; ?>" placeholder="Twitter Info">
														</div>
													</div>
												</div>
											</div>
											&nbsp;
											<h4>NOTE</h4>
											<hr>
											<div class="form-group">
												<!-- <label for="">Note</label> -->
												<textarea type="text" class="form-control" id="notes-form" name="notes" rows="5" placeholder="Note"></textarea>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<hr>
										<button type="submit" class="btn btn-primary"> <i class="icon fa fa-save"></i> Simpan</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-sm-12">
								<div class="panel-heading">
									<h4>RECEIPT PREVIEW</h4>
								</div>
							</div>
							<div class="panel-body">
								<div class="col-md-12">
									<div class="receipt-content">
										<div class="invoice-wrapper">
											<div class="line-items">
												<div class="items">
													<div class="row item">
														<div class="intro text-center">
															<img class="img-circle" src="<?php echo base_url(); ?>picture/150/<?php echo $business->img_business; ?>" alt="Avatar">
															<strong>
																<h4>
																	<?php echo $business->nama_business; ?>

																</h4>
															</strong>
															<span id="alamat"></span><br>
															<span id="kota"></span>,
															<span id="provinsi"></span>,
															<span id="zip"></span>
															<br>
															<i class="icon fa fa-phone">&nbsp;+62&nbsp;<span id="phone"></span></i>
														</div>
													</div>
												</div>
												<div class="items">
													<div class="row item">
														<div class="col-xs-6 text-left">
															<i class="icon fa fa-user"></i> Kasir :
														</div>
														<div class="col-xs-6 text-right">
															<strong>Robert</strong>
														</div>
													</div>
												</div>
											</div>
											<div class="line-items">
												<div class="items">
													<div class="row item">
														<div class="col-xs-6 text-left">
															Kode Transaksi :
														</div>
														<div class="col-xs-6 text-right">
															<strong>TR-03D16B8DD0919</strong>
														</div>
														<div class="col-xs-6 text-left">
															Metode Pembayaran :
														</div>
														<div class="col-xs-6 text-right">
															<strong>TUNAI</strong>
														</div>
														<div class="col-xs-6 text-left">
															Tanggal Transaksi :
														</div>
														<div class="col-xs-6 text-right">
															<strong>03-09-2019</strong>
														</div>
														<div class="col-xs-6 text-left">
															Jam Transaksi :
														</div>
														<div class="col-xs-6 text-right">
															<strong>08:58:41</strong>
														</div>
														<div class="col-xs-6 text-left">
															Nomor Meja :
														</div>
														<div class="col-xs-6 text-right">
															<strong>Lantai 1 - A-1</strong>
														</div>
													</div>
												</div>
											</div>
											&nbsp;
											&nbsp;
											<div class="line-items">
												<div class="headers clearfix">
													<div class="row">
														<div class="col-xs-6">Item</div>
														<div class="col-xs-2">Jumlah</div>
														<div class="col-xs-4 text-right">Harga</div>
													</div>
												</div>
												<div class="items">
													<div class="row item">
														<div class="col-xs-6 desc">
															Bubur Kacang Ijo
														</div>
														<div class="col-xs-2 qty">
															1
														</div>
														<div class="col-xs-4 amount text-right">
															6000
														</div>
													</div>
													<div class="row item">
														<div class="col-xs-6 desc">
															Bawang Goreng
														</div>
														<div class="col-xs-2 qty">
															1
														</div>
														<div class="col-xs-4 amount text-right">
															1000
														</div>
													</div>
													<div class="row item">
														<div class="col-xs-6 desc">
															Bonus (Bubur Ketan Hitam)
														</div>
														<div class="col-xs-2 qty">
															1
														</div>
														<div class="col-xs-4 amount text-right">
															8000
														</div>
													</div>
												</div>
												<div class="line-items">
													<div class="items">
														<div class="row item">
															<div class="total">
																<div class="col-xs-6 text-left">
																	Subtotal :
																</div>
																<div class="col-xs-6 text-right">
																	<div class="field">
																		<span>Rp. 7000</span>
																	</div>
																</div>
																<div class="col-xs-6 text-left">
																	Pajak <strong>(21%)</strong> :
																</div>
																<div class="col-xs-6 text-right">
																	<div class="field">
																		<span>Rp. 1470</span>
																	</div>
																</div>
																<div class="col-xs-6 text-left">
																	Total :
																</div>
																<div class="col-xs-6 text-right">
																	<div class="field">
																		<span>
																			<strong>
																				Rp. 8470
																			</strong>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="items">
														<div class="row item">
															<div class="total">
																<div class="col-xs-6 text-left">
																	Cash :
																</div>
																<div class="col-xs-6 text-right">
																	<span>
																		<strong>
																			Rp. 50000
																		</strong>
																	</span>
																</div>
																<div class="col-xs-6 text-left">
																	Change :
																</div>
																<div class="col-xs-6 text-right">
																	<div class="field">
																		<span>
																			<strong>
																				Rp. 41530
																			</strong>
																		</span>
																	</div>
																</div>

															</div>
														</div>
													</div>

													<div class="footer">
														<div class="line-items">
															<div class="headers clearfix">
																<div class="row">
																	<div class="col-xs-1">Links</div>
																</div>
															</div>
															<div class="items">
																<div class="row item">
																	<div class="col-xs-1 text-left">
																		<i class="icon fa fa-link"></i>
																	</div>
																	<div class="col-xs-11 text-left">
																		<span id="website"></span>
																	</div>
																</div>
																<div class="row item">
																	<div class="col-xs-1 text-left">
																		<i class="icon fa fa-instagram"></i>
																	</div>
																	<div class="col-xs-11 text-left">
																		<span id="instagram"></span>
																	</div>
																</div>
																<div class="row item">
																	<div class="col-xs-1 text-left">
																		<i class="icon fa fa-facebook"></i>
																	</div>
																	<div class="col-xs-11 text-left">
																		<span id="facebook"></span>
																	</div>
																</div>
																<div class="row item">
																	<div class="col-xs-1 text-left">
																		<i class="icon fa fa-twitter"></i>
																	</div>
																	<div class="col-xs-11 text-left">
																		<span id="twitter"></span>
																	</div>
																</div>
															</div>
														</div>
														&nbsp;
														<h5>
															<span id="notes"></span>
														</h5>
														<h6>POS by aiopos.id</h6>
														<!-- <strong>
														<h6>aiopos.id</h6>
													</strong> -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="success-submit">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

			</div>
			<div class="modal-body text-center">
				<i class="fa fa-check-circle-o fa-5x text-warning"></i>
				<br /><br />
				<p>
					<span id="text-modal"></span>
				</p>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$('#submitForm').validate({
		rules: {
			alamat_outlet: {
				required: true
			},
			province_id: {
				required: true
			},
			regencies_id: {
				required: true
			},
			zip_outlet: {
				required: true
			},
			telp_outlet: {
				required: true,
				minlength: 10
			},


		},
		messages: {
			alamat_outlet: {
				required: "Silahkan isi alamat"
			},
			zip_outlet: {
				required: "Silahkan isi zip"
			},
			telp_outlet: {
				required: "Silahkan isi nomor telephone",
				minlength: "Format telephone salah"
			},
			province_id: {
				required: "Silahkan pilih provinsi"
			},
			regencies_id: {
				required: "Silahkan pilih kota"
			},
		},
		errorElement: "em",
		errorPlacement: function(error, element) {
			// Add the `help-block` class to the error element
			error.addClass("help-block");
			error.css('color', '#ff6666');

			// if (element.prop("id") === "no-telp") {
			// 	error.appendTo('#error-no-telp')
			// } else {
			// 	error.insertAfter(element);
			// }

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

		submitHandler: function(form) {
			// console.log($(form).serialize())

			var idreceipt = $('input[name=receipt_id_form]').val()
			var idoutlet = $('input[name=outlet_id_form]').val()
			var idregencies = $('#regencies_id').val()
			var idprovince = $('#province_id').val()
			var zip = $('input[name=zip_outlet]').val()
			var telp = $('input[name=telp_outlet]').val()
			var alamat = $('input[name=alamat_outlet]').val()
			var website = $('input[name=website_business]').val()
			var facebook = $('input[name=facebook_business]').val()
			var instagram = $('input[name=instagram_business]').val()
			var twitter = $('input[name=twitter_business]').val()
			var note = $('#notes-form').val()

			var data = {
				'idreceipt': idreceipt,
				'idoutlet': idoutlet,
				'idregencies': idregencies,
				'idprovince': idprovince,
				'zip': zip,
				'telp': telp,
				'alamat': alamat,
				'note': note,
				'facebook': facebook,
				'website': website,
				'instagram': instagram,
				'twitter': twitter,
			}

			// console.log(data)

			$.ajax({
				url: form.action,
				type: form.method,
				data: data,
				success: function(res) {
					console.log(facebook)
					$('#text-modal').text(res.message)
					$('#success-submit').modal('show');
					setTimeout(function() {
						$('#success-submit').modal('hide');
					}, 2000);

				}
			});

		}

	})

	$(document).ready(function() {
		var outlet_id = $('#outlet-id-select').val();
		$('#outlet-id-generate').val(outlet_id);
		get_data(outlet_id)


		$('#outlet-id-select').change(function(e) {
			get_data($(this).val())

			$('#outlet-id-generate').val(this.value);
		});

		$("input[name='telp_outlet']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});
		$("input[name='zip_outlet']").keypress(function(e) {
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				return false;
			}
		});

		onChangeValue()

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

	function init_preview() {
		$('#alamat').text($('input[name=alamat_outlet]').val());
		$('#notes').text($('#notes-form').val());
		$('#phone').text($('input[name=telp_outlet]').val());
		$('#zip').text($('input[name=zip_outlet]').val());
		$('#provinsi').text($('#province_id option:selected').text())
		$('#website').text($('input[name=website_business]').val());
		$('#facebook').text($('input[name=facebook_business]').val());
		$('#instagram').text($('input[name=instagram_business]').val());
		$('#twitter').text($('input[name=twitter_business]').val());
		// $('#kota').text( $('#regencies_id option:selected').text() )
	}

	function onChangeValue() {
		$('input[name=alamat_outlet]').on('keyup', function(e) {
			$('#alamat').text($(this).val())
		});

		$('input[name=telp_outlet]').on('keyup', function(e) {
			$('#phone').text($(this).val())
		});
		$('input[name=zip_outlet]').on('keyup', function(e) {
			$('#zip').text($(this).val())
		});

		$('#notes-form').on('keyup', function(e) {
			$('#notes').text($(this).val())
		});

		$('#province_id').change(function(e) {
			$('#provinsi').text($('#province_id option:selected').text())
			changeProvinceID($('#province_id').val())
		});

		$('#regencies_id').change(function(e) {
			$('#kota').text($('#regencies_id option:selected').text())
		});

		$('input[name=website_business]').on('keyup', function(e) {
			$('#website').text($(this).val())
		});

		$('input[name=facebook_business]').on('keyup', function(e) {
			$('#facebook').text($(this).val())
		});

		$('input[name=instagram_business]').on('keyup', function(e) {
			$('#instagram').text($(this).val())
		});

		$('input[name=twitter_business]').on('keyup', function(e) {
			$('#twitter').text($(this).val())
		});
	}

	function get_data(outlet_id) {
		$.getJSON('<?= base_url('backoffice/receipt/receiptJSON/') ?>' + outlet_id, function(res) {

			// console.log(res)
			if (res.data.length > 0) {
				reset_data()
				$('#receipt-exist').css('display', 'block')
				$('#receipt-no-data').css('display', 'none')
				// console.log('ada')
				var data = res.data[0]

				$('input[name=receipt_id_form]').val(data.id_receipt)
				$('input[name=outlet_id_form]').val(data.idoutlet)
				$('input[name=name_outlet]').val(data.name_outlet)
				$('input[name=alamat_outlet]').val(data.alamat_outlet)

				changeProvinceID(data.province_id, data.regencies_id)

				$('#province_id').val(data.province_id)
				$('input[name=zip_outlet]').val(data.zip_outlet)
				$('input[name=telp_outlet]').val(data.telp_outlet)
				$('#notes-form').val(data.notes)

				init_preview()

			} else {
				reset_data()
				// console.log('kosong')
				$('#receipt-exist').css('display', 'none')
				$('#receipt-no-data').css('display', 'block')
			}
		});
	}

	function reset_data() {
		$('input[name=receipt_id_form]').val("")
		$('input[name=outlet_id_form]').val("")
		$('input[name=name_outlet]').val("")
		$('input[name=alamat_outlet]').val("")
		// $('input[name=regencies_id]').val("")
		// $('input[name=province_id]').val("")
		$('input[name=zip_outlet]').val("")
		$('input[name=telp_outlet]').val("")
		//social media
		// $('input[name=website_business]').val("")
		// $('input[name=facebook_business]').val("")
		// $('input[name=instagram_business]').val("")
		// $('input[name=twitter_business]').val("")
		//notes
		$('#notes-form').val("")
	}

	function changeProvinceID(province_id = null, regencies_id = null) {

		// if (regencies_id != null) {
		$.getJSON('<?= base_url('backoffice/receipt/regencies/') ?>' + province_id, function(res) {
			$('#regencies_id').empty();
			// var listitems = '<option value="" selected disabled="disabled">Pilih Kota</option>';
			var listitems = '';
			$.each(res, function(i, el) {
				if (regencies_id == el.id) {
					listitems += '<option value=' + el.id + ' selected >' + el.name + '</option>';
				} else {
					listitems += '<option value=' + el.id + '>' + el.name + '</option>';
				}

			})
			$('#regencies_id').append(listitems);
			$('#kota').text($('#regencies_id option:selected').text())
		})

		// }else{
		// 	console.log('halo')
		// }
	}
</script>