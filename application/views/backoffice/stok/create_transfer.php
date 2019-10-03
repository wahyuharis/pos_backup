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

    .select2-results__option[aria-selected=true] {
        display: none;
    }
</style>

<div class="wrapper">
    <div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;">
        <strong>Alert !</strong>
        <p id="alert-error-html"></p>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Transfer Stok</h4>
        </div>
        <div class="panel-body">
            <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/promo/submit" autocomplete="off">
                <div class="row col-md-12">
                    <div class="col-md-4" style="">
                        <div id="produk_buy" style="" class="form-group">
                            <label for="">Produk - Variant</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                <select name="produk_out" class="form-control">
                                    <?= $selected_item ?>
                                </select>
                            </div>
                        </div>
                        <div style="" class="form-group">
                            <label for="">Outlet</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                <?= form_dropdown('outlet_out', $outlet, array(), ' class="form-control" id="outlet"  ') ?>
                            </div>
                        </div>
                        <div style="" class="form-group">
                            <label for="">Ke Outlet</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                <?= form_dropdown('outlet_in', $outlet, array(), ' class="form-control" id="outlet2"  ') ?>
                            </div>
                        </div>
                        <div style="" class="form-group">
                            <label for="">Quantity</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-arrows-v" aria-hidden="true"></i></span>
                                <input type="number" min="1" name="qty_out" value="<?= $qty_add ?>" class="form-control number-header">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>

                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="<?php echo base_url(); ?>backoffice/stok" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                            <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#outlet,#outlet2').select2();

        $('select[name=produk_out]').select2({
            ajax: {
                url: '<?= base_url() ?>backoffice/promo/ajax_pilih_produk',
                dataType: 'json',
            },
        });
    });

    $('#validationForm').submit(function(e) {
        e.preventDefault();
        $('#bsub').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...');
        $('#bsub').prop('disabled', true);

        $.ajax({
            url: "<?= base_url() ?>backoffice/stok/submit_transfer_order/", // Url to which the request is send
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
                    window.location = '<?= base_url() ?>backoffice/stok/';
                }
                setTimeout(function() {
                    $('#bsub').prop('disabled', false);
                    $('#bsub').html('submit');
                }, 1000);

            },
            error: function(err) {
                alert(JSON.stringify(err));
                $('#bsub').prop('disabled', false);
            }
        });
    });
</script>