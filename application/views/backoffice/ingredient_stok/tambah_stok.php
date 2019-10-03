<style>
    .same_height{
        min-height: 385px;
    }
    .fixed-alert{
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
    <div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;" >
        <strong>Alert !</strong>
        <p id="alert-error-html"></p>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Stok</h4>
        </div>
        <div class="panel-body">
            <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/ingredient_stok/insert" autocomplete="off">
                <div class="row col-md-12">
                    <div class="col-md-4" style="">
                        <div class="form-group">
                            <label for="">Ingredient</label>
                            <select name="ingredient" class="form-control" required>
                            </select>
                        </div>
                        <div style="" class="form-group">
                            <label for="">Quantity</label>
                            <input type="text" name="qty" class="form-control number-header" required>
                        </div>


                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>

                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="<?php echo base_url(); ?>backoffice/stok" type="button" class="btn btn-default">Kembali</a>
                            <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>

<script type="text/javascript">
    $('select[name=ingredient]').select2({
        ajax: {
            url: '<?= base_url() ?>backoffice/ingredient/json',
            dataType: 'json',
        },
    });
</script>
