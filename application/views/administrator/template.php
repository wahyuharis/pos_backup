<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/logo2.PNG">
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
					<li><a href="<?php echo base_url(); ?>administrator"><i class="icon fa fa-dashboard"></i> Dashboard</a></li>
					<!-- <li><a href="<?php echo base_url(); ?>administrator/clients"><i class="icon fa fa-users"></i> Client</a></li> -->

					<!-- <li><a href="<?php echo base_url(); ?>administrator/logout"><i class="icon fa fa-sign-out"></i> Keluar</a></li> -->
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
										<img src="<?php echo base_url();?>assets/logo2.PNG" alt="" class="avatar">
										<?php echo $this->session->userdata('nama_SA'); ?><i class="caret"></i>
									</a>
									<ul class="dropdown-menu">
										<li class="profile">
											<div class="media">
												<div class="media-left media-middle">
													<img src="<?php echo base_url();?>assets/logo2.PNG" alt="" class="avatar">
												</div>
												<div class="media-body media-middle">
													<div class="name"><strong><?php echo $this->session->userdata('nama_SA'); ?></strong></div>
													<!-- <div class="job">Owner</div> -->
												</div>
											</div>
										</li>
										<!-- <li><a href="#"><i class="fa fa-user-circle-o fa-fw"></i> Profile</a></li> -->
										<li class="divider"></li>
										<li><a href="<?php echo base_url(); ?>administrator/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
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

	<?php
	if ($this->session->flashdata('message')) {
		$fdata = explode("-", $this->session->flashdata('message'));
		$message = $fdata[0];
		$id = $fdata[1];
	?>
	<div class="modal fade" id="modal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-check-circle-o fa-5x text-warning"></i>
					<br/><br/>
					<p>
						<?= $message; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>

	<div class="modal fade" id="user-dipakai">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body text-center">
					<i class="fa fa-warning fa-5x text-warning"></i>
					<br/><br/>
					<p>
						Mohon maaf email sudah dipakai, silahkan gunakan email lain.
					</p>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>assets/js/bootstrap-fileupload.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>


	<script type="text/javascript">
		$(document).ready(function () {
			$("#modal").modal('show');

			setTimeout(function () {
				$('#modal').modal('hide');
			}, 2000);
		});
	</script>

	<script>
		$(function () {
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
		}, function (start, end, label) {
			console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
		});
	</script>
</body>
</html>
