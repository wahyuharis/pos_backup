<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="pull-right">
                <a class="btn btn-default btn-sm">Total : <i id="total" ></i></a>
                <a href="<?= base_url() . "backoffice/produk/export_excel" ?>" class="btn btn-default btn-sm">Export </a>
                <a id="create_produk" href="<?php echo base_url(); ?>backoffice/produk/tambah_produk" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Produk</a>
            </div>
        </div>
    </div>
 
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-left">

                    </div>
                    <div class="pull-left form-inline">
                        Halaman produk digunakan untuk mengelola produk yang anda jual, untuk mengelola variant, kategori dan modifier gunakan halaman tersebut.
                        <!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".advance-search">Advance Search</button>
                    -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body form-inline collapse advance-search">
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Bisnis</option>
                    </select>
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Outlet</option>
                    </select>
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Status</option>
                    </select>
                </div>
                <div class="panel-body">
                     <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                        <thead class="bg">
                            <?php if($this->session->userdata('type_bus') > 3){;?>
                            <tr>
                                <th width="10">No</th>
                                <th>Nama Produk</th>
                                <th>Varian</th>
                                <th>Status</th>
                                <th width="30" class="text-center">Action</th>
                            </tr>
                        <?php } else {;?>
                            <tr>
                                <th width="10">No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th width="30" class="text-center">Action</th>
                            </tr>
                        <?php };?>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            <?php foreach($produk as $row):?>
                            <?php if($this->session->userdata('type_bus') > 3){;?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $row->nama_produk;?></td>
                                <?php $whp=array('idproduk'=>$row->idproduk,'status'=>1);?>
                                <?php $count=$this->data_model->count_where('variant',$whp);?>
                                <td><?php echo $count;?> Varian</td>
                                <td><div class="label label-primary">ACTIVE</div></td>
                                <td class="text-nowrap">
                                    <a href="<?php echo base_url();?>backoffice/produk/edit_produk/<?php echo $row->idproduk;?>" class="btn btn-default btn-xs">Edit</a>
                                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idproduk;?>">Delete</a>
                                </td>
                            </tr>
                        <?php } else {;?>
                            <tr>
                                <td><?php echo $no;?></td>
                                <td><?php echo $row->nama_produk;?></td>

                                <td>
                                    <?php $query = $this->db->query("SELECT nama_kategori FROM kategori WHERE idkategori='$row->idkategori'");?>
                                    <?php foreach ($query->result_array() as $rw) echo $rw['nama_kategori'];?>
                                </td>
                                <td>Rp. <?php echo $row->harga;?></td>
                                <td class="text-nowrap"> 
                                    <a href="<?php echo base_url();?>backoffice/produk/edit_produk/<?php echo $row->idproduk;?>" class="btn btn-default btn-xs">Edit</a>
                                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idproduk;?>">Delete</a>
                                </td>
                            </tr>
                        <?php };?>
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

<?php foreach($produk as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idproduk;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/produk/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_produk" value="<?php echo $row->idproduk;?>" style="display:none;" readonly>
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