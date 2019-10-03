<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Create Tip</h4>
        <hr/>
        <div class="form">
            <form method="POST" action="<?php echo base_url();?>backoffice/tip/insert_tip">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Tip</label>
                            <input type="text" name="nama_tip" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Besaran</label>
                            <input type="text" name="besaran" class="form-control" placeholder="%" required>
                        </div>
                        <div class="form-group">
                            <?php $id_business=$this->session->userdata('id_business');?>
                            <?php $bus=$this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result();?>
                            <div class="form-group">
                                <label for="">Business</label>
                                <?php foreach ($bus as $row):?>
                                    <input type="text" class="form-control" value="<?php echo $row->nama_business;?>" readonly>
                                    <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness;?>" readonly>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <a href="<?php echo base_url();?>backoffice/tip" type="button" class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</div>
-->

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Tip</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url();?>backoffice/tip/insert_tip" autocomplete="off">
                <div class="form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Tip</label>
                                <input type="text" name="nama_tip" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Besaran</label>
                                <input type="text" name="besaran" class="form-control" placeholder="%" required>
                            </div>
                            <div class="form-group">
                                <?php $id_business=$this->session->userdata('id_business');?>
                                <?php $bus=$this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result();?>
                                <div class="form-group">
                                    <label for="">Business</label>
                                    <?php foreach ($bus as $row):?>
                                        <input type="text" class="form-control" value="<?php echo $row->nama_business;?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness;?>" readonly>
                                    <?php endforeach;?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr/>
                    <a href="<?php echo base_url(); ?>backoffice/tip" type="button" class="btn btn-default">Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('validation_form.php') ?>