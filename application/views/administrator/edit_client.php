<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Owner</h4>
        </div>
    </div>
    <div class="panel-heading">
		<?php
		
		 if(empty($id = $this->uri->segment(3))  || empty($row)){ ?>
			<p>Data Tidak Ada</p>
		<?php }else{ ?>
	    <div class="form">
	        <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>administrator/edit_owner" autocomplete="off">
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="panel panel-default">
	                        <div class="panel-body same_height" >
	                            <div class="form-group">
	                                <label for="">Nama Owner</label>
	                                <input type="text" class="form-control" name="nama_user" value="<?php echo $row->nama_user;?>" required>
	                                <input type="text" style="display:none;" name="idowner" value="<?php echo $row->idowner;?>" readonly>
	                            </div>
	                            <div class="form-group">
	                                <label for="">Telp Owner</label>
	                                <input type="text" id="telp" class="form-control" name="telp_user" value="<?php echo $row->telp_user?>" required>
	                            </div>
	                            <div class="form-group">
	                                <label for="">Email Owner</label>
	                                <input type="text" class="form-control" name="email_check" id="email_user" value="<?php echo $row->email_user?>" disabled>
	                                <small class="text-muted">
	                                	<input type="checkbox" id="email-checked" class="form-inline"> Ubah Email?
	                                </small>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="col-md-4">
	                    <div class="panel panel-default">
	                        <div class="panel-body same_height">
	                            <div class="form-group">
	                                <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
	                                <input type="password" id="password" class="form-control" name="password">
	                            </div>
	                            <div class="form-group">
	                                <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
	                                <input type="password" id="type_pass" class="form-control" name="password2">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>

	            <div class="row">
	                <div class="col-md-12">
	                    <div class="panel panel-default">
	                        <div class="panel-body">
	                            <div class="form-group">
	                                <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
		<?php } ?>
    	
    </div>
</div>

<!-- validation form -->
<script>
	var id = '<?php echo $row->idowner ?>';

	$(function() {
		$('#validationForm').validate({
			rules:{
				nama_user:{ required:true },
				telp_user:{required:true, minlength:10},
				email_checked: {
					required: true, 
					email: true,
					remote:{
						url: "<?php echo base_url('administrator/checkEmailExist') ?>",
                    	type: "post"
					}
				},
				password2: {equalTo:'#password'}
			},
			messages:{
				nama_user:{ required:"Nama Owner Tidak Boleh Kosong" },
				email_checked: {
					required: "Email Owner Tidak Boleh Kosong",
					email: "Mohon Masukkan Email Yang Benar",
					remote: "Email Sudah Dipakai. Silahkan Masukkan Email Yang Lain"
				},
				telp_user:{
					required:"Nomor Telepon Tidak Boleh Kosong", 
					minlength:"Nomor telepon minimal 10 digits"
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
			},
			submitHandler: function(form) {
                form.submit();
            }
    		
		});

		$("input[name='telp_owner']").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });


	    $("#email-checked").change(function() {
		    if(this.checked) {
		    	$('#email_user').removeAttr('disabled')
		    	$('#email_user').attr('name', 'email_checked');

		    }else{
		    	$.getJSON('<?php echo base_url()?>administrator/getEmailOwnerJSN/'+id,function(data, status) {
		    			$("#email_user").val(data.email_user);
		    			$('#email_user').attr('name', 'email_check');
		    	});
		    	$('#email_user').attr('disabled', 'true');
		    }
		});
	});
</script>