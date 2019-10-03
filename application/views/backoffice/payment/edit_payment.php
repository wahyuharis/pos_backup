<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Create Payment</h4>
        <hr/>
        <div class="form">
            <form method="POST" action="<?php echo base_url(); ?>backoffice/payment_setup/update_payment">
                <div class="row">
                    <?php foreach ($payment as $row) : ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama_payment" value="<?php echo $row->nama_pay; ?>" class="form-control" required>
                                <input type="text" name="id_pay" style="display: none;" value="<?php echo $row->idpay; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">No Rekening</label>
                                <input type="text" name="norek" value="<?php echo $row->norek_pay; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Holder</label>
                                <input type="text" name="holder" value="<?php echo $row->holdername_pay; ?>" class="form-control" required>
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
                <a href="<?php echo base_url(); ?>backoffice/payment_setup" type="button" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </form>
    </div>
</div>
</div>
-->

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Payment</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/payment_setup/update_payment">
                <div class="form">
                    <?php foreach ($payment as $row) : ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Payment</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-university" aria-hidden="true"></i></span>
                                        <input type="text" name="nama_payment" value="<?php echo $row->nama_pay; ?>" class="form-control" required>
                                        <input type="text" name="id_pay" style="display: none;" value="<?php echo $row->idpay; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">No Rekening</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                                        <input type="text" name="norek" value="<?php echo $row->norek_pay; ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Holder</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                                        <input type="text" name="holder" value="<?php echo $row->holdername_pay; ?>" class="form-control" required>
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
                        </div>
                    <?php endforeach; ?>
                    <hr />
                    <a href="<?php echo base_url(); ?>backoffice/payment_setup" type="button" class="btn btn-default"><i class="fa fa-arrows-circle-left" aria-hidden="true"></i> Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>