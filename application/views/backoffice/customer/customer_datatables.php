<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <span id="total_row"></span></a>
		<a class="btn btn-success btn-sm" href="<?= base_url() . "backoffice/customer/export_excel" ?>" id="export_excel" type="submit">Export</a>
		<a class="btn btn-primary btn-sm" href="<?= base_url() . "backoffice/customer/tambah_customer" ?>" id="export_excel" type="submit"><i class="fa fa-plus"></i> Tambah Customer</a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman customer digunakan untuk melihat data customer yang membeli produk dari outlet anda.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" style="overflow: visible;">
					<form method="POST" id="filter-customer">
						<div class="pull-left form-inline">
							<div class="input-group" style="width: 150px">
								<?= form_dropdown('outlet', $opt_outlet, '', ' class="form-control" ') ?>
							</div>
							<div class="input-group" style="width: 150px">
								<?= form_dropdown('provinsi', $opt_provinsi, '', ' class="form-control" id="provinsi"') ?>
							</div>
							<div class="input-group">
								<select name="kabupaten" id="kabupaten-kota" class="form-control" style="width: 150px;">
									<option value>Semua Kabupaten</option>
								</select>
							</div>
							<div class="input-group">
								<select name="kecamatan" id="kecamatan" class="form-control" style="width: 150px;">
									<option value>Semua Kecamatan</option>
								</select>
							</div>
							<button class="btn btn-default" name="filter" type="submit">Filter</button>
							<!-- <a class="btn btn-success" href="<?= base_url() . "backoffice/customer/export_excel" ?>" id="export_excel" type="submit">Export</a> -->
						</div>
						<div class="pull-right form-inline">
							<a href="#" id="btn-delete-batch" class="btn btn-danger disabled"><?= DELETE_CHECKED ?> <i class="fa fa-check"></i> </a>
						</div>
					</form>

					<div class="pull-right form-inline">

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="table-customer" class="table table-bordered table-condensed table-strip" style="width:100%">
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
			<form method="POST" action="<?php echo base_url(); ?>backoffice/customer/delete">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Data</h4>
				</div>
				<div class="modal-body text-center">
					<p>
						Apakah anda yakin ingin menghapus data ini?
					</p>
					<input type="text" name="idctm" value="" style="display:none;" readonly>
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
			<form method="POST" action="<?php echo base_url(); ?>backoffice/customer/delete_batch">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Delete Data</h4>
				</div>
				<div class="modal-body text-center">
					<p>
						Apakah anda yakin ingin menghapus data tsb?
					</p>
					<input type="hidden" name="id_customer" value="" readonly>
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
	function delete_validation(id_ctm) {
		$('input[name=idctm]').val(id_ctm);
		$('#modal-delete').modal('show');
	}
	$(document).ready(function() {
		var table = $('#table-customer').DataTable({
			'ajax': {
				'url': '<?= base_url() ?>backoffice/customer/datatable/',
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

		$('#filter-customer').submit(function(e) {
			e.preventDefault();

			filter = $(this).serialize();

			url_reload = '<?= base_url() ?>backoffice/customer/datatable/?' + filter;
			table.ajax.url(url_reload).load();

			url_export = '<?= base_url() ?>backoffice/customer/export_excel/?' + filter;
			$('#export_excel').attr('href', url_export);

		});

		$(document).on("change", ".list-checkbox", function() {
			create_url_delete();
		});


		$('input[name=cb-all]').change(function() {
			var check_all = false;
			if ($(this).is(':checked')) {
				check_all = true;
			}

			$('#table-customer > tbody > tr > td > input[name=customer-cb]').each(function() {
				$(this).prop('checked', check_all);
			});

			create_url_delete();
		});


	});

	$(function() {
		$.ajaxSetup({
			type: "POST",
			url: "<?php echo base_url('backoffice/customer/ambil_data'); ?>",
			cache: false,
		});
		$("#provinsi").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kabupaten',
						id: value
					},
					success: function(res) {
						$('#kabupaten-kota').empty();
						$('#kecamatan').empty();
						var listitems = '<option value="">Semua Kabupaten</option>';
						$.each(res, function(key, value) {
							listitems += '<option value=' + value.id + '>' + value.name + '</option>';
						});
						$('#kabupaten-kota').append(listitems);
						$('#kecamatan').append('<option value="">Semua Kecamatan</option>');
						// $("#kabupaten-kota").html(respond);
					}
				})
			}
		});
		$("#kabupaten-kota").change(function() {
			var value = $(this).val();
			if (value > 0) {
				$.ajax({
					data: {
						modul: 'kecamatan',
						id: value
					},
					success: function(res) {
						$('#kecamatan').empty();
						var listitems = '<option value="">Semua Kecamatan</option>';
						$.each(res, function(key, value) {
							listitems += '<option value=' + value.id + '>' + value.name + '</option>';
						});
						$('#kecamatan').append(listitems);

						// $("#kecamatan").html(respond);
					}
				})
			}
		})
	})

	$('#btn-delete-batch').click(function() {
		$('#modal-delete-batch').modal('show');
	});

	function create_url_delete() {
		var cb_checked = [];
		$('#table-customer > tbody > tr > td > input[name=customer-cb]').each(function() {
			if ($(this).is(':checked')) {
				cb_checked.push($(this).val());
			}
		});
		var id_customer_str = (JSON.stringify(cb_checked));

		if (cb_checked.length > 0) {
			$('#btn-delete-batch').removeClass('disabled');
			$('input[name=id_customer]').val(id_customer_str);
		} else {
			$('#btn-delete-batch').addClass('disabled', true);
			$('input[name=id_customer]').val('');
		}
	}
</script>
