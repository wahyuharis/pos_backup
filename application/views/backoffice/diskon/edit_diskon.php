<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Edit Diskon</h4>
        </div>
    </div>

    <div class="form">
        <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backoffice/diskon/update_diskon" autocomplete="off">
            <div class="row">
                <?php foreach($diskon as $row);?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height" >
                            <center><h4>Produk Atau Variant Yg Anda Jadikan Promo</h4></center><br>
                            <?php if($row->idproduk != 0){;?>
                                <?php $pro=$this->db->query("SELECT nama_produk FROM produk WHERE idproduk = '$row->idproduk'")->row_array();?>
                                <div class="form-group">
                                    <label for="">Produk</label>
                                    <input type="text" value="<?php echo $pro['nama_produk'];?>" class="form-control" readonly>
                                </div>
                            <?php } else {;?>
                                <?php $pro=$this->db->query("SELECT produk.nama_produk, variant.nama_variant FROM variant LEFT JOIN produk ON variant.idproduk=produk.idproduk WHERE variant.idvariant = '$row->idvariant'")->row_array();?>
                                <div class="form-group">
                                    <label for="">Variant</label>
                                    <input type="text" value="<?php echo $pro['nama_produk'];?> - <?php echo $pro['nama_variant'];?>" class="form-control" readonly>
                                </div>
                            <?php };?>
                            <input type="text" style="display:none;" name="iddiskon" value="<?php echo $row->iddiskon;?>" class="form-control" readonly>
                            <div class="form-group">
                                <label for="">Diskon</label>
                                <input type="text" name="diskon" value="<?php echo $row->diskon;?>" class="form-control number-header">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height" >
                            <center><h4>Pilih Tanggal Mulai Dan Akhir Promo</h4></center><br>
                            <div class="form-group">
                                <label for="">Tanggal Mulai</label>
                                <input name="tgl_mulai" type="date" value="<?php echo $row->tgl_mulai;?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Akhir</label>
                                <input name="tgl_akhir" type="date" value="<?php echo $row->tgl_akhir;?>" class="form-control">
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
                                <a href="<?php echo base_url(); ?>backoffice/diskon" type="button" class="btn btn-default">Kembali</a>
                                <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        $("input[name='diskon']").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });
</script>