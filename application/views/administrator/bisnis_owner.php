<div class="wrapper">

	<div class="pull-left">
		<a href="<?php echo base_url('administrator'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali </a>
	</div>
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Jumlah Bisnis : <?= $business_count ?></a>
		<!-- <a href="#" class="btn btn-success btn-sm">Export </a> -->
	</div>
	<div class="clearfix"></div><br>

	<div class="panel panel-default">
		<!-- <div class="panel-heading">
				<div class="pull-right">
					<a class="btn btn-default btn-sm">Jumlah Bisnis : <?= $business_count ?></a>
					<a href="<?php echo base_url(); ?>backoffice/outlet/export" class="btn btn-success btn-sm">Export </a>
				</div>

			</div> -->
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped" id="example1">
					<thead>
						<tr>
							<th>#</th>
							<th>Gambar</th>
							<th>Nama Bisnis</th>
							<!-- <th>Telepon</th>
								<th>Terakhir Login</th>
								<th>Status</th> -->
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach ($business as $c) { ?>
							<tr>
								<td><?= $no++ ?>.</td>
								<td><img style="width:100px;height:100px" class="img-rounded" src="<?= base_url('picture/150/' . $c->img_business) ?>" alt="picture"></td>
								<td><?= $c->nama_business ?></td>

								<td>
									Aksi
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<!-- <div class="modal fade" id="modal-delete">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url(); ?>administrator/delete">
				<input type="hidden" name="idowner">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Data</h4>
				</div>
				<div class="modal-body text-center">
					<p>
						Apakah anda yakin ingin menghapus data owner?
						Semua data mengenai owner akan dihapus dan tidak bisa kembali.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(function() {
		$('.delete').click(function(e) {
			var id = $(this).data('id');
			$('input[name="idowner"]').val(id);
			$('#modal-delete').modal()
		});
	});
</script> -->
