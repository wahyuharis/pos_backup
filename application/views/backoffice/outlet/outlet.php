<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_out; ?></a>
        <a href="<?php echo base_url(); ?>backoffice/outlet/export" class="btn btn-success btn-sm">Export </a>
        <!--<a href="#" class="btn btn-danger btn-sm"> Batas Maksimum Outlet Sudah Tercapai</a>-->
        <a href="<?php echo base_url(); ?>backoffice/outlet/tambah_outlet" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Outlet</a>
    </div>
	<div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p>Halaman outlet digunakan untuk melihat data outlet yang anda miliki, perhatian maksimal jumlah outlet yang diperbolehkan adalah 5.</p>
                </div>
            </div>
            <div class="panel panel-default">
                <!-- <div class="panel-heading" style="overflow: visible;">
                    <div class="clearfix"></div>
                </div> -->
                <div class="panel-body"> 
                    <div class="table-responsive">
                        <table id="example4" class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Outlet</th>
                                    <th>Alamat Outlet</th>
                                    <th>Kabupaten</th>
                                    <th>No Telp</th>
                                    <th>Status</th>
                                    <th width="30" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($outlet as $row): ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row->name_outlet; ?></td>
                                        <td><?php echo $row->alamat_outlet; ?></td>
                                        <td>
                                            <?php $query = $this->db->query("SELECT name FROM tb_regencies WHERE id='$row->regencies_id'"); ?>
                                            <?php
                                            foreach ($query->result_array() as $rw)
                                                echo $rw['name'];
                                            ?>
                                        </td>
                                        <td><?php echo $row->telp_outlet; ?></td>
                                        <td><div class="label label-primary">ACTIVE</div></td>
                                        <td class="text-nowrap">
    <?php $new = $this->encrypt->encode($row->idoutlet); ?> 
                                            <a href="<?php echo base_url(); ?>backoffice/outlet/edit_outlet/<?php echo $row->idoutlet; ?>" class="btn btn-default btn-xs">Edit</a>
                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idoutlet; ?>">Hapus</a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
<?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php foreach ($outlet as $row): ?>
    <div class="modal fade" id="modal-delete<?php echo $row->idoutlet; ?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url(); ?>backoffice/outlet/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Hapus Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="id_outlet" value="<?php echo $row->idoutlet; ?>" style="display:none;" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
