<div class="wrapper">
    <div class="panel-body">
        <h4>Create Produk</h4>
        <hr/>
        <div class="form">
            <form id="form" method="POST" action="<?php echo base_url();?>backoffice/produk/insert_produk">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Harga Produk</label>
                            <input type="text" id="hgpd" name="harga_produk" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Stock Awal Produk</label>
                            <input type="text" id="stpd" name="stock_awal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="kategori" id="" class="form-control">
                                <option value="0">-- Pilih Kategori --</option>
                                <?php foreach($comkat as $rw):?>
                                    <option value="<?php echo $rw->idkategori;?>"><?php echo $rw->nama_kategori;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php $id_business=$this->session->userdata('id_business');?>
                        <?php $bus=$this->db->query("SELECT nama_business,idbusiness FROM business WHERE idbusiness = '$id_business'")->result();?>
                        <div class="form-group">
                            <label for="">Business</label>
                            <?php foreach ($bus as $row):?>
                                <input type="text" class="form-control" value="<?php echo $row->nama_business;?>" readonly>
                                <input type="text" class="form-control" style="display:none;" name="id_business" value="<?php echo $row->idbusiness;?>" readonly>
                            <?php endforeach;?>
                        </div>
                        <div class="form-group">
                            <label for="">Outlet</label><br>
                            <?php foreach ($comout as $rw):?>
                                <input type="checkbox" name="outlet[]" id="outlet" value="<?php echo $rw->idoutlet;?>"> <?php echo $rw->name_outlet;?><br>
                            <?php endforeach;?>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <label for="">Varian</label>
                        <div class="form-group">
                            <div id="inp_varian"></div>
                        </div>
                        <button id="btn" class="btn btn-primary" type="button">Tambah Varian</button>
                    </div>
                </div>
                <hr/>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function() {
      var counter = 0;
      var btn = document.getElementById('btn');
      var form = document.getElementById('inp_varian');
      var iphg = document.getElementById('hgpd');
      var stpd = document.getElementById('stpd');
      var addInput = function()
      {
        counter++;
        var input = document.createElement("input");
        input.id = 'varian-' + counter;
        input.type = 'text';
        input.className = 'form-control';
        input.name = 'varian[]';
        input.placeholder = 'Varian ' + counter;
        form.appendChild(input);

        var harga = document.createElement("input");
        harga.id = 'harga-' + counter;
        harga.type = 'text';
        harga.className = 'form-control';
        harga.name = 'harga[]';
        harga.placeholder = 'Harga ' + counter;
        form.appendChild(harga);

        var stok = document.createElement("input");
        stok.id = 'stok-' + counter;
        stok.type = 'text';
        stok.className = 'form-control';
        stok.name = 'stok[]';
        stok.placeholder = 'Stok ' + counter;
        form.appendChild(stok);
    };
    btn.addEventListener('click', function()
    {
        iphg.disabled = true;
        stpd.disabled = true;
        addInput();
    }.bind(this));
})();
</script>