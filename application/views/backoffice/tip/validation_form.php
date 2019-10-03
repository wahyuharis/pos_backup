<script>
	$(function() {
		$('#validationForm').validate({
			rules:{
				nama_tip: {required:true},
				besaran: {required:true}
			},
			messages:{
				nama_tip: {required:"Silahkan masukkan nama tip"},
				besaran: {required:"Silahkan masukkan besaran tip"}
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
		})

		$("input[name='besaran']").keypress(function(e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        return false;
		    }
	    });
	});
</script>