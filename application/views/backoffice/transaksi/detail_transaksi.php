<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Detail Transaksi</h4>
        </div>
        <div class="panel-body">
            <div class="form">
                <div class="col-md-12">
                    <?php foreach ($transaksi as $row) : ?>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'"); ?>
                                    <?php
                                        foreach ($query->result_array() as $rw) :
                                            $outlet = $rw['name_outlet'];
                                        endforeach;
                                        ?>
                                    <div class="form-group">
                                        <label for="">Outlet</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: white"><i class="fa fa-building-o" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" value="<?php echo $outlet; ?>" disabled>
                                        </div>
                                    </div>
                                    <?php $query = $this->db->query("SELECT nama_user FROM user WHERE iduser='$row->iduser'"); ?>
                                    <?php
                                        foreach ($query->result_array() as $rw) :
                                            $nama = $rw['nama_user'];
                                        endforeach;
                                        ?>
                                    <div class="form-group">
                                        <label for="">Kasir</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: white"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" value="<?php echo $nama; ?>" disabled>
                                        </div>
                                    </div>
                                    <?php $date = $row->tgl_transHD; ?>
                                    <div class="form-group">
                                        <label for="">Tanggal</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($date)); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!--
                                    <?php $query = $this->db->query("SELECT nama_pay FROM payment_setup WHERE idpay='$row->idpay'"); ?>
                                    <?php
                                        foreach ($query->result_array() as $ru) :
                                            $nama_pay = $ru['nama_pay'];
                                        endforeach;
                                        ?>
                                    <div class="form-group">
                                        <label for="">Payment Type</label>
                                        <input type="text" class="form-control" value="<?php echo $nama_pay; ?>" disabled>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <label for="">Total Transaksi</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: white">Rp.</span>
                                            <input type="text" class="form-control" value="<?php echo number_format($row->total_transHD, 2); ?>" disabled>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label for="">Dibayarkan</label>
                                        <input type="text" class="form-control" value="Rp. <?php echo $row->pay_transHD; ?>" disabled>
                                    </div>-->
                                    <div class="form-group">
                                        <label for="">Cashback/Kembalian</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" style="background-color: white">Rp.</span>
                                            <input type="text" class="form-control" value="<?php echo number_format($row->cashback_transHD, 2); ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="jumbotron">
                                        <center>
                                            <h2>Total Transaksi</h2>
                                            <h2 id="h5_total_transaksi"></h2>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p><b><i class="fa fa-list" aria-hidden="true"></i> PRODUK LIST</b></p>
                            <table class="table table-striped">
                                <?php $type_bisnis = $this->session->userdata('type_bus') ?>
                                <thead class="bg">
                                    <tr>
                                        <th width="10">No</th>
                                        <th>Produk</th>
                                        <th>Variant</th>
                                        <th>Quantity</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no_detail = 0; ?>
                                    <?php $total_all = 0 ?>
                                    <?php $colspan = 4 ?>
                                    <?php
                                        $colspan = $colspan;
                                        ?>
                                    <?php foreach ($detail_transaksi as $row) { ?>
                                        <?php $no_detail++ ?>
                                        <?php $total_per_item = 0; ?>
                                        <tr>
                                            <td><b><?= $no_detail ?></b></td>
                                            <td>
                                                <p><b><?= $row['nama_produk'] ?></b></p>
                                                <?php foreach ($row['modifier'] as $row2) { ?>
                                                    <p> <?= $row2['nama_modifier'] . "-" . $row2['nama_sub'] ?> </p>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <b><?= $row['nama_variant'] ?></b>
                                            </td>
                                            <td><?= $row['qty'] ?></td>
                                            <td><?= number_format($row['harga_satuan'], 2) ?></td>
                                            <?php $total_per_item = floatval($row['qty']) * floatval($row['harga_satuan']) ?>
                                            <td>
                                                <p><?= number_format($total_per_item, 2) ?></p>
                                                <?php $total_modifier = 0; ?>
                                                <?php foreach ($row['modifier'] as $row2) { ?>
                                                    <?php $total_per_modifier = $row['qty'] * $row2['harga_satuan'] ?>
                                                    <p> <?= number_format($total_per_modifier, 2) ?> </p>
                                                    <?php $total_modifier = $total_modifier + $total_per_modifier; ?>
                                                <?php } ?>
                                            </td>
                                            <?php $total_all = $total_all + $total_per_item + $total_modifier; ?>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="<?= $colspan ?>"></td>
                                        <th colspan="">Total</th>
                                        <th colspan=""><?= number_format($total_all, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <p><b><i class="fa fa-tags" aria-hidden="true"></i> PROMO</b></p>
                            <table class="table table-bordered table-condensed table-strip">
                                <thead class="bg">
                                    <tr>
                                        <th>Item Promo</th>
                                        <th>Qty</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detail_promo as $row) { ?>
                                        <tr>
                                            <td><?= $row['nama_produk'] ?> - <?= $row['nama_variant'] ?> </td>
                                            <td><?= $row['qty'] ?></td>
                                            <td>Tiap
                                                Beli <?= $row['qty'] ?> produk <?= $row['nama_produk'] ?> variant <?= $row['nama_variant'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <p><b><i class="fa fa-tag" aria-hidden="true"></i>TAX</b></p>
                            <table class="table table-bordered table-condensed table-strip">
                                <thead class="bg">
                                    <tr>
                                        <th>Nama Tax</th>
                                        <th>Persen</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_tax = 0; ?>
                                    <?php foreach ($tax_list as $row) { ?>
                                        <tr>
                                            <td>
                                                <?= $row['nama_tax'] ?>
                                            </td>
                                            <td>
                                                <?= $row['besaran_tax'] ?> %
                                            </td>
                                            <td>
                                                <?php $total_pertax = ($total_all / 100) * $row['besaran_tax']; ?>
                                                <?= number_format($total_pertax, 2) ?>
                                                <?php $total_tax = $total_tax + $total_pertax ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>Total</td>
                                        <td><?= number_format($total_tax, 2) ?></td>
                                        <?php $total_all = $total_all + $total_tax; ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <a href="<?php echo base_url(); ?>backoffice/transaksi" type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#h5_total_transaksi').html('<?= number_format($total_all, 2) ?>');
    });
</script>