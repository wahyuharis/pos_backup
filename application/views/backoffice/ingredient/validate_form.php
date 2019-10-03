<!-- validation form -->
<script>
	$(function() {
		$('#form-ingredient').validate({
			rules:{
				nama_ingredient:{ required:true },
				unit:{ required:true },
				'outlet[]' : { required: true},
				stok:{ required:true },
				harga:{ required:true },
				kategori:{ required:true },

			},
			messages:{
				nama_ingredient:{ required:"Silahkan masukkan nama ingredient" },
				unit:{ required:"Silahkan pilih unit" },
				'outlet[]' : { required: "Outlet belum dicentang"},
				stok:{ required:"Silahkan masukkan stok awal" },
				harga:{ required:"Silahkan masukkan harga ingredient" },
				kategori:{ required:"Pilih kategori ingredient" },

			},
			errorElement: "em",
			errorPlacement: function ( error, element ) {
				// Add the `help-block` class to the error element
				error.addClass( "help-block" );
				error.css('color', '#ff6666');

				if ( element.prop( "type" ) === "checkbox" ) {
					// error.insertAfter( element.parent( "table" ) );
					error.appendTo('#error-checkbox')
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

		$("input[name='stok']").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });
	});
</script>
