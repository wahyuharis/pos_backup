<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : </a>
        <a href="<?php echo base_url().$url_controller; ?>/export" class="btn btn-success btn-sm">Export </a>
        <a id="tambah_promo" href="<?php echo base_url().$url_controller; ?>add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Diskon</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p> Diskon Transaksi Adalah Diskon Yang Akan Dipotongkan Pada Total Akhir Transaksi, anda dapat mengubah status dengan mengeklik button pada status.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table id="promo-list" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Diskon</th>
                                    <th>Outlet</th>
                                    <th>Disc(%)</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th>Status</th>
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
            <form method="POST" action="<?php echo base_url().$url_controller.'delete'; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Data</h4>
                </div>
                <div class="modal-body text-center">
                    <p>
                        Apakah anda yakin ingin menghapus data ini?
                    </p>
                    <input type="hidden" name="id_diskon_transaksi" value="">
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
    function delete_validation(id_diskon) {
        $('input[name=id_diskon_transaksi]').val(id_diskon);
        $('#modal-delete').modal('show');
    }

    $(document).ready(function () {
        var table = $('#promo-list').DataTable({
            'ajax': {
                'url': '<?= base_url(). $url_controller.'datatable' ?>',
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