<style>
    #table-produk_filter{
        display: none;
    }
</style>
<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <span id="total_row" ></span></a>
        <a href="<?= base_url() . "backoffice/produk/export_excel" ?>" class="btn btn-success btn-sm">Export </a>
        <a id="create_produk" href="<?php echo base_url(); ?>backoffice/produk/tambah_produk" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Produk</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <!-- <div class="panel panel-default">
        <div class="panel-body">
        </div>
    </div> -->

    <!--<div class="clearfix"></div>-->
    <!--<br/>-->
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman produk digunakan untuk mengelola produk yang anda jual, untuk mengelola variant, kategori dan modifier gunakan halaman tersebut.</p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <form id="form-filter" class="form-inline" action="#">
                        <div class="pull-left">
                            <div class="form-group">
                                <?= form_dropdown('kategori', $opt_kategori, '', ' class="form-control" ') ?>
                            </div>
                            <div class="form-group">
                                <?= form_dropdown('outlet', $opt_outlet, '',  ' class="form-control" ')?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="produk" placeholder="Produk" >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="variant" placeholder="Variant" >
                            </div>

                            <button type="submit" class="btn btn-default">Filter</button>
                        </div>
                        <div class="pull-right form-inline">
                            <a href="#" id="btn-delete-batch" class="btn btn-danger disabled"><?= DELETE_CHECKED ?> <i class="fa fa-check"></i> </a>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>
                <style>
                    #table-produk > tbody>tr>td:nth-child(6),
                    #table-produk > tbody>tr>td:nth-child(7),
                    #table-produk > tbody>tr>td:nth-child(8),
                    #table-produk > tbody>tr>td:nth-child(9){
                        padding: 0px;
                    }
                    .multi-row{
                        border-top: 1px solid #eee;
                        padding: 6px 6px 6px 6px;
                        margin-top: -1px;
                        display: block;
                        width: 100%;
                    }
                    .text-right{
                        text-align: right;
                    }
                </style>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="table-produk" class="table table-bordered table-condensed table-strip" style="width: 100%">
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url(); ?>backoffice/produk/delete">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Data</h4>
                </div>
                <div class="modal-body text-center">
                    <p>
                        Apakah anda yakin ingin menghapus data ini?
                    </p>
                    <input type="hidden" name="id_produk" value="" readonly>
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
            <form method="POST" action="<?php echo base_url(); ?>backoffice/produk/delete_batch">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Data</h4>
                </div>
                <div class="modal-body text-center">
                    <p>
                        Apakah anda yakin ingin menghapus data tsb?
                    </p>
                    <input type="hidden" name="id_produks" value="" readonly>
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
    function delete_validation(id_produk) {
        $('input[name=id_produk]').val(id_produk);
        $('#modal-delete').modal('show');
    }

    $(document).ready(function () {
        var table = $('#table-produk').DataTable({
            'ajax': {
                'url': '<?= base_url() ?>backoffice/produk/datatables',
                "complete": function (data, type) {
                    json = data.responseJSON;
//                    console.log(json);
                    $('#total_row').html(json.recordsTotal);
                },
            },
            "order": [[1, "desc"]],
            "serverSide": true,
            "processing": true,
            "columnDefs": [
                {
                    "targets": 0,
                    "orderable": false,
                    "width": "25",
//                    "visible": false,
//                    "searchable": false
                },
                {
                    "targets": 5,
                    "orderable": false,
//                    "visible": false, 
                    "searchable": false
                },
                {
                    "targets": 6,
                    "orderable": false,
//                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 7,
                    "orderable": false,
//                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 8,
                    "orderable": false,
//                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 9,
                    "orderable": false,
//                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 10,
                    "orderable": false,
//                    "visible": false,
                    "searchable": false
                },
            ],
        });

        $('#form-filter').submit(function (e) {
            e.preventDefault();

            filter = $(this).serialize();

            url_reload = '<?= base_url() ?>backoffice/produk/datatables/?' + filter;
            table.ajax.url(url_reload).load();

            url_export = '<?= base_url() ?>backoffice/produk/export_excel/?' + filter;
            $('#export_excel').attr('href', url_export);

        });

        $(document).on("change", ".list-checkbox", function () {
            create_url_delete();
        });


        $('input[name=cb-all]').change(function () {
            var check_all = false;
            if ($(this).is(':checked')) {
                check_all = true;
            }

            $('#table-produk > tbody > tr > td > input[name=produk-cb]').each(function () {
                $(this).prop('checked', check_all);
            });

            create_url_delete();
        });

        $('#table-produk > tbody').bind("DOMSubtreeModified", function () {
            var checkall = $('#table-produk > thead').children().find('input[name=cb-all]');
            if (checkall.is(':checked')) {
                checkall.prop('checked', false);
            }
        });

    });


    $('#btn-delete-batch').click(function () {
        $('#modal-delete-batch').modal('show');
    });

    function create_url_delete() {
        var cb_checked = [];
        $('#table-produk > tbody > tr > td > input[name=produk-cb]').each(function () {
            if ($(this).is(':checked')) {
                cb_checked.push($(this).val());
            }
        });
        var id_produks_str = (JSON.stringify(cb_checked));

        if (cb_checked.length > 0) {
            $('#btn-delete-batch').removeClass('disabled');
            $('input[name=id_produks]').val(id_produks_str);
        } else {
            $('#btn-delete-batch').addClass('disabled', true);
            $('input[name=id_produks]').val('');
        }
    }
</script>
