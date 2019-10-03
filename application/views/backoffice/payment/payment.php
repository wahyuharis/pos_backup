<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <?php echo $jum_tot; ?></a>
		<a href="<?php echo base_url(); ?>backoffice/payment_setup/export" class="btn btn-success btn-sm">Export </a>
		<a href="<?php echo base_url(); ?>backoffice/payment_setup/tambah_payment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Payment</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Pada halaman payment setup anda dapat mengatur rekening mana yang akan digunakan untuk transaksi, anda dapat mengatur masing-masing outlet dengan rekening yang berbeda.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<!-- <div class="panel-heading" style="overflow: visible;">
                    <div class="clearfix"></div>
                </div> -->
				<div class="panel-body">
					<div class="table-responsive">
						<table id="example4" class="table table-bordered table-condensed table-strip">
							<thead class="bg">
								<tr>
									<th width="10">No</th>
									<th>Nama</th>
									<th>Outlet</th>
									<th>No Rekening</th>
									<th>Nama Holder</th>
									<th>Status</th>
									<th width="30" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($payment as $row) : ?>
									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $row->nama_pay; ?></td>
										<td>
											<?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'"); ?>
											<?php foreach ($query->result_array() as $rw) echo $rw['name_outlet']; ?>
										</td>
										<td><?php echo $row->norek_pay; ?></td>
										<td><?php echo $row->holdername_pay; ?></td>
										<td>
											<?php if ($row->is_active == 1) { ?>
												<a href="<?php echo base_url('backoffice/payment_setup/isactive/' . $row->idpay . '/' . $row->is_active); ?>" class="btn btn-primary btn-xs">ACTIVE</a>
											<?php } else { ?>
												<a href="<?php echo base_url('backoffice/payment_setup/isactive/' . $row->idpay . '/' . $row->is_active); ?>" class="btn btn-warning btn-xs">INACTIVE</a>
											<?php } ?>
										</td>
										<td class="text-nowrap">
											<?php //if ($row->is_active == 0) : 
												?>
											<!-- <a href="<?php //echo base_url('backoffice/payment_setup/isactive/' . $row->idpay . '/' . $row->is_active); 
																	?>" class="btn btn-success btn-xs">Aktif</a> -->
											<?php //else : 
												?>
											<!-- <a href="<?php //echo base_url('backoffice/payment_setup/isactive/' . $row->idpay . '/' . $row->is_active); 
																	?>" class="btn btn-warning btn-xs">Non-Aktif</a> -->
											<?php //endif 
												?>
											<?php $new = $this->encrypt->encode($row->idpay); ?>
											<a href="<?php echo base_url(); ?>backoffice/payment_setup/edit_payment/<?php echo $new; ?>" class="btn btn-default btn-xs">Edit</a>
											<a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idpay; ?>">Hapus</a>
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

<?php foreach ($payment as $row) : ?>
	<div class="modal fade" id="modal-delete<?php echo $row->idpay; ?>">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form method="POST" action="<?php echo base_url(); ?>backoffice/payment_setup/delete">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Delete Data</h4>
					</div>
					<div class="modal-body text-center">
						<p>
							Apakah anda yakin ingin menghapus data ini?
						</p>
						<input type="text" name="id_pay" value="<?php echo $row->idpay; ?>" style="display:none;" readonly>
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
