<div class="wrapper">
	<div class="pull-right">
		<a class="btn btn-default btn-sm">Total : <span id="total_row"></span> <?php //echo $jum_cop;  
																										?></a>
		<a id="export_excel" href="<?= base_url() ?>backoffice/cashopname/export_excel2/" class="btn btn-success btn-sm">Export </a>
	</div>
	<div class="clearfix"></div>
	<br />
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<p>Halaman cashopname digunakan untuk melihat data kas masuk dan kas keluar yang dimasukan oleh kasir anda setiap shiftnya. </p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" style="overflow: visible;">
					<form id="filter-report" method="get" action="#">
						<div class="pull-left form-inline">
							<div class="input-group">
								<input name="tanggal" id="tanggal" type="text" class="form-control">
							</div>
							<div class="input-group">
								<?= form_dropdown('kasir', $opt_kasir, '', ' class="form-control" ') ?>
							</div>
							<div class="input-group">
								<?= form_dropdown('outlet', $opt_outlet, '', ' class="form-control" ') ?>
							</div>
							<button class="btn btn-default" type="submit">Filter</button>
						</div>
					</form>
					<div class="pull-right form-inline">
						<!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".advance-search">Advance Search</button>
                        -->
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body form-inline collapse advance-search">
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Bisnis</option>
					</select>
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Wilayah</option>
					</select>
					<select name="" id="" class="form-control input-sm">
						<option value="">Semua Status</option>
					</select>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="table-cashopname" class="table table-bordered table-condensed table-strip" style="width:100%">
							<thead class="bg">
								<tr>
									<th width="10">No</th>
									<th>Outlet</th>
									<th>Kasir</th>
									<th>Tanggal</th>
									<th>Begining</th>
									<th>Ending</th>
									<th>Jam Mulai</th>
									<th>Jam Akhir</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		var table = $('#table-cashopname').DataTable({
			"ordering": false,
			'ajax': {
				'url': '<?= base_url() ?>backoffice/cashopname/datatables/',
				"complete": function(data, type) {
					json = data.responseJSON;
					console.log(json);
					$('#total_row').html(json.data.length);
					//                    $('#total_penjualan').html(json.total_jual);
					//                    $('#total_pendapatan').html(json.total_pendapatan);
					//                    auto_row_span('#table-stok', 1);
				},
			},
			"processing": true,
			"columnDefs": [
				//                {
				//                    "targets": [5],
				//                    "visible": false,
				//                    "searchable": false
				//                },
			],
		});

		$('#filter-report').submit(function(e) {
			e.preventDefault();

			filter = $(this).serialize();

			url_reload = '<?= base_url() ?>backoffice/cashopname/datatables/?' + filter;
			table.ajax.url(url_reload).load();

			url_export = '<?= base_url() ?>backoffice/cashopname/export_excel2/?' + filter;
			$('#export_excel').attr('href', url_export);
		});

		$('#table-cashopname_filter').hide();


		$('#tanggal').daterangepicker({
			"autoApply": true,
			locale: {
				format: 'DD/MM/YYYY'
			},
			"ranges": {
				"Today": [moment(), moment()],
				"Yesterday": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				"Last 7 Days": [moment().subtract(6, 'days'), moment()],
				"Last 30 Days": [moment().subtract(29, 'days'), moment()],
				"This Month": [moment().startOf('month'), moment().endOf('month')],
				"Last Month": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			"alwaysShowCalendars": true,
			"startDate": moment().subtract(6, 'days'),
			"endDate": moment()
		}, function(start, end, label) {
			console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
		});

	});
</script>
