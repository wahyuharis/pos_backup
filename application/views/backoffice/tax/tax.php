<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_tax;?></a>
        <a href="<?php echo base_url();?>backoffice/tax/export" class="btn btn-success btn-sm">Export </a>
        <a href="<?php echo base_url();?>backoffice/tax/tambah_tax" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pajak</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <p>Pada halaman pajak anda dapat mengatur pajak yang anda kenakan kepada pembeli, anda dapat mengatur pajak untuk setiap outlet & dapat mengaktifkan pada aplikasi kasir.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
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
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Outlet</th>
                                    <th>Status</th>
                                    <th width="30" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                <?php foreach($tax as $row):?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $row->nama_tax;?></td>
                                        <td><?php echo $row->besaran_tax;?> %</td>
                                        <td>
                                            <?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'");?>
                                            <?php foreach ($query->result_array() as $rw) echo $rw['name_outlet'];?>
                                        </td>
                                        <td><div class="label label-primary">ACTIVE</div></td>
                                        <td class="text-nowrap">
                                            <?php $new=$this->encrypt->encode($row->idtax);?> 
                                            <a href="<?php echo base_url();?>backoffice/tax/edit_tax/<?php echo $new;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idtax;?>">Hapus</a>
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

<?php foreach($tax as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->idtax;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/tax/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_tax" value="<?php echo $row->idtax;?>" style="display:none;" readonly>
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