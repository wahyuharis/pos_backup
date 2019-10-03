<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Group</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/table_group/insert_group" autocomplete="off">
                <div class="form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Group</label>
                                <div class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="fa fa-university" aria-hidden="true"></i></span>
                                    <input type="text" name="nama_group" class="form-control" placeholder="Group" required>
                                </div>
                            </div>
                            <?php $id_business = $this->session->userdata('id_business'); ?>
                            <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <div class="form-group">
                                <label for="">Bisnis</label>
                                <?php foreach ($bus as $row) : ?>
                                    <input type="text" class="form-control" value="<?php echo $row->nama_business; ?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness; ?>" readonly>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                    <hr />
                    <a href="<?php echo base_url(); ?>backoffice/table_group" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>