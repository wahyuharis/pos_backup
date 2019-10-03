<style>
    .same_height {
        min-height: 385px;
    }
    .popover {
        width: 100%;
        background-color: #187FE0;
        color: white;

    }
    .fixed-alert {
        position: fixed;
        z-index: 9999;
        width: 300px;
        bottom: 10px;
        right: 10px;
    }
    .error-message {
        color: rgb(255, 102, 102);
    }
</style>
<div class="wrapper">
    <div id="alert-error" class="alert alert-danger fixed-alert" style="display: none;">
        <strong>Alert !</strong>
        <p id="alert-error-html"></p>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Produk</h4>
        </div>
        <div class="panel-body">
            <div class="form">
                <form id="form-produk" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/produk/insert_produk">
                    <div class="row">
                        <div class="col-md-5">
                            <!--<div class="panel panel-default">-->
                            <!--<div class="panel-body same_height" >-->
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-object-group" aria-hidden="true"></i></span>
                                    <select class="form-control" name="kategori" id="kategori">
                                        <?= $selected_item ?>
                                    </select>
                                    <span class="input-group-btn" style="background-color: white">
                                        <button id="tambah_kategori" class="btn btn-primary btn-xs" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                                <i class="error-message" id="idkategori_err"></i>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-dropbox" aria-hidden="true"></i></span>
                                    <?php
                                    $nama_produk = "";
                                    $selected_category = 0;
                                    if (!isset($produk_id)) {
                                        $produk_id = "";
                                    }
                                    if (isset($produk[0])) {
                                        $nama_produk = $produk[0]->nama_produk;
                                        $selected_category = $produk[0]->idkategori;
                                    }
                                    ?>
                                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" value="<?= $nama_produk ?>">
                                    <input type="hidden" name="produk_id" value="<?= $produk_id ?>">
                                </div>
                                <i class="error-message" id="nama_produk_err"></i>
                            </div>
                            <!--                            <div class="form-group">
                                                            <label for="">Kategori</label>
                                                            <select name="kategori" id="" class="form-control">
                                                                <option value="0">Pilih Kategori</option>
                            <?php foreach ($comkat as $rw) : ?>
                                <?php
                                $selected = "";
                                if ($selected_category == $rw->idkategori) {
                                    $selected = ' selected="true" ';
                                }
                                ?>                                                                                                                                                                                                           <option <?= $selected ?> value="<?php echo $rw->idkategori; ?>"><?php echo $rw->nama_kategori; ?></option>
                            <?php endforeach; ?>
                                                            </select>
                                                        </div>-->

                            <?php
                            $hide_sku_produck = "";
                            if (isset($variant_list)) {
                                if (count($variant_list) > 0) {
                                    $hide_sku_produck = ' hidden ';
                                }
                            }
                            ?>
                            <div class="form-group <?= $hide_sku_produck ?>">
                                <label for="sku">SKU</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-barcode" aria-hidden="true"></i></span>
                                    <?= form_input('sku', $sku, ' id="sku" class="form-control" ') ?>
                                </div>
                                <input type="checkbox" id="toggle_sku" value="0" /> <label style="font-weight: normal;" for="toggle_sku"><i>Auto Generate</i></label>
                            </div>
                            <?php $id_business = $this->session->userdata('id_business'); ?>
                            <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <?php foreach ($bus as $row) : ?>
                                <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
                            <?php endforeach; ?>
                            <!-- <div class="form-group">
                                <label for="">Business</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                            <?php //foreach ($bus as $row) : 
                            ?>
                                        <input type="text" class="form-control" value="<?php //echo $row->nama_business; 
                            ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php //echo $row->idbusiness; 
                            ?>" readonly>
                            <?php //endforeach; 
                            ?>
                                </div>
                                                                         </div> -->

                            <!-- variant produk -->
									<?php if($this->uri->segment(3) == 'tambah_produk'): ?>
                            <div class="form-group">
                                <label for=""><i class="fa fa-list" aria-hidden="true"></i> Pakai Variant</label>
                                <?php
                                $yes = "";
                                $ask_disabled = "";
                                $no = "";
                                if (isset($variant_list)) {
                                    if (count($variant_list) > 0) {
                                        $yes = ' selected="true" ';
                                        $no = ' disabled ';
                                        $ask_disabled = ' disabled ';
                                    } else {
                                        $no = ' selected="true"  ';
                                        $yes = ' disabled ';
                                        $ask_disabled = ' disabled ';
                                    }
                                }
                                ?>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-list" aria-hidden="true"></i></span>
                                    <select name="variant" id="variant" onchange="pakaiVariant()" class="form-control">
                                        <option <?= $ask_disabled ?> value="0">Pakai Variant ?</option>
                                        <option <?= $yes ?> value="Ya">Ya</option>
                                        <option <?= $no ?> value="Tidak">Tidak</option>
                                    </select>
                                </div>


                            </div>
									<?php endif; ?>
                            <?php
                            $hgstock = ' display: none; ';
                            if (isset($variant_list)) {
                                if (count($variant_list) > 0) {
                                    
                                } else {
                                    $hgstock = '';
                                }
                            }
                            ?>
                            <div id="hgstock" style="<?= $hgstock ?>">
                                <div class="form-group">
                                    <label for="">Harga Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white">Rp. </span>
                                        <input type="text" name="harga_produk" class="form-control number-header" value="<?= $harga_produk ?>">
                                    </div>
                                    <i class="error-message" id="harga_produk_err"></i>
                                </div>

                                <?php
                                $disabled = "";
                                $hidden = '';
                                if (!empty($produk_id)) {
                                    $disabled = ' disabled="true" ';
                                    $hidden = ' hidden ';
                                }

                                if (!$pakai_stok) {
                                    $hidden = ' hidden ';
                                }
                                ?>
                                <div class="form-group  <?= $hidden ?>">
                                    <label for="">Stok Awal Produk</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-list" aria-hidden="true"></i></span>
                                        <input type="text" name="stock_awal" class="form-control number-header <?= $hidden ?>" value="1000">
                                    </div>
                                    <i class="error-message" id="stock_awal_err"></i>
                                    <i> <i class="fa fa-bell-o" aria-hidden="true"></i> Jika anda tidak ingin menggunakan stok, isi stok awal dengan 1000</i>
                                </div>
                            </div>

                            <!--- VAriant --->
                            <?php
                            $display_none = 'display: none';
                            if (isset($variant_list)) {
                                if (count($variant_list) > 0) {
                                    $display_none = "";
                                }
                            }
                            ?>
                            <div id="variant-list" style="<?= $display_none ?>">
                                <table class="table table-bordered table-condensed table-strip hidden" style="margin-bottom: 0px;background-color: #eee;">
                                    <tbody>
                                        <tr>
                                            <td>#</td>
                                            <td>
                                                <b>SKU(opsional)</b><br>
                                                <input data-bind="value:sku_variant_add" class="form-control input-sm" placeholder="SKU" type="text">
                                            </td>
                                            <td>
                                                <b>Variant</b><br>
                                                <input data-bind="value:nama_variant_add" class="form-control input-sm" placeholder="Nama Variant" type="text">
                                            </td>
                                            <td>
                                                <b>Harga</b><br>
                                                <input data-bind="value:harga_add,event: {'keyup':add_variant_enter}" class="form-control input-sm number-header" placeholder="Harga" type="text">
                                            </td>
                                            <td>
                                                <b>Stok Awal</b><br>
                                                <?php
                                                $stok_disabled = '';
                                                if (isset($produk_id) && strlen($produk_id) > 0) {
                                                    //                                                    $stok_disabled=' hidden ';
                                                }
                                                $stok_hidden = "";
                                                if ($pakai_stok) {
                                                    $stok_hidden = ' ';
                                                } else {
                                                    $stok_hidden = ' hidden ';
                                                }
                                                ?>
                                                <input data-bind="value:stok_add,event: {'keyup':add_variant_enter}" class="form-control input-sm number-header <?= $stok_hidden ?>" placeholder="Stok" type="text">
                                            </td>
                                            <td>#</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><i>*SKU : Jika produk memiliki sku(barcode) isikan diatas. Jika tidak SKU akan digenerate otomatis</i></td>
                                            <td colspan="">
                                                <a class="btn btn-primary btn-xs" data-bind="click:add_variant_click" style="float: right"> <i class="fa fa-plus-circle"></i> Tambah</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p></p>
                                <p></p>
                                <table id="table-variant-list" class="table table-bordered table-condensed table-strip">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>SKU</th>
                                            <th>Variant</th>
                                            <th>Harga</th>
                                            <th>Stok Awal</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody data-bind="foreach: variant_list">
                                        <?php
                                        $stok_hidden = "";
                                        if ($pakai_stok) {
                                            $stok_hidden = ' ';
                                        } else {
                                            $stok_hidden = ' hidden ';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <span data-bind="text: number_row"></span>
                                                <input data-bind="value:id_variant" type="hidden">
                                            </td>
                                            <td><input data-bind="value: sku" type="text" class="form-control input-sm sku-disable-handle"></td>
                                            <td> <input data-bind="value: nama_variant" class="form-control input-sm" type="text" /></td>
                                            <td>
                                                <input data-bind="value:harga" class="form-control input-sm number-header" type="text">
                                            </td>
                                            <td>
                                                <input data-bind="value:stok,hidden:id_variant()>0" class="form-control input-sm number-header <?= $stok_hidden ?>" type="text">
                                            </td>
                                            <td><a data-bind="click: $root.remove_list" class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <i class="error-message" id="variant_err"></i>
                                <i class="error-message" id="err_variants_err"></i>

                                <a class="btn btn-primary btn-xs" data-bind="click:add_variant_click" style="float: right"> <i class="fa fa-plus-circle"></i> Tambah</a>
                                <textarea style="display: none" name="variant_list_json" data-bind="value: ko.toJSON($root.variant_list)"></textarea>
                            </div>
                            <!--</div>-->
                            <!--</div>-->


                            <div class="form-group">
                            	<label for="harga"><i class="fa fa-money"></i> Harga</label>
                            	<div class="checkbox">
										  <label><input type="checkbox" value=""> Tambahkan harga sales type</label>
										</div><br>
										<div id="no-variant">
											<table class="col-md-12">
												<tr>
													<td><input type="text" name="" id="" class="form-control" placeholder="Harga" style="text-align: right;"></td>
													<td><input type="text" name="" id="" class="form-control" placeholder="SKU" style="text-align: left;"></td>
												</tr>
											</table>
											<button id="btn-add-variant" class="btn btn-primary btn-block">Tambah Variant</button>
											
										</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!--<div class="panel panel-default">-->
                            <!--<div class="panel-body same_height" >-->
                            <div class="form-group">
                                <label for=""><i class="fa fa-building" aria-hidden="true"></i> Outlet</label><br>
                                <table id="tb-outlet-list" class="table table-bordered table-condensed table-strip">
                                    <thead>
                                        <tr>
                                            <th>
                                                <?php
                                                $cb_checked = '';
                                                if ($this->uri->segment(3) == 'tambah_produk') {
                                                    $cb_checked = ' checked="true" ';
                                                }
                                                ?>
                                                <input <?= $cb_checked ?> type="checkbox" name="cb-all" id="cb-all"></th>
                                            <th>Nama Outlet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $checked_outlet = array();
                                        if (isset($outlet_checked)) {
                                            $checked_outlet = $outlet_checked;
                                        }
                                        ?>
                                        <?php foreach ($comout as $rw) : ?>
                                            <?php
                                            $checked = "";
                                            if ($this->uri->segment(3) == 'tambah_produk') {
                                                $checked = ' checked="true" ';
                                            }

                                            if (in_array($rw->idoutlet, $checked_outlet)) {
                                                $checked = ' checked="true" ';
                                            }
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" <?= $checked ?> name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>"></td>
                                                <td><?php echo $rw->name_outlet; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <i><i class="fa fa-check-square-o" aria-hidden="true"></i> Centang Outlet Anda Untuk Memasukan Produk Ke Outlet Tersebut</i>
                                <i class="error-message" id="outlet_err"></i>
                            </div>
                            <br>
                            <label for=""><i class="fa fa-fire" aria-hidden="true"></i> Modifier </label>
                            <div class="pull-right">
                                <a href="#" id="popover-modifier">
                                    <i class="fa fa-question-circle" style="color:#187FE0;font-size:20px"></i>
                                </a>

                            </div>
                            <div style="height: 200px;overflow: auto">
                                <table id="table-modifier-list" class="table table-strip">
                                    <?php
                                    $checked_modifier = array();
                                    if (isset($modifier_checked)) {
                                        $checked_modifier = $modifier_checked;
                                    }
                                    foreach ($modifier as $mod) :
                                        $checked = "";

                                        if (in_array($mod->idmodifier, $checked_modifier)) {
                                            $checked = ' checked="true" ';
                                        }
                                        ?>

                                        <tr>
                                            <td width="5%"><input type="checkbox" <?= $checked ?> name="modifier[]" value="<?= $mod->idmodifier ?>"></td>
                                            <td><?= $mod->nama_modifier ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <!-- <i><i class="fa fa-check-square-o" aria-hidden="true"></i> Centang Modifier Anda Untuk Memasukan Modifier Ke Produk Tersebut</i> -->
                            <!--</div>-->
                            <!--</div>-->
                        </div>

                        <div class="col-md-3">
                            <!--<div class="panel panel-default">-->
                            <!--<div class="panel-body">-->

                            <!-- foto produk -->
                            <div class="form-group">
                                <label><i class="fa fa-image" aria-hidden="true"></i> Foto Produk</label>
                                <div class="">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <?php
                                        $foto_produk = "";
                                        if (isset($produk[0])) {
                                            $foto_produk = $produk[0]->foto_produk;
                                        }
                                        ?>
                                        <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="<?php echo base_url(); ?>picture/produk/150/<?= $foto_produk ?>" alt="" /></div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-file btn-primary"><span class="fileupload-new"><i class="fa fa-file-image-o" aria-hidden="true"></i> Pilih Gambar</span><span class="fileupload-exists"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</span><input type="file" id="foto_produk" name="foto_produk"></span>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end foto produk -->
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                        <div class="col-md-12">
                            <!--<div class="panel panel-default">-->
                            <!--<div class="panel-body">-->
                            <div class="form-group">
                                <a href="<?php echo base_url(); ?>backoffice/produk" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                                <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                            </div>
                            <!--</div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah-kategori-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Kategori</h4>
            </div>
            <form method="post" id="form-02" class="form-horizontal" action="#">
                <div class="modal-body" style="height: 130px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: white"><i class="fa fa-object-group" aria-hidden="true"></i></span>
                                <?= form_input('kategori', '', ' class="form-control" placeholder="Nama Kategori"') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sumbit-modal" type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#table-variant-list').bind("DOMSubtreeModified", function () {
        for (let field of $('.number-header').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
            });
        }
        var skuprop = $('input[name=sku]').prop('disabled');
        if (skuprop) {
            $('#table-variant-list > tbody > tr').each(function (index) {
                $(this).find('.sku-disable-handle').prop('disabled', true);
            });
        }
    });



    $(document).ready(function () {
    	$('#btn-add-variant').click(function(e) {
    		e.preventDefault();
    		alert('add variant')
    	});



        $('#popover-modifier').popover({
            'trigger': 'hover',
            'placement': 'top',
            'content': `
                                Pilih / centang modifier. Jika modifier kosong, silahkan isi modifier terlebih dahulu. Modifier akan otomatis muncul jika modifier ada.
                        `,
        });

        $('#tambah_kategori').click(function () {
            $('#tambah-kategori-modal').modal('show');
        });


        for (let field of $('.number-header').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
            });
        }


        $('select[name=variant]').change(function () {
            if ($(this).val() == 'Ya') {
                $('#variant-list').show();
                $('#toggle_sku').prop('checked', true);
                $('input[name=sku]').prop('disabled', true);
            } else {
                $('#variant-list').hide();
                $('#toggle_sku').prop('checked', false);
                $('input[name=sku]').prop('disabled', false);
            }
        });

        $('#toggle_sku').change(function () {
            if ($(this).is(':checked')) {
                $('input[name=sku]').prop('disabled', true);
            } else {
                $('input[name=sku]').prop('disabled', false);
            }

            var skuprop = $('input[name=sku]').prop('disabled');
            if (skuprop) {
                $('#table-variant-list > tbody > tr').each(function (index) {
                    $(this).find('.sku-disable-handle').prop('disabled', true);
                });
            } else {
                $('#table-variant-list > tbody > tr').each(function (index) {
                    $(this).find('.sku-disable-handle').prop('disabled', false);
                });
            }

        });

        $('#alert-error').click(function () {
            $(this).hide();
        });

        $('#form-produk').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        // $('input[name=cb-all]').prop('checked',true)

        $('input[name=cb-all]').change(function () {
            var check_all = false;
            if ($(this).is(':checked')) {
                check_all = true;
            }

            $('#tb-outlet-list > tbody > tr > td > #outlet').each(function () {
                $(this).prop('checked', check_all);
            });

            // create_url_delete();
        });

        $('select[name=kategori]').select2({
            ajax: {
                url: '<?= base_url() ?>backoffice/produk/ajax_kategori',
                dataType: 'json',
            },
        });


        $('#form-02').submit(function (e) {
            e.preventDefault();
            $('#sumbit-modal').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...');
            $('#sumbit-modal').prop('disabled', true);


            $.ajax({
                url: "<?= base_url() ?>backoffice/produk/kategori_submit/", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) // A function to be called if request succeeds
                {
                    if (!data.status) {
                        $('#alert-error').show();
                        $('#alert-error-html').html(data.message);
                        setTimeout(function () {
                            $('#alert-error').fadeOut('slow');
                        }, 2000);
                    } else {
                        var option_html = '<option selected="selected" value="' + data.data.idkategori + '" >' + data.data.nama_kategori + '</option>';
                        $('select[name=kategori]').append(option_html).trigger('change');
                    }
                    setTimeout(function () {
                        $('#sumbit-modal').prop('disabled', false);
                        $('#sumbit-modal').html('Tambah');

                        $('#tambah-kategori-modal').modal('hide');
                    }, 200);
                    $('input[name=kategori]').val('');

                },
                error: function (err) {
//                    alert(JSON.stringify(err));
                    console.log(err);
                    $('#alert-error').show();
                    $('#alert-error-html').html("Terjadi Kesalahan Cek Koneksi");
                    setTimeout(function () {
                        $('#alert-error').fadeOut('slow');
                    }, 2000);

                    $('#sumbit-modal').prop('disabled', false);
                    $('#tambah-kategori-modal').modal('hide');
                    $('input[name=kategori]').val('');
                }
            });

        });


        $('#form-produk').submit(function (e) {
            e.preventDefault();
            $('#bsub').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...');
            $('#bsub').prop('disabled', true);

            $.ajax({
                url: "<?= base_url() ?>backoffice/produk/submit/", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) // A function to be called if request succeeds
                {
                    console.log(data);

                    write_error(data.error_arr);
                    if (!data.status) {
                        $('#alert-error').show();
                        $('#alert-error-html').html(data.message);
                        setTimeout(function () {
                            $('#alert-error').fadeOut('slow');
                        }, 5000);
                    } else {
                        window.location = '<?= base_url() ?>backoffice/produk/';
                        console.log(data);
                    }

                    setTimeout(function () {
                        $('#bsub').prop('disabled', false);
                        $('#bsub').html('Simpan');
                    }, 200);
                },
                error: function (err) {
                    $('#bsub').prop('disabled', false);
                    alert("Terjadi Kesalahan Cek Koneksi");
                    console.log(err);
                }
            });
        });


        $('#btn-sub').prop('disabled', false);
    });


    function write_error(obj) {
        Object.keys(obj).forEach(function (key) {
            $('#' + key + '_err').html(obj[key]);
            $('input[name=' + key + ']').parent().addClass('has-error');
            $('select[name=' + key + ']').parent().addClass('has-error');
        });
    }


    function pakaiVariant() {
        var e = document.getElementById("variant");
        var variant = e.options[e.selectedIndex].value;

        var hgstock = document.getElementById('hgstock');
        var sub = document.getElementById('btn-sub');

        if (variant == "Ya") {
            hgstock.style.display = "none";
        } else if (variant == "Tidak") {
            hgstock.style.display = "inline";
        } else {
            hgstock.style.display = "none";
        }
    }

    //    function validation_submit() {
    //        var nama_produk = $('input[name=nama_produk]').val();
    //        var kategori = $('select[name=kategori]').val();
    //        var variant = $('select[name=variant]').val();
    //
    //
    //        form_array = $('#form-produk').serializeArray();
    //        // console.log(form_array);
    //
    //        var i;
    //        var cb_buff = [];
    //        for (i = 0; i < form_array.length; i++) {
    //            if (form_array[i]['name'] == 'outlet[]') {
    //                cb_buff.push(form_array[i]['value']);
    //            }
    //        }
    //
    //        for (i = 0; i < form_array.length; i++) {
    //            if (form_array[i]['name'] == 'modifier[]') {
    //                cb_buff.push(form_array[i]['value']);
    //            }
    //        }
    //        // console.log(cb_buff);
    //
    //        var disabled = true;
    //        if ((nama_produk.length > 1) && (kategori != "0") && (variant != "0") && (cb_buff.length > 0)) {
    //            disabled = false;
    //        }
    //
    //        $('#btn-sub').prop('disabled', false);
    //    }
</script>
<?php require_once 'produk_add_script.php'; ?>
