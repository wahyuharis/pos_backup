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
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/receipt.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="<?= base_url() ?>assets/css/sidebar.css" rel="stylesheet" type="text/css" />
	<!--<link href="https://fonts.googleapis.com/css?family=News+Cycle&display=swap" rel="stylesheet">-->
	<!--<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">-->

	<style type="text/css">
		.accordion {
			background: none;
			color: #fff;
			cursor: pointer;
			padding: 10px;
			padding-left: 22px;
			width: 100%;
			text-align: left;
			border: none;
			outline: none;
			transition: 0.4s;
		}

		.accordion i {
			margin-right: 20px;
		}

		.active,
		.accordion:hover {
			background-color: rgba(255, 255, 255, 0.1);
		}

		.menu {
			padding: 0 18px;
			background-color: transparent;
			display: none;
			overflow: hidden;
		}

		.dataTables_processing {
			background-color: #000 !important;
			color: #fff;
			opacity: 0.4;
		}

		.accordion>.caret {
			position: absolute;
			right: 5px;
			top: 20px;
		}

		.daterangepicker .ranges li:hover {
			background-color: #08c;
		}

		/*        body{
									font-family: 'Ubuntu', sans-serif;
							}*/
	</style>

	<?php
	if (isset($css_files)) {
		foreach ($css_files as $css_url) {
			echo '<link rel="stylesheet" type="text/css" href="' . $css_url . '">';
		}
	}
	?>


	<!-- JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<?php
	if (isset($js_files)) {
		foreach ($js_files as $js_url) {
			echo '<script src="' . $js_url . '"></script>';
		}
	}
	?>
</head>

