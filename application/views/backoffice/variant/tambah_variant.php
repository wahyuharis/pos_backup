<div class="wrapper">
    <div class="panel-body">
        <h4>Create Variant</h4>
        <hr/>
        <form method="POST" id="validationForm" action="<?php echo base_url();?>backoffice/variant/insert_variant">
            <div class="form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Variant</label>
                            <input type="text" name="nama_variant" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Harga Variant</label>
                            <input type="text" name="harga_variant" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Stock Awal</label>
                            <input type="text" name="stock_awal" class="form-control" required>
				<label for="">Jika anda tidak ingin menggunakan stok, isi stok awal dengan 1000</label>
                        </div>
                        
                    </div>
			<div class="col-md-4">
				<div class="form-group">
                            <label for="">Produk</label>
                            <select name="produk" id="produk" onchange="selectProduk()" class="form-control">
                                <option value="0">-- Pilih Produk --</option>
                                <?php foreach($comprod as $rw):?>
                                    <option value="<?php echo $rw->idproduk;?>"><?php echo $rw->nama_produk;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <?php $id_business=$this->session->userdata('id_business');?>
                        <?php $bus=$this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result();?>
                        <div class="form-group">
                            <label for="">Business</label>
                            <?php foreach ($bus as $row):?>
                                <input type="text" class="form-control" value="<?php echo $row->nama_business;?>" readonly>
                                <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness;?>" readonly>
                            <?php endforeach;?>
                        </div>
			</div>
                </div>
                <hr/>
                <a href="<?php echo base_url();?>backoffice/variant" type="button" class="btn btn-default">Back</a>
                <button type="submit" id="bsub" style="display:none;" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function selectProduk()
    {
        var e = document.getElementById("produk");
        var variant = e.options[e.selectedIndex].value;
        var sub = document.getElementById('bsub');

        if (produk != "0")
        {
            sub.style.display = "inline";
        }
        else
        {
            sub.style.display = "none";
        }
    }
</script>