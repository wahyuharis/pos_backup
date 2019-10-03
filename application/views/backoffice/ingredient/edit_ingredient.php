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
			<h4>Edit Ingredient</h4>
		</div>
	</div>

	<div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;" >
		<strong>Alert !</strong>
		<p id="alert-error-html"></p>
	</div>

	<div class="form">
		<form id="form-ingredient" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/ingredient/update_ingredient" autocomplete="off">
			<?php foreach ($ingredient as $ing) { ?>
			
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body same_height" >
							<div class="form-group">
								<label for="">Nama Ingredient</label>

								<input type="text" name="nama_ingredient" class="form-control" value="<?= $ing->nama_ingredient ?>" required>
								<input type="hidden" name="idingredient" value="<?= $ing->idingredient ?>">
							</div>
							<div class="form-group">
								<label for="">Kategori</label>
								<select name="kategori" id="" class="form-control">
									<option <?= $ing->idkatingredient == 0 ? 'selected':'' ?> value="">Pilih Kategori</option>
									<?php foreach ($comkat as $rw): ?>
										<option <?= $rw->idkatingredient == $ing->idkatingredient ? 'selected':'' ?> value="<?php echo $rw->idkatingredient; ?>"><?php echo $rw->nama_kategori; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
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
								<label>Foto Ingredient</label>
								<div class="">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<!-- <?php
										$foto_ingredient = "";
										if (isset($ingredient[0])) {
										  $foto_ingredient = $ingredient[0]->foto_ingredient;
										}
										?> -->
										<div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
											<img src="<?php echo base_url(); ?>picture/ingredient/150/<?= $foto_ingredient ?>" alt="" />
										</div>
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px; line-height: 20px;"></div>
										<div>
										  <span class="btn btn-file btn-primary"><span class="fileupload-new">Pilih Gambar</span><span class="fileupload-exists">Change</span><input type="file" id="foto_ingredient" name="foto_ingredient"></span>
										  <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <?php $gg=$this->db->query("SELECT idoutlet FROM rel_ingredient WHERE idingredient='$ing->idingredient'")->result();?>
                <?php
                $idout = array();
                if (count($gg) > 0) {
	                foreach($gg as $uu):
	                    $idout[] = $uu->idoutlet;
	                endforeach;
                }else{
                	$idout=[];
                } 
                ?> -->
				<!-- <div class="col-md-3">
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
										<?php foreach ($comout as $rw): ?>
											<tr>
												<td><input type="checkbox" name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>"<?=(in_array($rw->idoutlet,$idout) ? 'checked="checked"' : '')?>></td>
												<td><?php echo $rw->name_outlet; ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<em id="error-checkbox"></em>
								<i>Centang Outlet Anda Untuk Memasukan Produk Ke Outlet Tersebut</i>
							</div>
						</div>
					</div>
				</div> -->

				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Unit</label>
								<select name="unit" id="" class="form-control">
									<option value="">Pilih Unit</option>
									<?php foreach ($units as $u): ?>
										<option <?= $u->idunit == $ing->idunit ? 'selected':'' ?> value="<?php echo $u->idunit; ?>"><?php echo $u->nama_unit; ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="row">
								<?php foreach ($stok as $s) { ?>
									<div class="col-md-6">
										<div class="form-group">
											<label for="">Stok Awal</label>
											<input type="text" name="stok" class="form-control" value="<?= $s->awal ?>">
										</div>
									</div>
								<?php } ?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Harga</label>
										<input type="text" name="harga" class="form-control number-header" value="<?=$ing->harga ?>">
									</div>
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
								<a href="<?php echo base_url(); ?>backoffice/ingredient" type="button" class="btn btn-default">Kembali</a>
								<button type="submit" id="btn-sub" class="btn btn-primary">Simpan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</form>
	</div>
</div>


<?php require_once('validate_form.php') ?>

<script type="text/javascript">
	for (let field of $('.number-header').toArray()) {
		new Cleave(field, {
		    numeral: true,
		    numeralThousandsGroupStyle: 'thousand',
		});
	}
</script>
