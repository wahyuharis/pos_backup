<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_tot; ?></a>
        <a class="btn btn-success btn-sm disabled" href="<?= base_url() ?>backoffice/transaksi/export_excel2/" id="export_excel" type="submit">Export </a>
    </div>
    <div class="clearfix"></div>
    <br />
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <form method="POST" id="filter-report" action="<?php echo base_url(); ?>backoffice/transaksi/">
                        <div class="pull-left form-inline">

                            <div class="input-group">
                                <input id="tanggal" name="tanggal" type="text" class="form-control" value="" style="min-width: 270px;">
                            </div>
                            <div class="input-group">
                                <input id="kode_trans" placeholder="Kode Transaksi" name="kode_trans" type="text" class="form-control" value="">
                            </div>
                            <div class="input-group">
                                <select name="kasir" class="form-control" style="width: 150px;">
                                    <option value>Semua Kasir</option>
                                    <?php foreach ($karyawan as $rw) : ?>
                                        <option value="<?php echo $rw->iduser; ?>"><?php echo $rw->nama_user; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <?= form_dropdown('outlet', $opt_outlet, '', ' class="form-control" ') ?>
                            </div>
                            <!--                            <div class="input-group">
                                                            <select name="jumlah_data" class="form-control" style="width: 150px;">
                                                                <option value="100000000">-- Jumlah Data --</option>
                                                                <option value="10"> 10 </option>
                                                                <option value="100"> 100 </option>
                                                                <option value="1000"> 1000 </option>
                                                            </select>
                                                        </div>-->
                            <button class="btn btn-default" name="filter" type="submit">Filter</button>
                        </div>
                        <!-- <div class="pull-right form-inline">
                            <a class="btn btn-success btn-sm" href="<?= base_url() ?>backoffice/transaksi/export_excel2/" id="export_excel" type="submit">Export </a>
                        </div> -->

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
                        <table id="table-transaksi" class="table table-bordered table-condensed table-strip" style="width: 100%">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Outlet</th>
                                    <th>Kasir</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
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
        var table = $('#table-transaksi').DataTable({
            'ajax': {
                'url': '<?= base_url() ?>backoffice/transaksi/datatable/',
                "complete": function(data, type) {
                    json = data.responseJSON;
                    console.log(json);
                    $('#total_penjualan').html(json.total_jual);
                    $('#total_pendapatan').html(json.total_pendapatan);
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

        $('#filter-report').submit(function(e) {
            e.preventDefault();

            filter = $(this).serialize();

            url_reload = '<?= base_url() ?>backoffice/transaksi/datatable/?' + filter;
            table.ajax.url(url_reload).load();

            url_export = '<?= base_url() ?>backoffice/transaksi/export_excel2/?' + filter;
            $('#export_excel').attr('href', url_export);
            $('#export_excel').removeClass('disabled');

        });

        $('#table-transaksi_filter').hide();

        $('#tanggal').daterangepicker({
            "autoApply": true,
            timePicker: false,
            timePicker24Hour: true,
            timePickerIncrement: 30,
            locale: {
                format: 'DD/MM/YYYY HH:mm'
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
            "startDate": moment().startOf('month'),
            "endDate": moment().endOf('month')
        }, function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });
    });
</script>