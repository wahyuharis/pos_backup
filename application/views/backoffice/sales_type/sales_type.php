<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <?php echo $jum_sty; ?></a>
		<a href="<?php echo base_url(); ?>backoffice/sales_type/export" class="btn btn-success btn-sm">Export </a>
		<a href="<?php echo base_url(); ?>backoffice/sales_type/tambah_sales_type" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Sales Type</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman sales type digunakan untuk mengelola metode pembelian.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" style="overflow: visible;">
					<div class="clearfix"></div>
				</div>
				<div class="panel-body form-inline collapse advance-search">
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Bisnis</option>
					</select>
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Outlet</option>
					</select>
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Status</option>
					</select>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="example4" class="table table-bordered table-condensed table-strip">
							<thead class="bg">
								<tr>
									<th width="10">No</th>
									<th>Outlet</th>
									<th>Nama Sales Type</th>
									<!--<th>Tip</th>-->
									<th>Status</th>
									<th width="30" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($sales_type as $row) : ?>
									<tr>
										<td><?php echo $no; ?>.</td>

										<?php $whr = array('idsaltype' => $row->idsaltype); ?>
										<?php $count = $this->data_model->count_where('rel_salestype', $whr); ?>
										<!--<td><?php echo $count; ?> Tip</td>-->
										<td>
											<?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'"); ?>
											<?php
												foreach ($query->result_array() as $rw) {
													echo $rw['name_outlet'];
												}
												?>
										</td>
										<td><?php echo $row->nama_saltype; ?></td>
										<td width="10%" align="center">
											<div class="label label-primary">ACTIVE</div>
										</td>
										<td class="text-nowrap">
											<?php $new = urlencode(base64_encode(($row->idsaltype))); ?>
											<?php if ($row->lock == 0) { ?>
												<a href="<?php echo base_url(); ?>backoffice/sales_type/edit_sales_type/<?php echo $new; ?>" class="btn btn-default btn-xs">Edit</a>
												<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idsaltype; ?>">Hapus</a>
											<?php } else { ?> <span class="badge badge-default">default</span> <?php } ?>
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

<?php foreach ($sales_type as $row) : ?>
	<div class="modal fade" id="modal-delete<?php echo $row->idsaltype; ?>">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url(); ?>backoffice/sales_type/delete">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Hapus Data</h4>
					</div>
					<div class="modal-body text-center">
						<p>
							Apakah anda yakin ingin menghapus data ini?
						</p>
						<input type="text" name="id_saltype" value="<?php echo $row->idsaltype; ?>" style="display:none;" readonly>
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
