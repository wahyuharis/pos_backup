<div class="wrapper">
   
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm">Total : <?php echo $jum_tot; ?></a>
                        <a href="<?php echo base_url(); ?>backoffice/user/export" class="btn btn-success btn-sm">Export </a>
                        <a href="<?php echo base_url(); ?>backoffice/user/tambah_user" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Karyawan</a>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info">
                    Halaman karyawan digunakan untuk melihat data karyawan yang anda miliki, anda dapat menambahkan karyawan mulai dari backofficer, dan kasir.
            </div>
            
            
            <div class="panel panel-default">
<!--                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-right form-inline">
                    </div>
                    <div class="clearfix"></div>
                </div>-->
                <div class="panel panel-body">
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                        <thead class="bg">
                            <tr>
                                <th width="10">No</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Nama Outlet</th>
                                <th>Role</th>
                                <th>No Telp</th>
                                <th width="30" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            <?php foreach($karyawan as $row):?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $row->email_user;?></td>
                                    <td><?php echo $row->nama_user;?></td>
                                    <td>
                                        <?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'");?>
                                        <?php foreach ($query->result_array() as $rw) echo $rw['name_outlet'];?>
                                    </td>
                                    <?php $role=$row->role_user;?>
                                    <td>
                                        <?php if($role == 1)
                                        {
                                            echo "Manajer";
                                        }
                                        elseif ($role == 2)
                                        {
                                            echo "Back Officer";
                                        }
                                        else
                                        {
                                            echo "Kasir";
                                        };?>
                                    </td>
                                    <td><?php echo $row->telp_user;?></td>
                                    <td class="text-nowrap">
                                        <?php if($role != 1){;?>
                                            <a href="<?php echo base_url();?>backoffice/user/edit_karyawan/<?php echo $row->iduser;?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->iduser;?>">Delete</a>
                                        <?php }else {;?> - <?php };?>
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

<?php foreach($karyawan as $row):?>
    <div class="modal fade" id="modal-delete<?php echo $row->iduser;?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url();?>backoffice/user/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_user" value="<?php echo $row->iduser;?>" style="display:none;" readonly>
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