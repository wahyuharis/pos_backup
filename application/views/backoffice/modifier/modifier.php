<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <?php echo $jum_mod; ?></a>
		<!-- <a href="<?php echo base_url(); ?>backoffice/modifier/export" class="btn btn-success btn-sm">Export </a> -->
		<a href="<?php echo base_url(); ?>backoffice/modifier/tambah_modifier" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Modifier</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman kategori digunakan untuk mengelola modifier anda, modifier berupa item tambahan sebagai pelengkap produk anda seperti topping, atau tambahan lainnya.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="modifier-list" class="table table-bordered table-condensed table-strip">
							<thead class="bg">
								<tr>
									<th width="10">No</th>
									<th width="60%">Nama Modifier</th>
									<th width="15%">Item Modifier</th>
									<th width="15%">Produk</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($modifier as $row) : ?>
									<tr>
										<td><?php echo $no; ?>.</td>
										<td width="60%"><?php echo $row->nama_modifier; ?></td>
										<?php $ta = array('idmodifier' => $row->idmodifier);

											// $sub_mod = $this->data_model->getsomething('sub_modifier', $ta);
											// $sub = '';
											// foreach ($sub_mod as $sm) {
											// 	$sub .= "<span class='label label-primary'>" . $sm->nama_sub . " - " . nominal($sm->harga_sub) . "</span>&nbsp;";
											// }
											$sub = $this->db->get_where('sub_modifier', $ta)->num_rows();


											?>
										<td width="15%"><?php echo $sub; ?> Item</td>
										<?php $da = array('idmodifier' => $row->idmodifier); ?>
										<?php $tot = $this->data_model->count_where('rel_modifier', $da); ?>
										<td width="15%"><?= $tot > 0 ? $tot . ' Produk' : '-' ?></td>
										<td class="text-nowrap">
											<button data-id="<?= $row->idmodifier ?>" class="btn btn-info btn-xs btn-detail">Detail</button>
											<a href="<?php echo base_url(); ?>backoffice/modifier/edit_modifier/<?php echo urlencode(base64_encode($row->idmodifier)); ?>" class="btn btn-default btn-xs">Edit</a>
											<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idmodifier; ?>">Hapus</a>
										</td>
									</tr>
									<?php $no++; ?>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<?php foreach ($modifier as $row) : ?>
	<div class="modal fade" id="modal-delete<?php echo $row->idmodifier; ?>">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url(); ?>backoffice/modifier/delete">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Delete Data</h4>
					</div>
					<div class="modal-body text-center">
						<p>
							Apakah anda yakin ingin menghapus data ini?
						</p>
						<input type="text" name="id_modifier" value="<?php echo $row->idmodifier; ?>" style="display:none;" readonly>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<!-- modal -->

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Item Modifier</h4>
			</div>
			<div class="modal-body">
				<table class="table table-stripped" id="tbl-detail" style="width: 100%">
					<thead>
						<tr>
							<td>Nama</td>
							<td>Harga</td>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>



<script>
	$(document).ready(function() {
		$('#modifier-list').DataTable();

		$('.btn-detail').click(function() {
			var id = $(this).data("id")
			console.log(id)
			$('#tbl-detail').DataTable({
				ajax: {
					url: "<?= base_url('backoffice/modifier/detail_submodifier/') ?>" + id,
					dataSrc: 'data'
				},
				columns: [{
						data: "nama"
					},
					{
						data: "harga"
					}
				],
				"ordering": true,
				"bDestroy": true,
			})


			$('#modal-detail').modal();
		})

	});
</script>
