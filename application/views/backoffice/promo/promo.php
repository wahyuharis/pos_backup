<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_pro;?></a>
        <a href="<?php echo base_url();?>backoffice/promo/export" class="btn btn-success btn-sm">Export </a>
        <a id="tambah_promo" href="<?php echo base_url();?>backoffice/promo/tambah_promosi" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Promo</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman promo digunakan untuk mengelola promo, anda dapat menambahkan promo baru atau mengedit dan menghapus promo yang ada.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Buy</th>
                                    <th>Qty</th>
                                    <th>Get</th>
                                    <th>Qty</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th width="30" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach($promo as $row):?>
                                    <?php $produk_buy=$row->idproduk;?>
                                    <?php $produk_get=$row->idproduk_get;?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <?php if($produk_buy != 0){;?>
                                            <?php $pro=$this->db->query("SELECT nama_produk FROM produk WHERE idproduk = '$row->idproduk'")->row_array();?>
                                            <td><?php echo $pro['nama_produk'];?></td>
                                        <?php } else {;?>
                                            <?php $pro=$this->db->query("SELECT produk.nama_produk, variant.nama_variant FROM variant LEFT JOIN produk ON variant.idproduk=produk.idproduk WHERE variant.idvariant = '$row->idvariant'")->row_array();?>
                                            <td><?php echo $pro['nama_produk'];?> - <?php echo $pro['nama_variant'];?></td>
                                        <?php };?>
                                        <td><?php echo $row->qty;?></td>
                                        <?php if($produk_get != 0){;?>
                                            <?php $pro=$this->db->query("SELECT nama_produk FROM produk WHERE idproduk = '$row->idproduk_get'")->row_array();?>
                                            <td><?php echo $pro['nama_produk'];?></td>
                                        <?php } else {;?>
                                            <?php $pro=$this->db->query("SELECT produk.nama_produk, variant.nama_variant FROM variant LEFT JOIN produk ON variant.idproduk=produk.idproduk WHERE variant.idvariant = '$row->idvariant_get'")->row_array();?>
                                            <td><?php echo $pro['nama_produk'];?> - <?php echo $pro['nama_variant'];?></td>
                                        <?php };?>
                                        <td><?php echo $row->qty_get;?></td>
                                        <td><?php echo $row->tanggal_mulai;?></td>
                                        <td><?php echo $row->tanggal_akhir;?></td>

                                        <td class="text-nowrap">
                                            <a href="<?php echo base_url();?>backoffice/promo/edit_promo/<?php echo $row->idpromo;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idpromo;?>">Hapus</a>
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

<?php foreach($promo as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idpromo;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/promo/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Hapus Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_promo" value="<?php echo $row->idpromo;?>" style="display:none;" readonly>
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
