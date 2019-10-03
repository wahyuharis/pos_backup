<style>
    #table-report_filter{
        display: none;
    }
</style>
<div class="wrapper">
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Report Penjualan Tiap Produk</div>
                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-left">

                    </div>
                    <div class="pull-left form-inline">
                        <form id="filter-report">
                            <div class="input-group" >
                                <input type="text" name="tanggal" id="tanggal" class="form-control">
                            </div>
                            <div class="input-group" style="width: 150px">
                                <?= form_dropdown('kategori', $form['opt_kategori'], '', ' class="form-control" ') ?>
                            </div>

                            <div class="input-group" style="width: 150px">
                                <select name="harga_produk" class="form-control">
                                    <option value="50000"> < Rp. 50.000</option>
                                    <option value="100000"> < Rp. 100.000</option>
                                    <option value="150000"> < Rp. 150.000</option>
                                    <option value="200000"> < Rp. 200.000</option>
                                    <option value selected="selected"> All Harga </option>
                                </select>
                            </div>

                            <div class="input-group" style="width: 150px">
                                <?= form_dropdown('outlet', $form['opt_outlet'], '', ' class="form-control" ') ?>
                            </div>
                            <div class="input-group" style="width: 150px">
                                <?= form_input('nama_produk', '', ' placeholder=" Ketikan Nama Produk "  class="form-control" ') ?>
                            </div>
                            <!--<div class="">-->
                                <button id="submit_filter" class="btn btn-default" type="submit" >Filter</button>
                            <!--</div>-->
                        </form>
                    </div>
                    <div class="pull-right form-inline">
                        <a target="_blank" href="<?= base_url() ?>/backoffice/report/export_excel2" class="btn btn-default" id="export_excel" type="button" >Export</a>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="col-md-12" style="border: 1px solid #aaa;">
                                <div class="col-md-6" align="center">
                                    <h2>Total Penjualan</h2>
                                    <h4 id="total_penjualan"></h4>
                                </div>
                                <div class="col-md-6" align="center">
                                    <h2>Total Pendapatan</h2>
                                    <h4 id="total_pendapatan"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <!--<div class="col-md-12">-->
                    <div class="table-responsive">
                        <table id="table-report" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Qty Jual</th>
                                    <th>Total Jual</th>
                                    <th>Int Total Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!--</div>-->

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#table-report').DataTable({
            'ajax': {
                'url': '<?= base_url() ?>backoffice/report/sales_peritem/',
                "complete": function (data, type) {
                    json = data.responseJSON;
                    console.log(json);
                    $('#total_penjualan').html(json.total_jual);
                    $('#total_pendapatan').html(json.total_pendapatan);
                },
            },
            "processing": true,
            "columnDefs": [
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                },
            ],
        });

        $('#filter-report').submit(function (e) {
            e.preventDefault();

            filter = $(this).serialize();

            url_reload = '<?= base_url() ?>backoffice/report/sales_peritem/?' + filter;
            table.ajax.url(url_reload).load();

            url_export = '<?= base_url() ?>backoffice/report/export_excel2/?' + filter;
            $('#export_excel').attr('href', url_export);
        });

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
        }, function (start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

    });
</script>