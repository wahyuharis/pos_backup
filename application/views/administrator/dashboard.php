<style>
	#link-bisnis {
		text-decoration: none;
	}

	.wrappers {
		/* height: 100%; */
		padding: 10px;
	}
</style>


<div class="wrappers">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading text-center">
						<span class="font-gede">Total Owner</span>
					</div>
					<div class="panel-body text-center">
						<span class="font-gede" id="total_pendapatan"><?= $owner_count ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-success">
					<div class="panel-heading text-center">
						<span class="font-gede">Owner Aktif</span>
					</div>
					<div class="panel-body text-center">
						<span class="font-gede" id="total_pendapatan"><?= $aktif ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-danger">
					<div class="panel-heading text-center">
						<span class="font-gede">Owner Non Aktif</span>
					</div>
					<div class="panel-body text-center">
						<span class="font-gede" id="total_pendapatan"><?= $nonaktif ?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-right">
					<!-- <a class="btn btn-default btn-sm">Total : <?= $count ?></a> -->
					<a href="#" class="btn btn-success btn-sm">Export </a>
				</div>

			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped" id="example1">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Telepon</th>
								<th>Nama Bisnis</th>
								<th>Terakhir Login</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($owners as $c) { ?>
								<tr>
									<td><?= $no++ ?>.</td>
									<td><?= $c->nama_user ?></td>
									<td><?= $c->email_user ?></td>
									<td><?= $c->telp_user ?></td>
									<td>
										<?php
											$this->db->select('idbusiness, nama_business');
											$this->db->from('business');
											$this->db->where('idowner', $c->idowner);
											$business = $this->db->get()->result();


											foreach ($business as $b) {
												echo '<strong>' . $b->nama_business . '</strong>, ';
											}
											?>
									</td>
									<td><?= indonesian_date($c->last_login) ?></td>
									<td width="8%" align="center">
										<?= $c->status_user == 1 ? '<span class="label label-info">Aktif</span>' : '<span class="label label-danger">Non Aktif</span>' ?>
									</td>
									<td>
										<?= $c->status_user == 1 ? '<a href="' . base_url('administrator/block_owner/' . $c->idowner) . '" class="btn btn-warning btn-xs">Blok</a>' : '<a href="' . base_url('administrator/aktif_owner/' . $c->idowner) . '" class="btn btn-info btn-xs">Aktifkan</a>' ?>
										<a class="btn btn-default btn-xs" href="<?= base_url('administrator/edit_owner/' . $c->idowner) ?>">Edit</a>
										<button data-id="<?php echo $c->idowner ?>" class="btn btn-danger btn-xs delete">Hapus</button>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>
<div class="modal fade" id="modal-delete">
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
</script>
