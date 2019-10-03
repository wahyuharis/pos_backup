<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?= $isi ?></h4>
        </div>
        <div class="panel-body">
            <form method="POST" id="validationForm" action="<?php echo base_url(); ?>backoffice/ingredient_kategori/edit_kategori" autocomplete="off">
                <div class="form">
                    <?php foreach ($kategori as $row): ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" value="<?php echo $row->nama_kategori; ?>" class="form-control" required>
                                    <input type="text" name="id" value="<?php echo $row->idkatingredient; ?>" style="display:none;" readonly>
                                </div>
                                <?php $id_business = $this->session->userdata('id_business'); ?>
                                <?php $bus = $this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result(); ?>
                                <div class="form-group">
                                    <label for="">Business</label>
                                    <?php foreach ($bus as $rw): ?>
                                        <input type="text" class="form-control" value="<?php echo $rw->nama_business; ?>" readonly>
                                        <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $rw->idbusiness; ?>" readonly>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                    <hr/>
                    <a href="<?php echo base_url(); ?>backoffice/kategori" type="button" class="btn btn-default">Kembali</a>
                    <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once('validation_form.php') ?>
