<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Group</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/table_group/update_group">
                <div class="form">
                    <?php foreach ($group as $row) : ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Group</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-object-group" aria-hidden="true"></i></span>
                                        <input type="text" name="nama_group" value="<?php echo $row->nama_group; ?>" class="form-control" required>
                                        <input type="text" name="id_group" value="<?php echo $row->idgroup; ?>" style="display:none;" readonly>
                                    </div>
                                </div>
                                <?php $id_business = $this->session->userdata('id_business'); ?>
                                <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Bisnis</label>
                                    <?php foreach ($bus as $rw) : ?>
                                        <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr />
                    <a href="<?php echo base_url(); ?>backoffice/table_group" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>