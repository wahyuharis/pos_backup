<style>
    .thumbnail .caption {
        height: 110px;
    }
</style>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="pull-right">
                        <a href="<?php echo base_url(); ?>owner/business/tambah_business" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Bisnis</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <?php foreach ($data as $row) : ?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="<?php echo base_url(); ?>picture/150/<?php echo $row->img_business; ?>" alt="Lights" style="width:100%">
                    <div class="caption">
                        <b>
                            <p><?php echo $row->nama_business; ?></p>
                        </b>
                        <p><?php echo substr($row->description_business, 0, 100); ?>...</p>
                    </div>
                    <a href="<?php echo base_url(); ?>owner/business/edit/<?php echo $row->idbusiness; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit Bisnis</a>
                    <a href="<?php echo base_url(); ?>owner/dashboard/backoffice/<?php echo $row->idbusiness; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-circle-right"></i> Go To Dashboard</a>
                    <a href="<?php echo base_url(); ?>owner/report/report/<?php echo $row->idbusiness; ?>" class="btn btn-primary btn-sm"><i class="fa fa-file"></i> Report</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>