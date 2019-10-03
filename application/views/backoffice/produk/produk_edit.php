<?php
$tanggal = time();
$waktu = "Y-m-d";
$sekarang = date($waktu, $tanggal);
?>
<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create Produk</h4>
        </div>

        <div class="panel-body">
                <div class="form">
                <form id="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/produk/update_produk">
                    <div class="row">
<?php foreach ($produk as $row): ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <input type="text" name="nama_produk" value="<?php echo $row->nama_produk; ?>" class="form-control" required>
                                    <input type="text" name="id_produk" value="<?php echo $row->idproduk; ?>" style="display:none;" readonly>
                                    <input type="text" name="variant" value="<?php echo $row->variant; ?>" style="display:none;" readonly>
                                </div>
    <?php $id_kat = $row->idkategori; ?>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="kategori" id="" class="form-control">
                                        <option value="0">Pilih Kategori</option>
                                        <?php foreach ($comkat as $rw): ?>
                                            <option value="<?php echo $rw->idkategori; ?>" <?php if ($rw->idkategori == $id_kat) echo 'selected="selected"'; ?>><?php echo $rw->nama_kategori; ?></option>
    <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php $id_business = $this->session->userdata('id_business'); ?>
    <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Business</label>
    <?php foreach ($bus as $rw): ?>
                                        <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <label>Foto Produk</label>
                                    <div class="">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="<?php echo base_url(); ?>picture/produk/150/<?php echo $row->foto_produk; ?>" alt="" /></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="width: 150px; height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="foto_produk" name="foto_produk"></span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $gg = $this->db->query("SELECT idoutlet FROM rel_produk WHERE idproduk='$row->idproduk'")->result(); ?>
                            <?php
                            foreach ($gg as $uu):
                                $idgrat[] = $uu->idoutlet;
                            endforeach;
                            ?>
                            <div class="col-md-4">
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
                                            <?php
                                            $checked="";
                                            if(isset($idgrat)){
                                                if(in_array($rw->idoutlet, $idgrat)){
                                                    $checked=' checked="checked" ';
                                                }
                                            }
                                            ?>
                                                <tr>
                                                    <td><input type="checkbox" name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>" <?=$checked ?>></td>
                                                    <td><?php echo $rw->name_outlet; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if ($this->session->userdata('type_bus') > 3) {
; ?>
        <?php $var = $row->variant; ?>
        <?php if ($var == "1") {
; ?>
            <?php $bus = $this->db->query("SELECT harga FROM stok WHERE idproduk = '$row->idproduk' AND tanggal = '$sekarang'")->row_array(); ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Harga Produk</label>
                                            <input type="text" name="harga_produk" value="<?php echo $bus['harga']; ?>" class="form-control number-header" required>
                                        </div>
                                    </div>
        <?php }; ?>
    <?php } else {
; ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Harga Produk</label>
                                        <input type="text" name="harga_prod" value="<?php echo $row->harga; ?>" class="form-control number-header" required>
                                    </div>
                                </div>
    <?php }; ?>
<?php endforeach; ?>
                    </div>
                    <hr/>
                    <a href="<?php echo base_url(); ?>backoffice/produk" type="button" class="btn btn-default">Back</a>
                    <button type="submit" id="btn-sub" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        for (let field of $('.number-header').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        }
    });
</script>