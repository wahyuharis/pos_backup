<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <?php echo $jum_meja; ?></a>
		<a href="<?php echo base_url(); ?>backoffice/table_meja/export" class="btn btn-success btn-sm">Export </a>
		<a id="tambah_kategori" href="<?php echo base_url(); ?>backoffice/table_meja/tambah_meja" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Meja</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman group digunakan untuk mengelola group meja anda, grup akan dipilih saat anda memasukan atau mengedit meja.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<!--                <div class="panel-heading" style="d;">
                    <div class="clearfix"></div>
                </div>-->
				<div class="panel-body">
					<div class="table-responsive">
						<table id="example1" class="table table-bordered table-condensed table-strip">
							<thead class="bg">
								<tr>
									<th width="10">No</th>
									<th>Outlet</th>
									<th>Group</th>
									<th>No. Meja</th>
									<th width="35">Status</th>
									<th width="30" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($meja as $row) : ?>
									<tr>
										<td><?php echo $no; ?>.</td>
										<td><?php echo $row->name_outlet; ?></td>
										<td><?php echo $row->nama_group; ?></td>
										<td><?php echo $row->no_meja; ?></td>
										<td width="35" align="center">
											<?php
												if ($row->status == 1) { ?>
												<span class="label label-danger">Terpakai</span>
											<?php } else { ?>
												<span class="label label-success">Kosong</span>
											<?php } ?>
										</td>
										<td class="text-nowrap">
											<a href="<?php echo base_url(); ?>backoffice/table_meja/edit_meja/<?php echo $row->idtable; ?>" class="btn btn-default btn-xs">Edit</a>
											<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idtable; ?>">Hapus</a>
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

<?php foreach ($meja as $row) : ?>
	<div class="modal fade" id="modal-delete<?php echo $row->idtable; ?>">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url(); ?>backoffice/table_meja/delete">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Hapus Data</h4>
					</div>
					<div class="modal-body text-center">
						<p>
							Apakah anda yakin ingin menghapus data ini?
						</p>
						<input type="text" name="idtable" value="<?php echo $row->idtable; ?>" style="display:none;" readonly>
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
