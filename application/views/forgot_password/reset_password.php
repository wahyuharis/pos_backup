<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/logo2.PNG">
        <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
        <title>AIO POS</title>

        <!-- CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/app.css">


        <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    </head>
    <body class="loading">
        <div class="login-container">
            <div class="login-cover">
                <img src="https://images.pexels.com/photos/935756/pexels-photo-935756.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" class="bg">
                <div class="login-intro">
                    <h2>AIO POS</h2>
                    
                    	
                    <br/><br/><br/>
                    <p>
                    <ul>
                        <li>Jika anda mendapatkan kendala anda dapat hubungi kami di :</li><br>
                        <li><a href="#"><i class="fa fa-phone"></i></a></li>+6287820596000<br>
                        <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>+6287820596000
                    </ul>
                    </p>

                </div>
            </div>
            <div class="login-form">
            	
                <form id="form-reset" class="form form-login" method="POST" action="<?= base_url('forgot_password/savePassword') ?>" autocomplete="off">
                    <h2>Ubah Password</h2>
                    <div class="form-group">
                        <label for=""><?= $this->session->userdata('email-reset');  ?></label>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password2" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                    <br/>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">UBAH PASSWORD</button>
                        <!--
                            <a href="<?php echo base_url(); ?>home/register" class="btn btn-default">REGISTER</a>
                        -->
                    </div>
	                
                </form>
            </div>
        </div>
			
        <?php if($this->session->flashdata('message')){ ?>
        <div class="modal fade" id="failed">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fa fa-warning fa-5x text-warning"></i>
                        <br/><br/>
                        <p>
                           <?= $this->session->flashdata('message') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
	     <?php } ?>

        <script>
			$(function() {
				$('#form-reset').validate({
					rules:{
						password:{	required:true, minlength:6 },
						password2: {equalTo:'#password'}
					},
					messages:{
						password:{
							required:"Silahkan masukkan password", 
							minlength:"Password minimal 6 karakter"
						},
						password2:{equalTo:"Password tidak cocok"}

					},
					errorElement: "em",
					errorPlacement: function ( error, element ) {
						// Add the `help-block` class to the error element
						error.addClass( "help-block" );
						error.css('color', '#ff6666');

						if ( element.prop( "type" ) === "checkbox" ) {
							error.insertAfter( element.parent( "label" ) );
						} else {
							error.insertAfter( element );
						}
					},

					highlight: function ( element, errorClass, validClass ) {
						$( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
					},

					unhighlight: function (element, errorClass, validClass) {
						$( element ).parents( ".form-group" ).removeClass( "has-error" );
					}
				});

			});
		</script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#failed").modal('show');

                setTimeout(function () {
                    $('#failed').modal('hide');
                }, 2000);

                setTimeout(function () {
                    $('#ifrm').remove();
                }, 1000);
            });
        </script>
    </body>
</html>