<body class="loading">
	<div id="app">
		<div id="sidebar" class="collapse in">
			<div class="widget widget-logo">AIO POS</div>
			<div class="widget widget-nav">
 
				<ul class="nav">
					<li class="heading">NAVIGATION</li>
					<li><a class="<?php if ($this->uri->segment(2) == 'dashboard') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/dashboard"><i class="icon fa fa-tachometer"></i> Dashboard</a></li>
                                        <li id="report_side" ><a class="<?php if ($this->uri->segment(2) == 'report') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/report"><i class="icon fa fa-book"></i> Report</a></li>
                                        <li id="karyawan_side" ><a class="<?php if ($this->uri->segment(2) == 'user') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/user"><i class="icon fa fa-user-circle-o"></i> Karyawan</a></li>
					<li><a class="<?php if ($this->uri->segment(2) == 'bisnis') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/bisnis"><i class="icon fa fa-id-card"></i> Bisnis</a></li>
					<li><a class="<?php if ($this->uri->segment(2) == 'outlet') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/outlet"><i class="icon fa fa-building"></i> Outlet</a></li>
					<li><a class="<?php if ($this->uri->segment(2) == 'customer') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/customer"><i class="icon fa fa-group"></i> Customer</a></li>
                                        <li id="side_item_library" >
						<a id="" class="accordion"><i class="icon fa fa-list"></i> ITEM LIBRARY <i class="caret"></i></a>
						<div class="menu">
                                                    <div id="side_produk" class="sub-menu <?php if ($this->uri->segment(2) == 'produk') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/produk"><i class="icon fa fa-dropbox"></i> Produk</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'modifier') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/modifier"><i class="icon fa fa-fire"></i> Modifier</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'kategori') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/kategori"><i class="icon fa fa-object-group"></i> Kategori</a></div>
							<!--
														<div class="sub-menu <?php if ($this->uri->segment(2) == 'variant') echo 'active'; ?>"><a  href="<?php echo base_url(); ?>backoffice/variant"><i class="icon fa fa-cubes"></i> Variant</a></div>
								-->
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'promo') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/promo"><i class="icon fa fa-percent"></i> Promo</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'diskon') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/diskon"><i class="icon fa fa-percent"></i> Diskon</a></div>

							<?php if ($this->session->userdata('stok') == 2) { ?>
								<div class="sub-menu <?php if ($this->uri->segment(2) == 'stok') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/stok"><i class="icon fa fa-sitemap"></i> Stok</a></div>
							<?php } ?>
						</div>
					</li>
					<!-- <li>
							<a id="side_item_library" class="accordion"><i class="icon fa fa-list"></i> INGREDIENT LIBRARY<i class="caret"></i></a>
							<div class="menu" >
									<div class="sub-menu <?php if ($this->uri->segment(2) == 'ingredient') echo 'active'; ?>"><a  href="<?php echo base_url('backoffice/ingredient') ?>"><i class="icon fa fa-dropbox"></i> Ingredient</a></div>
									<div class="sub-menu <?php if ($this->uri->segment(2) == 'ingredient_kategori') echo 'active'; ?>"><a  href="<?php echo base_url('backoffice/ingredient_kategori') ?>"><i class="icon fa fa-object-group"></i> Kategori</a></div>
									<div class="sub-menu <?php if ($this->uri->segment(2) == 'resep') echo 'active'; ?>"><a  href="<?= base_url('backoffice/resep') ?>"><i class="icon fa fa-cutlery "></i> Resep</a></div>
									<div class="sub-menu <?php if ($this->uri->segment(2) == 'ingredient_stok') echo 'active'; ?>"><a  href="<?= base_url('backoffice/ingredient_stok') ?>"><i class="icon fa fa-sitemap "></i> Stok</a></div>
							</div>
						</li> -->

					<li>
						<a id="side_tipe_pembayaran" class="accordion"><i class="icon fa fa-credit-card-alt"></i> TIPE PEMBAYARAN <i class="caret"></i></a>
						<div class="menu">
							<!-- <div class="sub-menu <?php if ($this->uri->segment(2) == 'tip') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/tip"><i class="icon fa fa-ticket"></i> Tip</a></div> -->
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'sales_type') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/sales_type"><i class="icon fa fa-money"></i> Sales Type</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'tax') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/tax"><i class="icon fa fa-tags"></i> Pajak</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'diskon_transaksi') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/diskon_transaksi"><i class="icon fa fa-tags"></i> Diskon Transaksi</a></div>
						</div>
					</li>

					<li><a class="<?php if ($this->uri->segment(2) == 'payment_setup') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/payment_setup"><i class="icon fa fa-bank"></i> Payment Setup</a></li>

					<li><a class="<?php if ($this->uri->segment(2) == 'cashopname') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/cashopname"><i class="icon fa fa-shopping-basket"></i> Cashopname</a></li>
					<li>
						<a id="side_item_library" class="accordion"><i class="icon fa fa-list"></i> Table Management<i class="caret"></i></a>
						<div class="menu">
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'table_meja') echo 'active'; ?>"><a href="<?php echo base_url('backoffice/table_meja') ?>"><i class="icon fa fa-table"></i> Meja</a></div>
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'table_group') echo 'active'; ?>"><a href="<?php echo base_url('backoffice/table_group') ?>"><i class="icon fa fa-object-group"></i> Group</a></div>

						</div>
					</li>
					<li><a class="<?php if ($this->uri->segment(2) == 'receipt') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/receipt"><i class="icon fa fa-file-text-o"></i> Receipt</a>
					</li>
					<li><a class="<?php if ($this->uri->segment(2) == 'transaksi') echo 'active'; ?>" href="<?php echo base_url(); ?>backoffice/transaksi"><i class="icon fa fa-calculator"></i> Transaksi</a></li>
					<!-- <li>
						<a id="side_tipe_pembayaran" class="accordion"><i class="icon fa fa-file-text-o"></i> Receipt <i class="caret"></i></a>
						<div class="menu">
							<div class="sub-menu <?php if ($this->uri->segment(2) == 'Receipt') echo 'active'; ?>"><a href="<?php echo base_url(); ?>backoffice/receipt"><i class="icon fa fa-file-text-o"></i> Receipt</a></div>
						</div>
					</li> -->
					<li class="divider"></li>
					<?php
					if ($this->session->userdata('owner') == TRUE) {;
						?>
						<li><a href="<?php echo base_url(); ?>owner/home/logout"><i class="icon fa fa-sign-out"></i> Keluar</a></li>
					<?php
					} else {;
						?>
						<li><a href="<?php echo base_url(); ?>home/logout"><i class="icon fa fa-sign-out"></i> Keluar</a></li>
					<?php }; ?>
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
							<a style="margin-left:10px;" href="#" class="navbar-brand"><?php echo $this->db->where('idbusiness', $this->session->userdata('id_business'))->get('business')->row_array()['nama_business'] ?></a>
							<!--
								<div style="padding-top: 10px">
								<?php
								if ($this->session->userdata('owner') == TRUE) {;
									?>
																<a href="<?php echo base_url(); ?>owner/dashboard" class="btn btn-primary btn-sm">Back To Dashboard</a>
								<?php }; ?>
								</div>
								-->
						</div>

						<div class="collapse navbar-collapse navigation">
							<ul class="nav navbar-nav navbar-right">
								<li><a id="sticky_allow" href="#" data-toggle="tooltip" title="Anda tetap bisa melakukan tour dengan klik disini"><i class="fa fa-child"></i> Take Tour</a></li>
								<?php if ($this->session->userdata('owner') == TRUE) {
									?>
									<li><a href="<?php echo base_url(); ?>owner/dashboard"><i class="icon fa fa-sign-out"></i> Dashboard Owner</a></li>
								<?php } ?>
								<li class="dropdown dropdown-user">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img src="<?php echo base_url(); ?>assets/logo2.PNG" alt="" class="avatar">
										<?php echo $this->session->userdata('nama_user') ?> <i class="caret"></i>
									</a>
									<ul class="dropdown-menu">
										<li class="profile">
											<div class="media">
												<div class="media-left media-middle">
													<img src="<?php echo base_url(); ?>assets/logo2.PNG" alt="" class="avatar">
												</div>
												<div class="media-body media-middle">
													<div class="name"><strong><?php echo $this->session->userdata('nama_user'); ?></strong></div>
													<?php
													if ($this->session->userdata('owner') == TRUE) {;
														?>
														<div class="job">Owner</div>
													<?php
													} else {;
														?>
														<?php
															if ($this->session->userdata('role_user') == 1) {;
																?>
															<div class="job">Manajer</div>
														<?php
															} else {;
																?>
															<div class="job"> Backofficer</div>
														<?php }; ?>
													<?php }; ?>
												</div>
											</div>
										</li>
										<?php
										if ($this->session->userdata('owner') != TRUE) {;
											?>
											<li><a href="<?php echo base_url(); ?>backoffice/profile"><i class="fa fa-user-circle-o fa-fw"></i> Profile</a></li>
										<?php }; ?>
										<li class="divider"></li>
										<?php
										if ($this->session->userdata('owner') != TRUE) {;
											?>
											<li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out fa-fw"></i>
													Logout</a></li>
										<?php
										} else {;
											?>
											<li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out fa-fw"></i>
													Logout</a></li>
										<?php }; ?>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<!--<div style="width: 100%;height: 100%;overflow: scroll;">-->
			<?php echo $content; ?>
			<!--</div>-->
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
		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var menu = this.nextElementSibling;
				if (menu.style.display === "block") {
					menu.style.display = "none";
				} else {
					menu.style.display = "block";
				}
			});
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#<?php echo $message; ?>").modal('show');

			setTimeout(function() {
				$('#<?php echo $message; ?>').modal('hide');
			}, 2000);

			setTimeout(function() {
				$('#ifrm').remove();
			}, 1000);


			$("#modal-flashdata").modal('show');

			setTimeout(function() {
				$('#modal-flashdata').modal('hide');
			}, 2000);
		});
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
			$('#example3').DataTable({
				'paging': false,
				'lengthChange': false,
				'searching': false,
				'ordering': true,
				'info': false,
				'autoWidth': false
			})
			$('#example4').DataTable({
				'paging': false,
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
	<?php require_once 'template_sticky.php'; ?>
</body>

</html>