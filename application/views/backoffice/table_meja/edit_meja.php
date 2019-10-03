<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Meja</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/table_meja/update_meja" autocomplete="off">
                <div class="form">
                    <?php foreach ($meja as $row) : ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Meja</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-table" aria-hidden="true"></i></span>
                                        <input type="text" name="no_meja" class="form-control" value="<?= $row->no_meja ?>" required>
                                        <input type="hidden" name="idtable" value="<?= $row->idtable ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Group</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-object-group" aria-hidden="true"></i></span>
                                        <select name="idgroup" id="" class="form-control">
                                            <option value="" selected>Pilih Group</option>
                                            <?php foreach ($group as $g) { ?>
                                                <option <?= $row->idgroupmeja == $g->idgroup ? 'selected' : '' ?> value="<?= $g->idgroup ?>"><?= $g->nama_group ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Outlet</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                        <select name="idoutlet" id="" class="form-control">
                                            <option value="" selected>Pilih Outlet</option>
                                            <?php foreach ($outlet as $o) { ?>
                                                <option <?= $row->idoutlet == $o->idoutlet ? 'selected' : '' ?> value="<?= $o->idoutlet ?>"><?= $o->name_outlet ?></option>
                                            <?php } ?>
                                        </select>
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
                    <?php endforeach; ?>
                    <hr />
                    <a href="<?php echo base_url(); ?>backoffice/table_meja" type="button" class="btn btn-default"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>