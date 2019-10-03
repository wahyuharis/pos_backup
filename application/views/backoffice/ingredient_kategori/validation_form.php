<script>
	$(function() {
		$('#validationForm').validate({
			rules:{
				nama_kategori: {required:true}
			}, messages: {
				nama_kategori: {required:"Silahkan isi kategori"}
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
	});
</script>
