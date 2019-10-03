<div class="wrapper">
    <div class="panel-body">
        <h4>Edit Produk</h4>
        <hr/>
        <div class="form">
            <form id="form" method="POST" action="<?php echo base_url(); ?>backoffice/produk/update_produk">
                <div class="row">
                    <?php foreach ($produk as $row): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Produk</label>
                                <input type="text" name="nama_produk" value="<?php echo $row->nama_produk; ?>" class="form-control">
                                <input type="text" name="id_produk" style="display:none;" value="<?php echo $row->idproduk; ?>" readonly>
                            </div>
                            <?php $whr = array('idproduk' => $row->idproduk); ?>
                            <?php $count = $this->data_model->count_where('variant', $whr); ?>
                            <?php if ($count == '0') {
; ?>
        <?php $harg = $this->db->query("SELECT * FROM stok WHERE idproduk='$row->idproduk'")->row_array(); ?>
                                <div class="form-group">
                                    <label for="">Harga Produk</label>
                                    <input type="text" id="hgpd" name="harga_produk" value="<?php echo $harg['harga']; ?>" class="form-control number-header">
                                </div>
                                <div class="form-group">
                                    <label for="">Stock Awal Produk</label>
                                    <input type="text" id="stpd" name="stock_awal" class="form-control number-header">
                                </div>
    <?php } else {
; ?>
                                <div class="form-group" style="display:none;"> 
                                    <label for="">Harga Produk</label>
                                    <input type="text" id="hgpd" name="harga_produk" class="form-control number-header">
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label for="">Stock Awal Produk</label>
                                    <input type="text" id="stpd" name="stock_awal" class="form-control number-header">
                                </div>
    <?php }; ?>
    <?php $id_kat = $row->idkategori; ?>
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select name="kategori" id="" class="form-control">
                                    <option value="0">-- Pilih Kategori --</option>
                                    <?php foreach ($comkat as $rw): ?>
                                        <option value="<?php echo $rw->idkategori; ?>" <?php if ($rw->idkategori == $id_kat) echo 'selected="selected"'; ?>><?php echo $rw->nama_kategori; ?></option>
    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
    <?php $id_business = $this->session->userdata('id_business'); ?>
                                <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <div class="form-group">
                                <label for="">Business</label>
                                <?php foreach ($bus as $rw): ?>
                                    <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                            <?php endforeach; ?>
                            </div>
                            <?php $gg = $this->db->query("SELECT idoutlet FROM rel_produk WHERE idproduk='$row->idproduk'")->result(); ?>
                            <?php
                            foreach ($gg as $uu):
                                $idgrat[] = $uu->idoutlet;
                            endforeach;
                            ?>
                            <div class="form-group">
                                <label for="">Outlet</label><br>
    <?php foreach ($comout as $rw): ?>
                                    <input type="checkbox" name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet; ?>" <?= (in_array($rw->idoutlet, $idgrat) ? 'checked="checked"' : '') ?>> <?php echo $rw->name_outlet; ?><br>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Varian</label>
    <?php $bus = $this->db->query("SELECT * FROM variant LEFT JOIN stok ON variant.idvariant=stok.idvariant WHERE variant.idproduk = '$row->idproduk'")->result(); ?>
    <?php foreach ($bus as $rs): ?>
                                <div class="form-group">
                                    <input type="text" name="varian_law[]" value="<?php echo $rs->nama_variant; ?>" class="form-control">
                                    <input type="text" name="harga_law[]" value="<?php echo $rs->harga; ?>" class="form-control">
                                    <input type="text" style="display:none;" nama="idvar[]" value="<?php echo $rs->idvariant; ?>" readonly>
                                </div>
    <?php endforeach; ?>
                            <div class="form-group">
                                <div id="inp_varian"></div>
                            </div>
                            <button id="btn" class="btn btn-primary" type="button">Tambah Varian</button>
                        </div>
<?php endforeach; ?>
                </div>
                <hr/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function () {
        var counter = 0;
        var btn = document.getElementById('btn');
        var form = document.getElementById('inp_varian');
        var iphg = document.getElementById('hgpd');
        var addInput = function ()
        {
            counter++;
            var input = document.createElement("input");
            input.id = 'varian-' + counter;
            input.type = 'text';
            input.className = 'form-control';
            input.name = 'varian[]';
            input.placeholder = 'Varian ' + counter;
            form.appendChild(input);

            var harga = document.createElement("input");
            harga.id = 'harga-' + counter;
            harga.type = 'text';
            harga.className = 'form-control';
            harga.name = 'harga[]';
            harga.placeholder = 'Harga ' + counter;
            form.appendChild(harga);

            var stok = document.createElement("input");
            stok.id = 'stok-' + counter;
            stok.type = 'text';
            stok.className = 'form-control';
            stok.name = 'stok[]';
            stok.placeholder = 'Stok ' + counter;
            form.appendChild(stok);
        };
        btn.addEventListener('click', function ()
        {
            iphg.disabled = true;
            addInput();
        }.bind(this));
    })();

    $(document).ready(function () {
        for (let field of $('.number-header').toArray()) {
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        }
    });
</script>