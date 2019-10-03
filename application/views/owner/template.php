<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/logo2.PNG">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
	<title>AIO POS</title>

	<!-- CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/app.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-fileupload.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css">


	<!-- JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body class="loading">
	<div id="app">
		<div id="sidebar" class="collapse in">
			<div class="widget widget-logo">AIO POS</div>
			<div class="widget widget-nav">
				<ul class="nav">
					<li class="heading">NAVIGATION</li>
					<li><a href="<?php echo base_url(); ?>owner/business"><i class="icon fa fa-id-card"></i> Bisnis</a></li>
					<li><a href="<?php echo base_url(); ?>owner/profile"><i class="icon fa fa-user-circle-o"></i> Profile</a></li>
					<!--<li><a href="<?php echo base_url(); ?>owner/report"><i class="icon fa fa-building"></i> Report</a></li>-->

					<!--
                        <li><a href="<?php echo base_url(); ?>backoffice/dashboard"><i class="icon fa fa-building"></i> Dashboard</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/report"><i class="icon fa fa-building"></i> Report</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/user"><i class="icon fa fa-user-circle-o"></i> Karyawan</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/bisnis"><i class="icon fa fa-id-card"></i> Bisnis</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/outlet"><i class="icon fa fa-building"></i> Outlet</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/customer"><i class="icon fa fa-group"></i> Customer</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/produk"><i class="icon fa fa-list"></i> Produk</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/variant"><i class="icon fa fa-list"></i> Variant</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/kategori"><i class="icon fa fa-list"></i> Kategori</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/modifier"><i class="icon fa fa-list"></i> Modifier</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/stok"><i class="icon fa fa-list"></i> Stok</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/payment_setup"><i class="icon fa fa-money"></i> Payment Setup</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/tip"><i class="icon fa fa-ticket"></i> Tip</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/tax"><i class="icon fa fa-tags"></i> Pajak</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/cashopname"><i class="icon fa fa-shopping-basket"></i> Cashopname</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/sales_type"><i class="icon fa fa-male"></i> Sales Type</a></li>
                        <li><a href="<?php echo base_url(); ?>backoffice/transaksi"><i class="icon fa fa-calculator"></i> Transaksi</a></li>
                        <li class="divider"></li>
                    -->

					<li><a href="<?php echo base_url(); ?>owner/home/logout"><i class="icon fa fa-sign-out"></i> Keluar</a></li>
				</ul>
			</div>
		</div>
		<div id="main">
			<div id="navbar">
				<nav class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
						<div class="navbar-header">
							<button class="btn navbar-btn navbar-left" data-toggle="collapse" data-target="#sidebar" type="button"><i class="fa fa-bars"></i></button>
							<a style="margin-left:10px;" href="#" class="navbar-brand"><?php echo $judul; ?></a>
						</div>
						<div class="collapse navbar-collapse navigation">
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown dropdown-user">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img src="<?php echo base_url(); ?>assets/logo2.PNG" alt="" class="avatar">
										<?php echo $this->session->userdata('nama_user'); ?> <i class="caret"></i>
									</a>
									<ul class="dropdown-menu">
										<li class="profile">
											<div class="media">
												<div class="media-left media-middle">
													<img src="<?php echo base_url(); ?>assets/logo2.PNG" alt="" class="avatar">
												</div>
												<div class="media-body media-middle">
													<div class="name"><strong><?php echo $this->session->userdata('nama_user'); ?></strong></div>
													<div class="job">Owner</div>
												</div>
											</div>
										</li>
										<!-- <li><a href="#"><i class="fa fa-user-circle-o fa-fw"></i> Profile</a></li>
                                        <li class="divider"></li> -->
										<li><a href="<?php echo base_url(); ?>owner/home/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div style="width: 100%;height: 100%;overflow: scroll;">
				<?php echo $content; ?>
			</div>
		</div>
	</div>

	<?php $message = $this->session->flashdata('message'); ?>
	<div class="modal fade" id="modal-success">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-check-circle-o fa-5x text-warning"></i>
					<br /><br />
					<p>
						Data Berhasil Disimpan
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="user-dipakai">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-warning fa-5x text-warning"></i>
					<br /><br />
					<p>
						Mohon maaf email sudah dipakai, silahkan gunakan email lain.
					</p>
				</div>
			</div>
		</div>
	</div>

	<!-- modal flashdata -->
	<?php if ($this->session->flashdata('pesan')) { ?>

		<div class="modal fade" id="modal-flashdata">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body text-center">
						<i class="fa fa-check-circle-o fa-5x text-warning"></i>
						<br /><br />
						<p>
							<?= $this->session->flashdata('pesan') ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	<?php }  ?>

	<script src="<?php echo base_url(); ?>assets/js/bootstrap-fileupload.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>


	<script type="text/javascript">
		$(document).ready(function() {
			$("#<?php echo $message; ?>").modal('show');

			setTimeout(function() {
				$('#<?php echo $message; ?>').modal('hide');
			}, 2000);
		});


		$("#modal-flashdata").modal('show');

		setTimeout(function() {
			$('#modal-flashdata').modal('hide');
		}, 2000);
	</script>

	<script>
		$(function() {
			$('#example1').DataTable()
			$('#example2').DataTable({
				'paging': true,
				'lengthChange': false,
				'searching': true,
				'ordering': true,
				'info': false,
				'autoWidth': false
			})
		})
	</script>

	<script type="text/javascript">
		$('#daterange').daterangepicker({
			"autoApply": true,
			"dateFormat": 'dd-mm-yyyy',
			"ranges": {
				"Today": [moment(), moment()],
				"Yesterday": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				"Last 7 Days": [moment().subtract(6, 'days'), moment()],
				"Last 30 Days": [moment().subtract(29, 'days'), moment()],
				"This Month": [moment().startOf('month'), moment().endOf('month')],
				"Last Month": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			"alwaysShowCalendars": true,
			"startDate": moment().subtract(6, 'days'),
			"endDate": moment()
		}, function(start, end, label) {
			console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
		});
	</script>
</body>

</html>