<style>
    .same_height{
        min-height: 380px;
    }
    .fixed-alert{
        position: fixed;
        z-index: 9999;
        width: 300px;
        bottom: 10px;
        right: 10px;
    }
    .select2-results__option[aria-selected=true] { 
        display: none;
    }

</style>

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Tambah Resep</h4>
        </div>
    </div>
    <form id="form-resep" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/resep/insert" autocomplete="off">
    	<div class="row">
            <div class="col-md-6">
            	<div class="panel panel-default">
            		<div class="panel-body">
            			
	                    <div class="form-group">
	                        <label for="">Produk</label>
	                        <select name="idproduk" class="form-control" required>
	                        	<option value="" disabled selected>Pilih Produk</option>
	                        </select>
	                    </div>
	                    <div class="form-group">
	                        <label for="">Variant</label>
	                        <select name="idvariant" class="form-control" disabled>
	                        	<option value="" selected>Variant</option>
	                        </select>
	                    </div>
            		</div>
            	</div>
            </div>
    		<div class="col-md-6">
    			<div class="panel panel-default">
            		<div class="panel-body">
	                    <div class="form-group">
	                        <label for="">Ingredient</label>
	                        <div class="row">
	                        	<div class="col-md-6">
			                        <select id="ingredient-add" class="form-control">
			                        	<option value="" disabled selected>Pilih Ingredient</option>
			                        </select>
	                        		
	                        	</div>
	                        	<div class="col-md-4">
			                        <input id="qty-add" type="text" class="form-control input-sm" placeholder="Qty">
	                        	</div>
	                        	<div class="col-md-2 text-right">
		                        	<button id="add-ingredient" class="btn btn-sm btn-primary">Tambah</button>
	                        	</div>
	                        </div>
	                    </div>
	            		<table class="table" id="ingredient-list">
	            			<thead>
		            			<tr>
		            				<th>Ingredient</th>
		            				<th>Qty</th>
		            				<th width="4%">#</th>
		            			</tr>
	            			</thead>
	            			<tbody>
		            			<!-- <tr>
		            				<td><input type="text" class="form-control input-sm" disabled></td>
		            				<td><input type="text" class="form-control input-sm"></td>
		            				<td width="4%">
		            					<button class="btn btn-danger btn-xs" href="#"><i class="fa fa-trash"></i></button>
		            				</td>
		            			</tr> -->
	            				
	            			</tbody>
	            		</table>
            		</div>
            	</div>
    		</div>
    	</div>
		<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<div class="panel-body">
                    <div class="form-group">
                        <a href="<?php echo base_url(); ?>backoffice/resep" type="button" class="btn btn-default">Kembali</a>
                        <button type="submit" id="bsub" class="btn btn-primary">Simpan</button>
                    </div>
            		
            	</div>
            </div>
        </div>
			
		</div>
    </form>
    </div>
</div>

<?php require_once('validation_form.php') ?>

<script type="text/javascript">

	jQuery(document).ready(function(e) {

	    $('select[name=idproduk]').select2({
	        ajax: {
	            url: '<?= base_url() ?>backoffice/resep/get_produk_toJSON',
	            dataType: 'json',
	        },
	    });

		$('select[name=idproduk]').change(function(e) {
			var idproduk = $('select[name=idproduk]').val();
			$('select[name=idvariant]').removeAttr('disabled')
			$('select[name=idvariant]').val('')
			// $('select[name=variant]').append('<option value="" disabled selected>Pilih Ingredient</option>')
			$('select[name=idvariant]').select2({
				// placeholder: "Pilih Variant",
		        ajax: {
		            url: '<?= base_url() ?>backoffice/resep/get_variant_toJSON/'+idproduk,
		            dataType: 'json',
		        },
		    });
		});

	    $('#ingredient-add').select2({
	        ajax: {
	            url: '<?= base_url() ?>backoffice/resep/get_ingredient_toJSON',
	            dataType: 'json',
	        },
	    });
	});

	$(function(e) {
		$('#add-ingredient').click(function(e) {
			e.preventDefault();
			var idingredient_add = $("#ingredient-add").val();
			var ingredient_add = $("#ingredient-add option:selected").text();
         var qty = $("#qty-add").val();

         if (idingredient_add !==null && qty !=='') {
            var markup = `
            	<tr>
            		<input type="hidden" name='idingredient[]' value='${idingredient_add}' />
            		<td><input type='text' class='form-control input-sm' value='${ingredient_add}' disabled></td>
            		<td><input type='text' class='form-control input-sm qty' value='${qty}' name='qty[]'></td>
            		<td width="4%">
						<button class="btn btn-danger btn-xs delete-ingredient"><i class="fa fa-trash"></i></button>
					</td>
            `;
            $("#ingredient-list tbody").append(markup);
            $("#ingredient-add").html('<option value="" disabled selected>Pilih Ingredient</option>');
            $("#qty-add").val('');

            $(".qty").keypress(function(e) {
			    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			        return false;
			    }
	    });

         }
		});

		$("#ingredient-list tbody").on('click','.delete-ingredient',function(e){
			e.preventDefault()
	        $(this).parent().parent('tr').remove();
	    });
		
	});

</script>
