<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?=$jum_pro ?></a>
        <a href="<?php echo base_url(); ?>backoffice/promo/export" class="btn btn-success btn-sm">Export </a>
        <a id="tambah_promo" href="<?php echo base_url(); ?>backoffice/promo/tambah_promosi" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Promo</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman promo digunakan untuk mengelola promo, anda dapat menambahkan promo baru atau mengedit dan menghapus promo yang ada.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table id="promo-list" class="table table-bordered table-condensed table-strip" style="width: 100%">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Buy</th>
                                    <th>Qty</th>
                                    <th>Get</th>
                                    <th>Qty</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th width="100" class="text-center">Action</th>
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
            <form method="POST" action="<?php echo base_url(); ?>backoffice/promo/delete">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Data</h4>
                </div>
                <div class="modal-body text-center">
                    <p>
                        Apakah anda yakin ingin menghapus data ini?
                    </p>
                    <input type="hidden" name="id_promo" value="">
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
    function delete_validation(id_promo) {
        $('input[name=id_promo]').val(id_promo);
        $('#modal-delete').modal('show');
    }

    $(document).ready(function () {
        var table = $('#promo-list').DataTable({
            'ajax': {
                'url': '<?= base_url() ?>backoffice/promo/datatable/',
                "complete": function (data, type) {
                    /*json = data.responseJSON;
                     console.log(json);
                     $('#total_penjualan').html(json.total_jual);
                     $('#total_pendapatan').html(json.total_pendapatan);*/
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
    });
</script>
