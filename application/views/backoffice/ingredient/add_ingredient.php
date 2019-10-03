<style>
	.same_height{
		min-height: 385px;
	}
	.fixed-alert{
		position: fixed;
		z-index: 9999;
		width: 300px;
		bottom: 10px;
		right: 10px;
	}
</style>
<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4>Tambah Ingredient</h4>
		</div>
	</div>

	<div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;" >
		<strong>Alert !</strong>
		<p id="alert-error-html"></p>
	</div>

	<div class="form">
		<form id="form-ingredient" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/inredient/insert_ingredient">
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height" >
							<div class="form-group">
								<label for="">Nama Ingredient</label>
								<!-- <?php
								$nama_produk = "";
								$selected_category = 0;
								if (!isset($produk_id)) {
									$produk_id = "";
								}
								if (isset($produk[0])) {
									$nama_produk = $produk[0]->nama_produk;
									$selected_category = $produk[0]->idkategori;
								}
								?> -->
								<input type="text" name="nama_ingredient" class="form-control" required>
								<input type="hidden" name="produk_id">
							</div>
							<div class="form-group">
								<label for="">Kategori</label>
								<select name="kategori" id="" class="form-control">
									<option value="0">Pilih Kategori</option>
									<?php foreach ($comkat as $rw): ?>
										<?php
										$selected = "";
										if ($selected_category == $rw->idkatingredient) {
											$selected = 'selected="true"';
										}
										?>
										<option <?= $selected ?> value="<?php echo $rw->idkatingredient; ?>"><?php echo $rw->nama_kategori; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<!-- <?php
							$hide_sku_produck = "";
							if (isset($variant_list)) {
								if (count($variant_list) > 0) {
									$hide_sku_produck = ' hidden';
								}
							}
							?> -->
							<!-- <div class="form-group <?= $hide_sku_produck ?>">
								<label for="sku" >SKU</label>
								<?= form_input('sku', $sku, ' id="sku" class="form-control" ') ?>
								<input type="checkbox" id="toggle_sku" value="0" /> <label style="font-weight: normal;" for="toggle_sku"><i>Auto Generate</i></label>
							</div> -->
							<?php $id_business = $this->session->userdata('id_business'); ?>
							<?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
							<div class="form-group">
								<label for="">Business</label>
								<?php foreach ($bus as $row): ?>
									<input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
									<input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
								<?php endforeach; ?>
							</div>
							<div class="form-group">
								<label>Foto Produk</label>
								<div class="">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<?php
										$foto_produk = "";
										if (isset($produk[0])) {
											$foto_produk = $produk[0]->foto_produk;
										}
										?>
										<div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="<?php echo base_url(); ?>picture/produk/150/<?= $foto_produk ?>" alt="" /></div>
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px; line-height: 20px;"></div>
										<div>
											<span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="foto_produk" name="foto_produk"></span>
											<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-body same_height" >
							<div class="form-group">
								<label for="">Outlet</label><br>
								<table id="tb-outlet-list" class="table table-bordered table-condensed table-strip">
									<thead>
										<tr>
											<th>Check</th>
											<th>Nama Outlet</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$checked_outlet = array();
										if (isset($outlet_checked)) {
											$checked_outlet = $outlet_checked;
										}
										?>
										<?php foreach ($comout as $rw): ?>
											<?php
											$checked = "";
											if (in_array($rw->idoutlet, $checked_outlet)) {
												$checked = ' checked="true" ';
											}
											?>
											<tr>
												<td><input type="checkbox" <?= $checked ?> name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>"></td>
												<td><?php echo $rw->name_outlet; ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<i>Centang Outlet Anda Untuk Memasukan Produk Ke Outlet Tersebut</i>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-5">
					<div class="panel panel-default">
						<!--                        <div class="panel-heading">
													Variant
												</div>-->
						<div class="panel-body same_height">
							<!--- VAriant --->

							<div class="form-group">
								<label for="">Pakai Variant</label>
								<?php
								$yes = "";
								$ask_disabled = "";
								$no = "";
								if (isset($variant_list)) {
									if (count($variant_list) > 0) {
										$yes = ' selected="true" ';
										$no = ' disabled ';
										$ask_disabled = ' disabled ';
									} else {
										$no = ' selected="true"  ';
										$yes = ' disabled ';
										$ask_disabled = ' disabled ';
									}
								}
								?>
								<select name="variant" id="variant"  onchange="pakaiVariant()" class="form-control">
									<option <?= $ask_disabled ?> value="0">Pakai Variant ?</option>
									<option <?= $yes ?> value="Ya">Ya</option>
									<option <?= $no ?> value="Tidak">Tidak</option>
								</select>
							</div>
							<?php
							$hgstock = ' display: none; ';
							if (isset($variant_list)) {
								if (count($variant_list) > 0) {
									
								} else {
									$hgstock = '';
								}
							}
							?>
							<div id="hgstock" style="<?= $hgstock ?>">
								<div class="form-group">
									<label for="">Harga Produk</label>
									<input type="text" name="harga_produk" class="form-control number-header" value="<?= $harga_produk ?>">
								</div>

								<?php
								$disabled = "";
								$hidden = '';
								if (!empty($produk_id)) {
									$disabled = ' disabled="true" ';
									$hidden = ' hidden ';
								}

								// if (!$pakai_stok) {
								// 	$hidden = ' hidden ';
								// }
								?>
								<div class="form-group  <?= $hidden ?>">
									<label for="">Stock Awal Produk</label>
									<input type="text" name="stock_awal" class="form-control number-header <?= $hidden ?>">
									<i>Jika anda tidak ingin menggunakan stok, isi stok awal dengan 1000</i>
								</div>
							</div>

							<!--- VAriant --->
							<?php
							$display_none = 'display: none';
							if (isset($variant_list)) {
								if (count($variant_list) > 0) {
									$display_none = "";
								}
							}
							?>
							<div id="variant-list" style="<?= $display_none ?>">
								<table class="table table-bordered table-condensed table-strip" style="margin-bottom: 0px;background-color: #eee;">
									<tbody>
										<tr>
											<td>#</td>  
											<!-- <td>
												<b>SKU(opsional)</b><br>
												<input data-bind="value:sku_variant_add" class="form-control input-sm" placeholder="SKU" type="text">
											</td> -->
											<td>
												<b>Variant</b><br>
												<input data-bind="value:nama_variant_add" class="form-control input-sm" placeholder="Nama Variant" type="text">
											</td>
											<td>
												<b>Harga</b><br>
												<input data-bind="value:harga_add,event: {'keyup':add_variant_enter}" class="form-control input-sm number-header" placeholder="Harga" type="text"> 
											</td>
											<td>
												<b>Stok Awal</b><br>
												<?php
												$stok_disabled = '';
												if (isset($produk_id) && strlen($produk_id) > 0) {
//                                                    $stok_disabled=' hidden ';
												}
												$stok_hidden = "";
												if ($pakai_stok) {
													$stok_hidden = ' ';
												} else {
													$stok_hidden = ' hidden ';
												}
												?>
												<input data-bind="value:stok_add,event: {'keyup':add_variant_enter}"  class="form-control input-sm number-header <?= $stok_hidden ?>" placeholder="Stok"  type="text"> 
											</td>
											<td>#</td>  
										</tr>
										<tr>
											<td colspan="4"><i >*SKU : Jika produk memiliki sku(barcode) isikan diatas. Jika tidak SKU akan digenerate otomatis</i></td>
											<td colspan="">
												<a class="btn btn-primary btn-xs" data-bind="click:add_variant_click" style="float: right" > <i class="fa fa-plus-circle"></i> Tambah</a>
											</td>
										</tr>
									</tbody>
								</table>
								<p></p>
								<p></p>
								<table id="table-variant-list" class="table table-bordered table-condensed table-strip">
									<thead>
										<tr>
											<th>No</th>
											<th>SKU</th>
											<th>Variant</th>
											<th>Harga</th>
											<th>Stok Awal</th>
											<th>#</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: variant_list">
										<?php
										$stok_hidden = "";
										if ($pakai_stok) {
											$stok_hidden = ' ';
										} else {
											$stok_hidden = ' hidden ';
										}
										?>
										<tr>
											<td> 
												<span data-bind="text: number_row" ></span>
												<input data-bind="value:id_variant" type="hidden" >
											</td>
											<td><input data-bind="value: sku" type="text" class="form-control input-sm"></td>
											<td> <input data-bind="value: nama_variant" class="form-control input-sm" type="text" /></td>
											<td>
												<input data-bind="value:harga" class="form-control input-sm number-header" type="text"> 
											</td>
											<td>
												<input data-bind="value:stok,hidden:id_variant()>0" class="form-control input-sm number-header <?= $stok_hidden ?>"  type="text"> 
											</td>
											<td><a data-bind="click: $root.remove_list" class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash"></i></a></td>
										</tr>
									</tbody>
								</table>
								<textarea style="display: none" name="variant_list_json" data-bind="value: ko.toJSON($root.variant_list)" ></textarea>
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
								<a href="<?php echo base_url(); ?>backoffice/produk" type="button" class="btn btn-default">Back</a>
								<button type="submit" id="btn-sub" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('#table-variant-list').bind("DOMSubtreeModified", function () {
		for (let field of $('.number-header').toArray()) {
			new Cleave(field, {
				numeral: true,
				numeralThousandsGroupStyle: 'thousand',
			});
		}
	});


	$(document).ready(function () {
		for (let field of $('.number-header').toArray()) {
			new Cleave(field, {
				numeral: true,
				numeralThousandsGroupStyle: 'thousand',
			});
		}


		$('select[name=variant]').change(function () {
			if ($(this).val() == 'Ya') {
				$('#variant-list').show();

				$('input[name=sku]').prop('disabled', true);
			} else {
				$('#variant-list').hide();

				$('input[name=sku]').prop('disabled', false);
			}
		});

		$('#toggle_sku').change(function () {
			if ($(this).is(':checked')) {
				$('input[name=sku]').prop('disabled', true);
			} else {
				$('input[name=sku]').prop('disabled', false);
			}
		});

		$('#alert-error').click(function () {
			$(this).hide();
		});

		$('#form-produk').on('keyup keypress', function (e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) {
				e.preventDefault();
				return false;
			}
		});


		$('#form-produk').submit(function (e) {
			e.preventDefault();
			$('#btn-sub').prop('disabled', true);

			$.ajax({
				url: "<?= base_url() ?>backoffice/produk/submit/", // Url to which the request is send
				type: "POST", // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function (data)   // A function to be called if request succeeds
				{
					if (!data.status) {
						$('#alert-error').show();
						$('#alert-error-html').html(data.message);
						setTimeout(function () {
							$('#alert-error').fadeOut('slow');
						}, 2000);
					} else {
						window.location = '<?= base_url() ?>backoffice/produk/';
					}
					$('#btn-sub').prop('disabled', false);

				},
				error: function (err) {
					alert(JSON.stringify(err));
					$('#btn-sub').prop('disabled', false);
				}
			});
		});


		$('#btn-sub').prop('disabled', false);

	});

	$('select,input').change(function () {
		validation_submit();
	});

	$('input').keyup(function () {
		validation_submit();
	});


	function pakaiVariant()
	{
		var e = document.getElementById("variant");
		var variant = e.options[e.selectedIndex].value;

		var hgstock = document.getElementById('hgstock');
		var sub = document.getElementById('btn-sub');

		if (variant == "Ya")
		{
			hgstock.style.display = "none";
		} else if (variant == "Tidak")
		{
			hgstock.style.display = "inline";
		} else
		{
			hgstock.style.display = "none";
		}
	}

	function validation_submit() {
		var nama_produk = $('input[name=nama_produk]').val();
		var kategori = $('select[name=kategori]').val();
		var variant = $('select[name=variant]').val();


		form_array = $('#form-produk').serializeArray();
		console.log(form_array);

		var i;
		var cb_buff = [];
		for (i = 0; i < form_array.length; i++) {
			if (form_array[i]['name'] == 'outlet[]') {
				cb_buff.push(form_array[i]['value']);
			}
		}
		console.log(cb_buff);

		var disabled = true;
		if ((nama_produk.length > 1) && (kategori != "0") && (variant != "0") && (cb_buff.length > 0)) {
			disabled = false;
		}

		$('#btn-sub').prop('disabled', false);
	}
</script>
<?php //require_once 'produk_add_script.php'; ?>
