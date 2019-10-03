<?php 
$tanggal_start=DateTime::createFromFormat('Y-m-d H:i', trim($tanggal_start))->format('d/m/Y');
$tanggal_end=DateTime::createFromFormat('Y-m-d H:i', trim($tanggal_end))->format('d/m/Y');
?>
<div class="row">
    <div class="col-sm-6">
        <table style="width: 100%" >
            <tbody>
                <tr>
                    <td>Produk</td>
                    <td> : </td>
                    <td><?=$detil[0]['nama_produk']?> - <?=$detil[0]['nama_variant']?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td> : </td>
                    <td><?=$tanggal_start?> s/d <?=$tanggal_end?></td>
                </tr>
                <tr>
                    <td>Outlet</td>
                    <td> : </td>
                    <td><?=$name_outlet?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        
    </div>
</div>
<div style="height: 30px"></div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>AWAL</th>
                    <th>MASUK</th>
                    <th>JUAL</th>
                    <th>PENYESUAIAN</th>
                    <th>TRANSFER</th>
                    <th>AKHIR</th>
                    <th>HARGA</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detil as $row) { ?>
                    <tr>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['awal'] ?></td>
                        <td><?= $row['masuk'] ?></td>
                        <td><?= $row['jual'] ?></td>
                        <td><?= $row['transfer'] ?></td>
                        <td><?= $row['penyesuaian'] ?></td>
                        <td><?= $row['akhir'] ?></td>
                        <td><?= number_format($row['harga'], 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>