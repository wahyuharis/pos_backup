<!-- validation form -->
<script>
	$(function() {
		$('#validationForm').validate({
			rules:{
				nama_outlet:{ required:true },
				provinsi:{required:true},
				kabupaten:{required:true},
				kecamatan:{required:true},
				alamat:{required:true},
				telp:{required:true, minlength:10},
				tax:{required:true},
			},
			messages:{
				nama_outlet:{ required:"Silahkan masukkan nama outlet" },
				provinsi:{ required:"Silahkan pilih provinsi" },
				kabupaten:{ required:"Silahkan pilih kabupaten" },
				kecamatan:{ required:"Silahkan pilih kecamatan" },
				alamat:{ required:"Silahkan masukkan alamat outlet" },
				telp:{ 
					required:"Silahkan masukkan nomor telepon",
					minlength: "Nomor telepon minimal 10 digits"
				},
				tax: { required: "Silahkan pilih metode pajak" },

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

		$("input[name='telp']").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });
	});
</script>