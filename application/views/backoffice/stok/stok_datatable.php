<div class="wrapper">
    <div class="pull-right">
        <a id="export_excel" href="#" class="btn btn-success btn-sm disabled">Export </a>
        <a href="<?php echo base_url(); ?>backoffice/stok/tambah_stok" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Stock</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_adjustment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Adjustment</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_transfer" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Transfer Order</a>
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
                                <input id="produk" name="produk" type="text" class="form-control" placeholder="Produk" >
                            </div>
                            <div class="input-group">
                                <input id="variant" name="variant" type="text" class="form-control" placeholder="Variant" >
                            </div>
                            <div class="input-group">
                                <?= form_dropdown('idoutlet', $opt_outlet, $outlet_selected, ' class="form-control" placeholder="Outlet" ') ?>
                            </div>
                            <button class="btn btn-default" type="submit">Filter</button>
                        </div>
                    </form>
                    <div class="pull-right form-inline">

                    </div>
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
                        <table id="table-stok" class="table table-bordered table-condensed table-strip" style="width: 100%">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Produk</th>
                                    <th>Variant Produk</th>
                                    <th>Awal</th>
                                    <th>Masuk</th>
                                    <th>Jual</th>
                                    <th>Penyesuaian</th>
                                    <th>Transfer</th>
                                    <th>Akhir</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Detil</th>
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

<!-- Modal -->
<div class="modal fade" id="detil_stok" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detil Stok</h4>
            </div>
            <div class="modal-body" id="detil_stok_content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var filter = $('#filter-report').serialize();

        var table = $('#table-stok').DataTable({
            "ordering": false,
            'ajax': {
                'url': '<?= base_url() ?>backoffice/stok/datatables/?' + filter,
                "complete": function (data, type) {
                    json = data.responseJSON;
//                    console.log(json);
//                    $('#total_penjualan').html(json.total_jual);
//                    $('#total_pendapatan').html(json.total_pendapatan);
                    auto_row_span('#table-stok', 1);
                },
            },
            "paging": true,
            "serverSide": true,
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
            filter_arr = $(this).serializeArray();
            console.log(filter_arr);


            url_reload = '<?= base_url() ?>backoffice/stok/datatables/?' + filter;
            table.ajax.url(url_reload).load();

            url_export = '<?= base_url() ?>backoffice/stok/export_excel2/?' + filter;
            $('#export_excel').attr('href', url_export);
            $('#export_excel').removeClass('disabled');
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

    function detil_modal(param) {
//        console.log(idproduk + " " + idvariant);
        var html = '<center><h4>Loading...</h4></center>';
        $('#detil_stok_content').html(html);
        $('#detil_stok').modal('show');

//        var element

        $.ajax({
            url: "<?= base_url() ?>backoffice/stok/ajax_detil_stok/", // Url to which the request is send
            type: "GET", // Type of request to be send, called as method
            data: {
                param: param
            },
            dataType: 'html', // Data sent to server, a set of key/value pairs (i.e. form fields and values)
//            contentType: false, // The content type used when sending data to the server.
//            cache: false, // To unable request pages to be cached
//            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (output)   // A function to be called if request succeeds
            {
                $('#detil_stok_content').html(output);
            }, error: function (err) {
                alert("Mohon Cek Koneksi");
                console.log(err);
            }

        });

    }



</script>
