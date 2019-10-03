<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : 5</a>
        <a href="#" class="btn btn-default btn-sm">Import/ Export <i class="caret"></i></a>
        <a href="<?php echo base_url(); ?>backoffice/stok/tambah_stok" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Stock</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_adjustment" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Adjustment</a>
        <a href="<?php echo base_url(); ?>backoffice/stok/create_transfer" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Transfer Order</a>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-left form-inline">
                        <div class="input-group">
                            <input id="daterange" type="text" class="form-control">
                        </div>
                        <button class="btn btn-default" type="button">Filter</button>
                    </div>
                    <div class="pull-right form-inline">
                        <!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                        <button class="btn btn-default" type="button" data-toggle="collapse" data-target=".advance-search">Advance Search</button>
                        -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body form-inline collapse advance-search">
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Bisnis</option>
                    </select>
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Outlet</option>
                    </select>
                    <select name="" id="" class="form-control input-sm">
                        <option value="">Semua Status</option>
                    </select>
                </div>
                <div class="panel-body"> 
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-strip">
                            <thead class="bg">
                                <tr>
                                    <th width="10">No</th>
                                    <th>Nama Produk</th>
                                    <th>Awal</th>
                                    <th>Masuk</th>
                                    <th>Jual</th>
                                    <th>Penyesuaian</th>
                                    <th>Transfer</th>
                                    <th>Akhir</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($produk as $row): ?>
                                    <?php $whr = array('idproduk' => $row->idproduk); ?>
                                    <?php $count = $this->data_model->count_where('variant', $whr); ?>
                                    <?php if ($count == 0) {
    ; ?>
                                        <?php $kk = $this->db->query("SELECT * FROM stok WHERE tanggal=(SELECT MAX(tanggal) FROM stok WHERE idproduk='$row->idproduk') AND idproduk='$row->idproduk' AND status = 1")->result(); ?>
            <?php foreach ($kk as $ii): ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><?php echo $row->nama_produk; ?></td>
                                                <td><?php echo $ii->awal; ?></td>
                                                <td><?php echo $ii->masuk; ?></td>
                                                <td><?php echo $ii->jual; ?></td>
                                                <td><?php echo $ii->penyesuaian; ?></td>
                                                <td><?php echo $ii->transfer; ?></td>
                                                <td><?php echo $ii->akhir; ?></td>
                                                <td>Rp. <?php echo $ii->harga; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } else {
                                        ; ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td colspan="8">
                                        <?php echo $row->nama_produk; ?>
                                            </td>
                                        </tr>
                                        <?php $qw = $this->db->query("SELECT idvariant,nama_variant FROM variant WHERE idproduk='$row->idproduk' AND status = 1")->result(); ?>
                                        <?php
                                        foreach ($qw as $bv):
                                            $id_var = $bv->idvariant;
                                            $nama_variant = $bv->nama_variant;
                                            $qu = $this->db->query("SELECT * FROM stok WHERE tanggal=(SELECT MAX(tanggal) FROM stok WHERE idvariant='$id_var') AND idvariant='$id_var' AND status = 1")->result();
                                            foreach ($qu as $lp):;
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?php echo $nama_variant; ?>
                                                    </td>
                                                    <td><?php echo $lp->awal; ?></td>
                                                    <td><?php echo $lp->masuk; ?></td>
                                                    <td><?php echo $lp->jual; ?></td>
                                                    <td><?php echo $lp->penyesuaian; ?></td>
                                                    <td><?php echo $lp->transfer; ?></td>
                                                    <td><?php echo $lp->akhir; ?></td>
                                                    <td>Rp. <?php echo $lp->harga; ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        endforeach;
                                        ?>
                                    <?php }; ?>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>