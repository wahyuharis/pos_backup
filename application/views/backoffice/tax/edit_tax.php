<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Create Pajak</h4>
        <hr/>
        <div class="form">
            <form method="POST" action="<?php echo base_url(); ?>backoffice/tax/update_tax">
                <div class="row">
                    <?php foreach ($tax as $row) : ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Pajak</label>
                                <input type="text" name="nama_tax" value="<?php echo $row->nama_tax; ?>" class="form-control" required>
                                <input type="text" style="display: none;" name="id_tax" value="<?php echo $row->idtax; ?>" readonly;?>
                            </div>
                            <div class="form-group">
                                <label for="">Besaran</label>
                                <input type="text" name="besaran_tax" value="<?php echo $row->besaran_tax; ?>" class="form-control" placeholder="%" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php $id_business = $this->session->userdata('id_business'); ?>
                            <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                            <div class="form-group">
                                <label for="">Business</label>
                                <?php foreach ($bus as $rw) : ?>
                                    <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                                <?php endforeach; ?>
                            </div>
                            <?php $out = $row->idoutlet; ?>
                            <div class="form-group">
                                <label for="">Outlet</label>
                                <select name="outlet" id="" class="form-control">
                                    <option value="0">-- Pilih Outlet --</option>
                                    <?php foreach ($comout as $rw) : ?>
                                        <option value="<?php echo $rw->idoutlet; ?>" <?php if ($rw->idoutlet == $out) echo 'selected="selected"'; ?>>
                                            <?php echo $rw->name_outlet; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr/>
                <a href="<?php echo base_url(); ?>backoffice/tax" type="button" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
-->

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Pajak</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/tax/update_tax" autocomplete="off">
                <div class="form">
                    <div class="row">
                        <?php foreach ($tax as $row) : ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Pajak</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-tags" aria-hidden="true"></i></span>
                                        <input type="text" name="nama_tax" value="<?php echo $row->nama_tax; ?>" class="form-control" required>
                                        <input type="text" style="display: none;" name="id_tax" value="<?php echo $row->idtax; ?>" readonly;?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Besaran</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-percent" aria-hidden="true"></i></span>
                                        <input type="text" name="besaran_tax" value="<?php echo $row->besaran_tax; ?>" class="form-control" placeholder="%" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php $id_business = $this->session->userdata('id_business'); ?>
                                <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Bisnis</label>
                                    <?php foreach ($bus as $rw) : ?>
                                        <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                                    <?php endforeach; ?>
                                </div>
                                <?php $out = $row->idoutlet; ?>
                                <div class="form-group">
                                    <label for="">Outlet</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                        <select name="outlet" id="" class="form-control">
                                            <option value="">-- Pilih Outlet --</option>
                                            <?php foreach ($comout as $rw) : ?>
                                                <option value="<?php echo $rw->idoutlet; ?>" <?php if ($rw->idoutlet == $out) echo 'selected="selected"'; ?>>
                                                    <?php echo $rw->name_outlet; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr />
                    <a href="<?php echo base_url(); ?>backoffice/tax" type="button" class="btn btn-default"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>