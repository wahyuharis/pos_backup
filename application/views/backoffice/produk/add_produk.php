<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create Produk</h4>
        </div>
        <div class="panel-body">
             <div class="form">
                <div class="col-md-12">
                    <form id="form-produk" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/produk/insert_produk">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <input type="text" name="nama_produk" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="kategori" id="" class="form-control">
                                        <option value="0">Pilih Kategori</option>
                                        <?php foreach ($comkat as $rw): ?>
                                            <option value="<?php echo $rw->idkategori; ?>"><?php echo $rw->nama_kategori; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php $id_business = $this->session->userdata('id_business'); ?>
                                <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Business</label>
                                    <?php foreach ($bus as $row): ?>
                                        <input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <label>Foto Produk</label>
                                    <div class="">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="<?php echo base_url(); ?>picture/produk/noimage.png" alt="" /></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="foto_produk" name="foto_produk"></span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php
                                if ($this->session->userdata('type_bus') > 3) {
                                    ;
                                    ?>
                                    <div class="form-group">
                                        <label for="">Pakai Variant</label>
                                        <select name="variant" id="variant" onchange="pakaiVariant()" class="form-control">
                                            <option value="0">Pakai Variant ?</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                <?php }; ?>
                                <div class="form-group">
                                    <label for=""><h2>Pilih Outlet</h2></label><br>
                                    <label for="">Centang Outlet Anda Untuk Memasukan Produk Ke Outlet Tersebut</label><br>
                                    <table class="table table-bordered table-condensed table-strip">
                                        <thead>
                                            <tr>
                                                <th>Check</th>
                                                <th>Nama Outlet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comout as $rw): ?>
                                                <tr>

                                                    <td><input type="checkbox" name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>"></td>
                                                    <td><?php echo $rw->name_outlet; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>




                                </div>

                            </div>
                            <?php
                            if ($this->session->userdata('type_bus') > 3) {
                                ;
                                ?>
                                <div class="col-md-4" id="hgstock" style="display: none;">
                                    <div class="form-group">
                                        <label for="">Harga Produk</label>
                                        <input type="text" name="harga_produk" class="form-control number-header">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Stock Awal Produk</label>
                                        <input type="text" name="stock_awal" class="form-control number-header">
                                        <label for="">Jika anda tidak ingin menggunakan stok, isi stok awal dengan 1000</label>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ;
                                ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Harga Produk</label>
                                        <input type="text" name="harga_produk" class="form-control number-header">
                                    </div>
                                </div>
                            <?php }; ?>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <?php
                            if ($this->session->userdata('type_bus') > 3) {
                                ;
                                ?>
                                <a href="<?php echo base_url(); ?>backoffice/produk" type="button" class="btn btn-default">Back</a>
                                <button  disabled="" type="submit" id="btn-sub" class="btn btn-primary">Submit</button>
                                <?php
                            } else {
                                ;
                                ?>
                                <a href="<?php echo base_url(); ?>backoffice/produk" type="button" class="btn btn-default">Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            <?php }; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        for (let field of $('.number-header').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                
            });
        }
    });

    $('select,input').change(function () {
        validation_submit();
    });

    $('input').keyup(function () {
        validation_submit();
    });


    function pakaiVariant()
    {
        var e = document.getElementById("variant");
        var variant = e.options[e.selectedIndex].value;

        var hgstock = document.getElementById('hgstock');
        var sub = document.getElementById('btn-sub');

        if (variant == "Ya")
        {
            hgstock.style.display = "none";
        } else if (variant == "Tidak")
        {
            hgstock.style.display = "inline";
        } else
        {
            hgstock.style.display = "none";
        }
    }



    function validation_submit() {
        var nama_produk = $('input[name=nama_produk]').val();
        var kategori = $('select[name=kategori]').val();
        var variant = $('select[name=variant]').val();


        form_array = $('#form-produk').serializeArray();
        console.log(form_array);

        var i;
        var cb_buff = [];
        for (i = 0; i < form_array.length; i++) {
            if (form_array[i]['name'] == 'outlet[]') {
                cb_buff.push(form_array[i]['value']);
            }
        }
        console.log(cb_buff);

        var disabled = true;
        if ((nama_produk.length > 1) && (kategori != "0") && (variant != "0") && (cb_buff.length > 0)) {
            disabled = false;
        }

        $('#btn-sub').prop('disabled', disabled);
    }

</script>