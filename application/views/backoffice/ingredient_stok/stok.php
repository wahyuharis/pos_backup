<div class="wrapper">
    <div class="pull-right">
        <a id="export_excel" href="<?= base_url() ?>backoffice/stok/export_excel2" class="btn btn-default btn-sm">Export </a>
        <a href="<?php echo base_url(); ?>backoffice/ingredient_stok/tambah_stok" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Stock</a>
        <!-- <a href="<?php echo base_url(); ?>backoffice/stok/create_adjustment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Adjustment</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_transfer" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Transfer Order</a> -->
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-right form-inline">

                    </div>
                    <div class="clearfix"></div>
                </div> -->
                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-condensed table-strip">
                            <thead>
                                <tr>
                                	<th>#</th>
                                    <th>Nama Igredient</th>
                                    <th>Awal</th>
                                    <th>Masuk</th>
                                    <th>Pake</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $num=1; foreach ($ingredient_stok as $ings) { ?>
	                            	<tr>
	                            		<td><?= $num++; ?>.</td>
	                            		<td><?= $ings->nama_ingredient ?></td>
	                            		<td><?= $ings->awal  ?></td>
	                            		<td><?= $ings->masuk  ?></td>
	                            		<td><?= $ings->pake  ?></td>
	                            		<td><?= $ings->total  ?></td>
	                            		<td><?= $ings->tanggal  ?></td>
	                            	</tr>
                            	<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script>
	jQuery(document).ready(function($) {
		
	});
	$('#table-stok').DataTable();
</script> -->
