<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <span id="total_row"></span></a>
		<a href="<?php echo base_url(); ?>backoffice/user/export" class="btn btn-success btn-sm">Export </a>
                <a id="tambah_karyawan" href="<?php echo base_url(); ?>backoffice/user/tambah_user" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Karyawan</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman karyawan digunakan untuk melihat data karyawan yang anda miliki, anda dapat menambahkan karyawan mulai dari backofficer, dan kasir.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" style="overflow: visible;">
					<div class="pull-right form-inline">
						<a href="#" id="btn-delete-batch" class="btn btn-danger disabled"><?= DELETE_CHECKED ?> <i class="fa fa-check"></i> </a>
					</div>

					<div class="pull-right form-inline">

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="table-karyawan" class="table table-bordered table-condensed table-strip" style="width: 100%">
							<thead class="bg">
								<tr>
									<?php foreach ($table_header as $head) { ?>
										<th><?= ucwords($head) ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>

				<!--
                <div class="panel-body">
                    <ul class="pagination nomargin">
                        <li><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            -->
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-delete">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url(); ?>backoffice/user/delete">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Data</h4>
				</div>
				<div class="modal-body text-center">
					<p>
						Apakah anda yakin ingin menghapus data ini?
					</p>
					<input type="text" name="id_karyawan" value="" style="display:none;" readonly>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-delete-batch">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form method="POST" action="<?php echo base_url(); ?>backoffice/user/delete_batch">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Data</h4>
				</div>
				<div class="modal-body text-center">
					<p>
						Apakah anda yakin ingin menghapus data tsb?
					</p>
					<input type="hidden" name="id_karyawans" value="" readonly>
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
	function delete_validation(id_karyawan) {
		$('input[name=id_karyawan]').val(id_karyawan);
		$('#modal-delete').modal('show');
	}
	$(document).ready(function() {
		var table = $('#table-karyawan').DataTable({
			'ajax': {
				'url': '<?= base_url() ?>backoffice/user/datatable/',
				"complete": function(data, type) {
					json = data.responseJSON;
					console.log(json);
					$('#total_row').html(json.data.length);
				},
			},
			"processing": true,
			//            "columnDefs": [
			//                {
			//                    "targets": [5],
			//                    "visible": false,
			//                    "searchable": false
			//                },
			//            ],
		});

		$(document).on("change", ".list-checkbox", function() {
			create_url_delete();
		});


		$('input[name=cb-all]').change(function() {
			var check_all = false;
			if ($(this).is(':checked')) {
				check_all = true;
			}

			$('#table-karyawan > tbody > tr > td > input[name=karyawan-cb]').each(function() {
				$(this).prop('checked', check_all);
			});

			create_url_delete();
		});


	});

	$('#btn-delete-batch').click(function() {
		$('#modal-delete-batch').modal('show');
	});

	function create_url_delete() {
		var cb_checked = [];
		$('#table-karyawan > tbody > tr > td > input[name=karyawan-cb]').each(function() {
			if ($(this).is(':checked')) {
				cb_checked.push($(this).val());
			}
		});
		var id_karyawan_str = (JSON.stringify(cb_checked));

		if (cb_checked.length > 0) {
			$('#btn-delete-batch').removeClass('disabled');
			$('input[name=id_karyawans]').val(id_karyawan_str);
		} else {
			$('#btn-delete-batch').addClass('disabled', true);
			$('input[name=id_karyawans]').val('');
		}
	}
</script>
