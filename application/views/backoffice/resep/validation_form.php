<!-- validation form -->
<script>
	$(function() {
		$('#form-resep').validate({
			rules:{
				produk:{ required:true },
			},
			messages:{
				produk:{ required:"Silahkan pilih produk" },

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
				// if (element.hasClass("select2-offscreen")) {
				// 	$("#s2id_" + element.attr("id") + " ul").removeClass(errorClass);
		  //     }
				$( element ).parents( ".form-group" ).removeClass( "has-error" );
			}
		});

		$(".qty").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });
		$("#qty-add").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });
	});
</script>
