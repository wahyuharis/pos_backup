<style>
    .same_height {
        min-height: 385px;
    }

    .fixed-alert {
        position: fixed;
        z-index: 9999;
        width: 300px;
        bottom: 10px;
        right: 10px;
    }
</style>
<div class="wrapper">
    <div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;">
        <strong>Alert !</strong>
        <p id="alert-error-html"></p>
    </div>


    <div class="panel panel-default">
        <div class="panel-body">
            <h4><?= $judul ?></h4>
        </div>
    </div>

    <div class="form">
        <?= form_open_multipart('#', ' id="validationForm" ') ?>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body same_height">
                        <center>
                            <h4>Diskon Pertransaksi</h4>
                        </center><br>
                        <?= form_hidden('id_diskon_transaksi', $id_diskon_transaksi) ?>
                        <div id="produk_buy" style="" class="form-group">
                            <label for="nama">Nama Diskon</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                <input type="text" id="nama" name="nama" value="<?= $nama ?>" placeholder="Nama Diskon" class="form-control">
                            </div>
                        </div>
                        <div id="qty_buy" style="" class="form-group">
                            <label for="diskon">Diskon (%)</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-arrows-v" aria-hidden="true"></i></span>
                                <input type="number" min="1" id="persen" name="persen" value="<?= $persen ?>" placeholder="Diskon(%)" class="form-control number-header">
                            </div>
                        </div>
                        <div id="qty_buy" style="" class="form-group">
                            <label for="outlet">Outlet</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                <?= form_dropdown('idoutlet', $opt_outlet, $idoutlet, ' class="form-control" id="outlet" ') ?>
                            </div>
                        </div>

                        <div id="qty_buy" style="" class="form-group">
                            <label for="active">Active</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-toggle-on" aria-hidden="true"></i></span>
                                <?= form_dropdown('active', $opt_active, $active, ' class="form-control" id="active" ') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body same_height">
                        <center>
                            <h4>Periode Diskon</h4>
                        </center><br>
                        <div style="" class="form-group">
                            <label for="diskon">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                <input type="text" id="persen" name="tgl_start" value="<?= $tgl_start ?>" class="form-control singgle-tanggal">
                            </div>
                        </div>
                        <div style="" class="form-group">
                            <label for="diskon">Tanggal Akhir</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                <input type="text" id="persen" name="tgl_end" value="<?= $tgl_end ?>" class="form-control singgle-tanggal">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <a href="<?php echo base_url() . $url_controller; ?>" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                            <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        //        $('select[name=produk_buy]').select2({
        //            ajax: {
        //                url: '<?= base_url() ?>backoffice/promo/ajax_pilih_produk',
        //                dataType: 'json',
        //            },
        //
        //        });

        //        $('select[name=produk_get]').select2({
        //            ajax: {
        //                url: '<?= base_url() ?>backoffice/promo/ajax_pilih_produk',
        //                dataType: 'json',
        //            },
        //
        //        });

        $('#outlet').select2();

        $('.singgle-tanggal').daterangepicker({
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
            "singleDatePicker": true,
        }, function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

    });

    $('#validationForm').submit(function(e) {
        e.preventDefault();
        $('#bsub').prop('disabled', true);

        $.ajax({
            url: "<?= base_url() . $url_controller ?>submit/", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
            {
                if (!data.status) {
                    $('#alert-error').show();
                    $('#alert-error-html').html(data.message);
                    setTimeout(function() {
                        $('#alert-error').fadeOut('slow');
                    }, 2000);
                } else {
                    window.location = '<?= base_url() . $url_controller ?>';
                }
                $('#bsub').prop('disabled', false);

            },
            error: function(err) {
                alert(JSON.stringify(err));
                $('#bsub').prop('disabled', false);
            }
        });
    });
</script>

<script>
    $(function() {
        $("input[name='qty_buy']").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $("input[name='qty_get']").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });
</script>