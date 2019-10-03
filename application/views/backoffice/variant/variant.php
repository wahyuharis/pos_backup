<?php
$tanggal = time();
$waktu = "Y-m-d";
$sekarang = date($waktu, $tanggal);?>

<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_var;?></a>
        <a href="<?php echo base_url();?>backoffice/variant/export" class="btn btn-default btn-sm">Export </a>
        <a href="<?php echo base_url();?>backoffice/variant/tambah_variant" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Variant</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-left">
                        Halaman variant digunakan untuk mengelola variant produk anda, variant produk anda memiliki harga yang terpisah, mohon tentukan produk mana yang memiliki variant atau tidak pada saat anda memasukan produk baru.<br>
                    </div>
                    <div class="pull-right form-inline">
                        <!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Variant</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th width="30" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach($variant as $row):?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row->nama_variant;?></td>
                                        <?php $query = $this->db->query("SELECT nama_produk FROM produk WHERE idproduk='$row->idproduk'");?>
                                        <?php foreach ($query->result_array() as $rw) $nam_prod=$rw['nama_produk'];?>
                                        <td><?php echo $nam_prod;?></td>
                                        <?php $query = $this->db->query("SELECT harga FROM stok WHERE tanggal=(SELECT MAX(tanggal) FROM stok WHERE idvariant = '$row->idvariant') AND idvariant='$row->idvariant'");?>
                                        <?php foreach ($query->result_array() as $rw) $harga=$rw['harga'];?>
                                        <td>Rp. <?php echo $harga;?></td>
                                        <td class="text-nowrap"> 
                                            <a href="<?php echo base_url();?>backoffice/variant/edit_variant/<?php echo $row->idvariant;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idvariant;?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $no++;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php foreach($variant as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idvariant;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/variant/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_variant" value="<?php echo $row->idvariant;?>" style="display:none;" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach;?>