<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Detail Cashopname</h4>
        <hr/>
        <div class="form">
            <div class="row">
                <?php foreach ($cashopname as $row) : ?>
                <div class="col-md-4">
                    <?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'"); ?>
                    <?php foreach ($query->result_array() as $rw) :
									$outlet = $rw['name_outlet'];
								endforeach; ?>
                    <div class="form-group">
                        <label for="">Outlet</label>
                        <input type="text" class="form-control" value="<?php echo $outlet; ?>" disabled>
                    </div>
                    <?php $query = $this->db->query("SELECT nama_user FROM user WHERE iduser='$row->iduser'"); ?>
                    <?php foreach ($query->result_array() as $rw) :
									$nama = $rw['nama_user'];
								endforeach; ?>
                    <div class="form-group">
                        <label for="">Karyawan</label>
                        <input type="text" class="form-control" value="<?php echo $nama; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" class="form-control" value="<?php echo $row->tanggalcop; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Kas Masuk</label>
                        <input type="text" class="form-control" value="Rp. <?php echo $row->kas_masuk; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Kas Keluar</label>
                        <input type="text" class="form-control" value="Rp. <?php echo $row->kas_keluar; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Keterangan Masuk</label>
                        <textarea cols="30" rows="5" class="form-control" name="alamat_business" disabled><?php echo $row->keterangan_masuk; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan Keluar</label>
                        <textarea cols="30" rows="5" class="form-control" name="alamat_business" disabled><?php echo $row->keterangan_keluar; ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Beginning</label>
                        <input type="text" name="holder" class="form-control" value="Rp. <?php echo $row->beginning; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="">Ending</label>
                        <input type="text" name="holder" class="form-control" value="Rp. <?php echo $row->ending; ?>" disabled>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <hr/>
            <a href="<?php echo base_url(); ?>backoffice/cashopname" type="button" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
-->

<div class="wrapper">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="pull-left">
				<h4>Detail Shift</h4>
			</div>
			<div class="pull-right">
				<a href="<?php echo base_url(); ?>backoffice/cashopname" type="button" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
			</div>
		</div>
	</div>

	<div class="form">
		<form>
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Nama Kasir</label>
								<input type="text" value="<?php echo $karyawan; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Outlet</label>
								<input type="text" value="<?php echo $outlet; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Tanggal</label>
								<input type="text" value="<?php echo $tanggalcop; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Beginning</label>
								<input type="text" value="<?php echo $beginning; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Ending</label>
								<input type="text" value="<?php echo $ending; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Jam Mulai</label>
								<input type="text" value="<?php echo $jam_mulai; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Jam Akhir</label>
								<input type="text" value="<?php echo $jam_akhir; ?>" class="form-control" readonly>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<h5>Kas Masuk</h5>
							<?php if (count($kas_masuk) > 0) { ?>
								<table class="table table-strippped">
									<thead>
										<tr>
											<th>#</th>
											<th>Keterangan</th>
											<th>Nominal</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$total = 0;
											foreach ($kas_masuk as $km) { ?>
											<tr>
												<td><?= $no++ ?>.</td>
												<td><?= $km->keterangan ?></td>
												<td align="right"><?= nominal($km->nominal) ?></td>
											</tr>

										<?php $total += $km->nominal;
											} ?>
										<tr>
											<td colspan="2">Total</td>
											<td align="right"><?= nominal($total) ?></td>
										</tr>
									</tbody>
								</table>
							<?php } else {
								echo "<p class='text-center'>Tidak ada data</p>";
							} ?>

							<hr>
							<h5>Kas Keluar</h5>
							<?php if (count($kas_keluar) > 0) { ?>
								<table class="table table-strippped">
									<thead>
										<tr>
											<th>#</th>
											<th>Keterangan</th>
											<th>Nominal</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$total = 0;
											foreach ($kas_keluar as $kk) { ?>
											<tr>
												<td><?= $no++ ?>.</td>
												<td><?= $kk->keterangan ?></td>
												<td align="right"><?= nominal($kk->nominal) ?></td>
											</tr>

										<?php $total += $kk->nominal;
											} ?>
										<tr>
											<td colspan="2">Total</td>
											<td align="right"><?= nominal($total) ?></td>
										</tr>
									</tbody>
								</table>
							<?php } else {
								echo "<p class='text-center'>Tidak ada data</p>";
							} ?>
							<!-- <div class="form-group">
								<label for="">Kas Masuk</label>
								<input type="text" value="<?php echo $kas_masuk; ?>" class="form-control" readonly>
							</div> -->
							<!-- <div class="form-group">
								<label for="">Kas Keluar</label>
								<input type="text" value="<?php echo $kas_keluar; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Keterangan Masuk</label>
								<input type="text" value="<?php echo $ket_masuk; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Keterangan Keluar</label>
								<input type="text" value="<?php echo $ket_keluar; ?>" class="form-control" readonly>
							</div> -->
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-body same_height">
							<div class="form-group">
								<label for="">Total Cash</label>
								<input type="text" value="<?php echo $total_cash; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Total EDC</label>
								<input type="text" value="<?php echo $total_edc; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Total Refund</label>
								<input type="text" value="<?php echo $total_refund; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Item Jual</label>
								<input type="text" value="<?php echo $item_jual; ?>" class="form-control" readonly>
							</div>
							<div class="form-group">
								<label for="">Item Refund</label>
								<input type="text" value="<?php echo $item_refund; ?>" class="form-control" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="form-group">
								<a href="<?php echo base_url(); ?>backoffice/cashopname" type="button" class="btn btn-default">Back</a>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</form>
	</div>
</div>
