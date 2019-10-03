<div class="wrapper">
   <div class="pull-right">
       <a class="btn btn-default btn-sm">Total : <?= $count ?></a>
       <a href="<?php echo base_url(); ?>backoffice/outlet/export" class="btn btn-success btn-sm">Export </a>
   </div>
   <div class="clearfix"></div>
    <br/>
	<div class="row row-xs">
		<div class="col-md-12">
			<div class="panel panel-info">
	      	<div class="panel-body">
	      		<div class="table-responsive">
	      			<table class="table table-striped" id="example1">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Email</th>
									<th>Telepon</th>
									<th>Terakhir Login</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$no=1;
								foreach ($clients as $c) { ?>
									<tr>
										<th><?= $no++ ?>.</th>
										<th><?= $c->nama_user ?></th>
										<th><?= $c->email_user ?></th>
										<th><?= $c->telp_user ?></th>
										<th><?= $c->last_loggin ?></th>
									</tr>
								<? } ?>
							</tbody>
	      			</table>
	      		</div>
	      	</div>
	      </div>
		</div>
		
	</div>

</div>