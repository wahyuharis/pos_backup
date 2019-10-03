<div class="wrapper">
    <div class="pull-right">
        <a id="export_excel" href="<?= base_url() ?>backoffice/stok/export_excel2" class="btn btn-default btn-sm">Export </a>
        <a href="<?php echo base_url(); ?>backoffice/ingredient_stok/tambah_stok" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Stock</a>
        <!-- <a href="<?php echo base_url(); ?>backoffice/stok/create_adjustment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Adjustment</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_transfer" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Transfer Order</a> -->
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <form id="filter-report" method="get" action="#">
                        <div class="pull-left form-inline">
                            <div class="input-group">
                                <input id="tanggal" name="tanggal" type="text" class="form-control">
                            </div>
                            <div class="input-group">
                                <input id="produk" name="ingredient" type="text" class="form-control" placeholder="Ingredient" >
                            </div>
                            <button class="btn btn-default" type="submit">Filter</button>
                        </div>
                    </form>
                    <div class="pull-right form-inline">

                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table-stok" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th>Nama Igredient</th>
                                    <th>Awal</th>
                                    <th>Masuk</th>
                                    <th>Pake</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var filter=$('#filter-report').serialize();
        
        var table = $('#table-stok').DataTable({
            "ordering": false,
            'ajax': {
                'url': '<?= base_url() ?>backoffice/ingredient_stok/datatables/?'+filter,
                "complete": function (data, type) {
                    json = data.responseJSON;
//                    console.log(json);
//                    $('#total_penjualan').html(json.total_jual);
//                    $('#total_pendapatan').html(json.total_pendapatan);
                    auto_row_span('#table-stok', 1);
                },
            },
            "paging": false,
            "processing": true,
            "columnDefs": [
//                {
//                    "targets": [5],
//                    "visible": false,
//                    "searchable": false
//                },
            ],
        });

        $('#filter-report').submit(function (e) {
            e.preventDefault();

            filter = $(this).serialize();

            url_reload = '<?= base_url() ?>backoffice/stok/datatables/?' + filter;
            table.ajax.url(url_reload).load();

            url_export = '<?= base_url() ?>backoffice/stok/export_excel2/?' + filter;
            $('#export_excel').attr('href', url_export);
        });

        $('#table-stok_filter').hide();


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

    function auto_row_span(idtabel, kolom) {
        var arr = [];
        var n = 0;
        var rs = 1;
        var idrs = 1;
        no_kol = 'col' + kolom;
        $(idtabel + " tbody tr").each(function (index) {
            myelemen = $(this).find("td:eq(" + kolom + ")");
            arr.push(myelemen.html());
            if (arr[n] == arr[n - 1]) {
                rs++;
                myelemen.remove();
                myelemen.html(rs);
            } else if (arr[n] != arr[n - 1]) {
                myelemen.css("font-weight", "bold");
                myelemen.css("vertical-align", "middle");
                myelemen.attr('id', no_kol + '' + idrs + '');
                if (n != 0) {
                    $(idtabel + ' tbody').find('#' + no_kol + ((idrs - 1) * 1)).attr('rowspan', '' + rs + '');
                }
                rs = 1;
                idrs++;
            }
            n++;
        });
        $(idtabel + ' tbody').find('#' + no_kol + ((idrs - 1) * 1)).attr('rowspan', '' + rs + '');
    }
</script>
