<style>
	.fa-times {
		color: red;
		font-size: 25px;
		font-weight: 0.5
	}

	.scroll-content {
		overflow: auto;
		max-height: 450px;
	}
</style>

<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-body">
			<h4>Edit Modifier</h4>
		</div>
	</div>

	<div class="form">
		<form id="form-produk" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/modifier/update_modifier" autocomplete="off">
			<?php foreach ($modifier as $row) : ?>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body same_height">
								<div class="form-group">
									<label for="">Nama Modifier</label>
									<div class="input-group">
										<span class="input-group-addon" style="background-color: white"><i class="fa fa-fire" aria-hidden="true"></i></span>
										<input type="text" name="nama_modifier" class="form-control" value="<?php echo $row->nama_modifier; ?>" required>
										<input type="hidden" name="idmodifier" value="<?php echo $row->idmodifier; ?>">
									</div>
								</div><br>
								Pilihan Modifier
								<div class="scroll-content">
									<input type="hidden" id="is_sub_modifier" name="is_sub_modifier" required>
									<table class="table table-borderless" id="sub-modifier-list">
										<tbody>
											<?php if (!empty($submodifier)) {
													foreach ($submodifier as $sm) { ?>
													<tr>

														<td>
															<div class="input-group">
																<span class="input-group-addon" style="background-color: white"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></span>
																<input placeholder="Nama" type="text" class="sub-modif form-control" name="sub_name" value="<?= $sm->nama_sub ?>">
															</div>
														</td>
														<td>
															<div class="input-group">
																<span class="input-group-addon" style="background-color: white">Rp.</span>
																<input placeholder='0,00' type='text' class='sub-modif number-header form-control' name='sub_price' value="<?= $sm->harga_sub ?>">
															</div>
														</td>
														<td><i class='fa fa-times delete-sub-list'></i></td>
														<!-- <td><input placeholder='Nama' type='text' class='sub-modif  form-control' name='sub_name' value="<?= $sm->nama_sub ?>"></td>
														<td><input placeholder='Rp. 0' type='text' class='sub-modif  number-header form-control' name='sub_price' value="<?= $sm->harga_sub ?>"></td>
														<td><i class='fa fa-times delete-sub-list'></i></td> -->

													</tr>
											<?php }
												} ?>
										</tbody>
									</table>
								</div><br>
								<button id="btn-add-sub" class="btn btn-block btn-primary"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
								<em id="error-sub"></em><br>
								<i>*Pilihan wajib ditambah/diisi</i>

								<!-- <div class="form-group">
								<label for="">Harga Modifier</label>
								<input type="text" name="harga_modifier" class="form-control number-header" required>
							</div> -->

								<?php //$id_business = $this->session->userdata('id_business'); 
									?>
								<?php //$bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); 
									?>
								<!-- <div class="form-group">
								<label for="">Business</label>
								<?php foreach ($bus as $row) : ?>
									<input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
									<input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
								<?php endforeach; ?>
							</div> -->
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body same_height ">
								<?php $gg = $this->db->query("SELECT idproduk FROM rel_modifier WHERE idmodifier='$row->idmodifier'")->result(); ?>
								<?php
									$idgrat = array();
									foreach ($gg as $uu) :
										$idgrat[] = $uu->idproduk;
									endforeach; ?>
								<i><i class="fa fa-check-square-o" aria-hidden="true"></i> Centang produk anda Untuk memasukan produk ke modifier ini</i><br><br>
								<em id="error-prod"></em>
								<div class="form-group scroll-content">
									<!-- <label for="">Produk</label><br> -->
									<table id="tableproduk" class="table table-condensed table-strip">
										<thead>
											<tr>
												<th width="20%"><input type="checkbox" name="cb-all"> Check <i class="fa fa-check-circle-o" aria-hidden="true"></th>
												<th> <i class="fa fa-dropbox" aria-hidden="true"></i> Nama Produk</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($compro as $rw) : ?>
												<tr>

													<td width="20%"><input type="checkbox" name="produk" class="list-checkbox" value="<?php echo $rw->idproduk; ?>" <?= (in_array($rw->idproduk, $idgrat) ? 'checked="checked"' : '') ?>></td>
													<td><?php echo $rw->nama_produk; ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>


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
									<input style="display:none;" type="text" name="id_produks" class="form-control" readonly>
									<input type="hidden" name="sub_modifier" class="form-control" readonly>
									<a href="<?php echo base_url(); ?>backoffice/modifier" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
									<button type="submit" id="bsub" class="btn btn-primary"> <i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		checkCountSubModifier1();
		create_url_delete();

	});

	$('input[name=cb-all]').change(function() {
		var check_all = false;
		if ($(this).is(':checked')) {
			check_all = true;
		}

		$('#tableproduk > tbody > tr > td > input[name=produk]').each(function() {
			$(this).prop('checked', check_all);
		});
		create_url_delete();
	});

	$(document).on("change", ".list-checkbox", function() {
		create_url_delete();
	});

	function create_url_delete() {
		var cb_checked = [];
		$('#tableproduk > tbody > tr > td > input[name=produk]').each(function() {
			if ($(this).is(':checked')) {
				cb_checked.push($(this).val());
			}
		});
		var id_produk_str = (JSON.stringify(cb_checked));

		if (cb_checked.length > 0) {
			// $('#bsub').removeClass('disabled');
			$('input[name=id_produks]').val(id_produk_str);
		} else {
			// $('#bsub').addClass('disabled', true);
			$('input[name=id_produks]').val('');
		}
	}


	$('#btn-add-sub').click(function(e) {
		e.preventDefault()
		var tr = `
			<tr>
				<td>
					<div class="input-group">
						<span class="input-group-addon" style="background-color: white"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i></span>
						<input placeholder="Nama" type="text" class="sub-modif form-control" name="sub_name">
					</div>
				</td>
				<td>
					<div class="input-group">
						<span class="input-group-addon" style="background-color: white">Rp.</span>
						<input placeholder='0,00' type='text' class='sub-modif number-header form-control' name='sub_price'>
					</div>
				</td>
				<td><i class='fa fa-times delete-sub-list'></i></td>				
			</tr>
		`;
		$("#sub-modifier-list tbody").append(tr);
		checkCountSubModifier1()
	})
	$("#sub-modifier-list tbody").on('click', '.delete-sub-list', function(e) {
		e.preventDefault()
		$(this).parent().parent('tr').remove();
		checkCountSubModifier1()
	});

	function checkCountSubModifier() {
		if ($('#sub-modifier-list tbody tr').length > 0) {
			$('input[name=is_sub_modifier]').val('ada')
		} else {
			$('input[name=is_sub_modifier]').val('')
		}
	}

	function checkCountSubModifier1() {
		var arr_sub_modifier = [];
		// $('#sub-modifier-list > tbody > tr > td > input[name=sub_name]').each(function() {
		// 	if ($(this).val() != '') {
		// 		arr_sub_modifier.push($(this).val());
		// 	}
		// });
		$('#sub-modifier-list > tbody > tr').each(function() {
			var td_name = $(this).find('td > .input-group > input[name=sub_name]').val()
			var td_price = $(this).find('td > .input-group > input[name=sub_price]').val()
			if (td_name != '') {
				arr_sub_modifier.push({
					'sub_name': td_name,
					'sub_price': td_price,
				});
			}
		});
		var sub_modifier_str = (JSON.stringify(arr_sub_modifier));
		if (arr_sub_modifier.length > 0) {
			// console.log('ada')
			$('input[name=is_sub_modifier]').val('ada')
			$('input[name=sub_modifier]').val(sub_modifier_str);
			$('#error-sub').text('');
		} else {
			// console.log('kosong')
			$('input[name=is_sub_modifier]').val('')
			$('input[name=sub_modifier]').val('');
		}
		// console.log(sub_modifier_str)


		$(".sub-modif").keyup(function() {
			setTimeout(function() {
				checkCountSubModifier1()
			}, 1000);
		});
		for (let field of $('.number-header').toArray()) {
			new Cleave(field, {
				numeral: true,
				numeralThousandsGroupStyle: 'thousand',
			});
		}

	}
</script>

<?php require_once('validate_form.php'); ?>