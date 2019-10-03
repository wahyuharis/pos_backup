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
            <h4>Tambah Promo</h4>
        </div>
    </div>

    <div class="form">
        <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/promo/submit" autocomplete="off">
            <?= form_hidden('idpromo', $idpromo) ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <center>
                                <h4>Produk Promo</h4>
                            </center><br>
                            <div id="produk_buy" style="" class="form-group">
                                <label for="">Produk - Variant</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                    <select name="produk_buy" class="form-control">
                                        <?= $selected_item ?>
                                    </select>
                                </div>
                            </div>
                            <div id="qty_buy" style="" class="form-group">
                                <label for="">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-arrows-v" aria-hidden="true"></i></span>
                                    <input type="number" min="1" name="qty_buy" value="<?= $qty_buy ?>" class="form-control number-header">
                                </div>
                            </div>
                            <div class="text-muted">
                                <i>Tentukan produk yang sedang promo.</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <center>
                                <h4>Produk Bonus</h4>
                            </center><br>
                            <div id="produk_get" style="" class="form-group">
                                <label for="">Produk - Variant</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                    <select name="produk_get" class="form-control">
                                        <?= $selected_item_get ?>
                                    </select>
                                </div>
                            </div>
                            <div id="qty_get" style="" class="form-group">
                                <label for="">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-arrows-v" aria-hidden="true"></i></span>
                                    <input type="number" min="1" name="qty_get" value="<?= $qty_get ?>" class="form-control number-header">
                                </div>
                            </div>
                            <div class="text-muted">
                                <i>Tentukan produk yang akan dijadikan bonus saat membeli produk yang sedang promo.</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <div class="form-group">
                                <label for="">Tanggal Mulai</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-calendar" aria-hidden="true"></i></i></span>
                                    <input name="tgl_mulai" value="<?= $tanggal_mulai ?>" type="text" class="form-control singgle-tanggal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Akhir</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    <input name="tgl_akhir" value="<?= $tanggal_akhir ?>" type="text" class="form-control singgle-tanggal">
                                </div>
                            </div>
                            <?php $id_business = $this->session->userdata('id_business'); ?>
                            <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <div class="form-group">
                                <label for="">Bisnis</label>
                                <?php foreach ($bus as $row) : ?>
                                    <input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
                                <?php endforeach; ?>
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
                                <a href="<?php echo base_url(); ?>backoffice/promo" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                                <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('select[name=produk_buy]').select2({
            ajax: {
                url: '<?= base_url() ?>backoffice/promo/ajax_pilih_produk',
                dataType: 'json',
            },

        });

        $('select[name=produk_get]').select2({
            ajax: {
                url: '<?= base_url() ?>backoffice/promo/ajax_pilih_produk',
                dataType: 'json',
            },

        });

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
            url: "<?= base_url() ?>backoffice/promo/submit/", // Url to which the request is send
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
                    window.location = '<?= base_url() ?>backoffice/promo/';
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