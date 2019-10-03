<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_group;?></a>
        <a href="<?php echo base_url();?>backoffice/table_group/export" class="btn btn-success btn-sm">Export </a>
        <a id="tambah_kategori" href="<?php echo base_url();?>backoffice/table_group/tambah_group" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Group</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman group digunakan untuk mengelola group meja anda, grup akan dipilih saat anda memasukan atau mengedit meja.</p>
                </div>
            </div>
            <div class="panel panel-default">
<!--                <div class="panel-heading" style="d;">
                    <div class="clearfix"></div>
                </div>-->
                <div class="panel-body" >
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Grup</th>
                                    <th width="30" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach($group as $row):?>
                                    <tr>
                                        <td><?php echo $no;?>.</td>
                                        <td><?php echo $row->nama_group;?></td>
                                        <td class="text-nowrap"> 
                                            <a href="<?php echo base_url();?>backoffice/table_group/edit_group/<?php echo $row->idgroup;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idgroup;?>">Hapus</a>
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

<?php foreach($group as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idgroup;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/table_group/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Hapus Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_group" value="<?php echo $row->idgroup;?>" style="display:none;" readonly>
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
