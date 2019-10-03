<div class="wrapper">
	<div class="pull-right">
		<button class="btn btn-default btn-sm">Total : <?= $count ?></button>
		<!-- <a id="export_excel" href="<?= base_url() ?>backoffice/stok/export_excel2" class="btn btn-success btn-sm">Export </a> -->
		<a href="<?php echo base_url(); ?>backoffice/resep/tambah_resep" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Resep</a>
		<!-- <a href="<?php echo base_url(); ?>backoffice/stok/create_adjustment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Adjustment</a>
		<a href="<?php echo base_url(); ?>backoffice/stok/create_transfer" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Transfer Order</a> -->
	</div>
	<div class="clearfix"></div>
	<br/>
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="example1" class="table table-bordered table-condensed table-strip">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Produk</th>
									<th>Nama Variant</th>
									<th>Igredient</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								<?php $num=1; foreach ($recipes as $rec) { ?>
								<tr>
									<td><?= $num++ ?>.</td>
									<td><?= $rec->nama_produk ?></td>
									<td><?= $rec->nama_variant != null ? $rec->nama_produk:'-' ?></td>
									<td>
										<?php 
										$this->db->select('idingredient');
										$this->db->from('recipes');
										$this->db->where('idproduk', $rec->idproduk);
										echo $this->db->get()->num_rows().' ingredients';
										 ?>
									</td>
									<!-- <td>Detail</td> -->
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <script>
	jQuery(document).ready(function($) {
		
	});
	$('#table-stok').DataTable();
</script> -->
