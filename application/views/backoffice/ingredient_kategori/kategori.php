<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?= $jum_kat; ?></a>
        <a href="<?php echo base_url();?>backoffice/ingredient_kategori/export" class="btn btn-success btn-sm">Export </a>
        <a id="tambah_kategori" href="<?php echo base_url();?>backoffice/ingredient_kategori/tambah_kategori" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Kategori Ingredient</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman kategori digunakan untuk mengelola kategori ingredient, kategori akan dipilih saat anda memasukan atau mengedit ingredient.</p>
                </div>
            </div>
            <div class="panel panel-default">
<!--                <div class="panel-heading" style="d;">
                    <div class="clearfix"></div>
                </div>-->
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Kategori</th>
                                    <th width="30" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach($kategori as $row):?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row->nama_kategori;?></td>
                                        <td class="text-nowrap"> 
                                            <a href="<?php echo base_url();?>backoffice/ingredient_kategori/edit_kategori/<?php echo $row->idkatingredient;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idkatingredient;?>">Hapus</a>
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

<?php foreach($kategori as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idkatingredient;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/ingredient_kategori/hapus_kategori">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id" value="<?php echo $row->idkatingredient;?>" style="display:none;" readonly>
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
