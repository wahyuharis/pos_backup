<div class="wrapper">
    <div class="pull-right">
        <a href="<?php echo base_url();?>owner/business/tambah_business" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Business</a>
    </div>
    <div class="row col-md-12">
        <?php foreach ($data as $row) { ?>
            <div class="col-md-4">
                <div class="thumbnail" >

                    <img src="<?= base_url() . "picture/" . $row['img_business'] ?>" alt="Lights" style="width:100%">
                    <div class="caption">
                        <b><p><?= $row['nama_business'] ?></p></b>
                        <p><?= $row['description_business'] ?></p>
                    </div>
                    <a href="<?= base_url().'owner/report/report/'.$row['idbusiness']?>" class="btn btn-primary btn-sm"><i class="fa fa-file-o"></i> Report</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>