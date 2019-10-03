<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Tambah Kategori</h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/kategori/insert_kategori">
                <div class="form">
                    <div class="row">
                        <span class="col-md-4">
                            <span class="form-group">
                                <label for="">Nama Kategori</label>
                                <span class="input-group">
                                    <span class="input-group-addon" style="background-color: white"><i class="icon fa fa-object-group"></i></span>
                                    <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                                </span>
                            </span>
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
                <a href="<?php echo base_url(); ?>backoffice/kategori" type="button" class="btn btn-default"><i class="icon fa fa-arrow-circle-left"></i> Kembali</a>
                <button type="submit" id="bsub" class="btn btn-primary"> <i class="icon fa fa-save"></i> Simpan</button>
        </div>
        </form>
    </div>
</div>
</div>
<?php require_once('validation_form.php') ?>