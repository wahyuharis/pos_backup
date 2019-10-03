<style>
    .font-gede {
        font-size: 20px;
        font-weight: bold;
    }

    .hide-canvas {
        background-color: #000;
        position: absolute;
        top: 401px;
        left: 30px;
        width: 80px;
        height: 27px;
        z-index: 9999;
    }
</style>
<div class="wrapper">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="col-md-4 pull-left">
                            <form class="" method="post" id="filter-dashboard">
                                <div class="form-group">
                                    <label style="text-align: left" for="tanggal">Periode</label>
                                    <div class="input-group">
                                        <input id="tanggal" name="tanggal" type="text" value="<?= $tanggal ?>" class="form-control" placeholder="Periode - Tanggal">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <span class="font-gede">Total Pendapatan</span>
                    </div>
                    <div class="panel-body text-center">
                        <span class="font-gede" id="total_pendapatan"><?= $total_pendapatan ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class=" panel-heading text-center">
                        <span class="font-gede">Total Transaksi</span>
                    </div>
                    <div class=" panel-body text-center">
                        <span class="font-gede" id="total_customer"><?= $total_transaksi ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class=" panel-heading text-center">
                        <span class="font-gede">Total Outlet</span>
                    </div>
                    <div class=" panel-body text-center">
                        <span class="font-gede" id="total_pendapatan"><?= $total_outlet ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <span class="font-gede">Total Penjualan Perkategori</span>
                    </div>
                    <div class=" panel-body text-center">
                        <div id="total-penjualan-perkategori" style="height: 300px; width: 100%; "></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <span class="font-gede">Total Penjualan Pertanggal</span>
                    </div>
                    <div class="panel-body text-center">
                        <div id="total-penjualan" style="height: 300px; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <span class="font-gede">Total Penjualan Perjam</span>
                    </div>
                    <div class=" panel-body text-center">
                        <div id="total-penjualan-perjam" style="height: 300px; width: 100%; "></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">
                        <span class="font-gede">Total Penjualan Harian</span>
                    </div>
                    <div class="panel-body text-center">
                        <div id="total-penjualan-harian" style="height: 300px; width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            <?php if (count($transaksi_top_10) > 0): ?>
                <div class="col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading text-center">
                            <span class="font-gede"><?= 'Penjualan Top ' . count($transaksi_top_10); ?> </span>
                        </div>
                        <div class=" panel-body text-center">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($transaksi_top_10 as $row) { ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row['nama_produk'] ?></td>
                                            <td><?= $row['total_qty'] ?></td>
                                            <td><?= number_format($row['total_jual_int'], 2) ?></td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php ?>
                        </div>
                    </div>
                </div>

            <?php endif ?>
        </div>


    </div>
</div>
<script>
//    setTimeout(function () {

//    }, 500);

    window.onload = function () {
        new Morris.Area({
            // ID of the element in which to draw the chart.
            element: 'total-penjualan',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: <?= $transaksi_perhari ?>,
            // The name of the data record attribute that contains x-values.
            xkey: 'x',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['y'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['y'],
            xLabelFormat: function (d) {
                return ("0" + d.getDate()).slice(-2) + '/' + ("0" + (d.getMonth() + 1)).slice(-2) + '/' + d.getFullYear();
            },
            hoverCallback: function (index, options, content, row) {
                //                console.log(row);
                //                console.log(content);

                var tanggal = moment(row.x, 'YYYY-MM-DD').format('DD/MM/YYYY');
                var rupiah = parseFloat(row.y).toLocaleString('en');

                content = "<div class='morris-hover-row-label'>" + tanggal + "</div>" +
                        "<div class='morris-hover-point' style='color: #0b62a4'>" +
                        "value:" + rupiah + "</div>";

                return (content);
            },
        });


        new Morris.Donut({
            element: 'total-penjualan-perkategori',
            data: <?= $transaksi_per_kategori ?>
        });



        new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'total-penjualan-perjam',
            data: <?= $transaksi_perjam ?>,
            // The name of the data record attribute that contains x-values.
            xkey: 'x',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['y'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Jumlah Trans'],
        });

        new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'total-penjualan-harian',
            data: <?= $transaksi_day_of_week ?>,
            // The name of the data record attribute that contains x-values.
            xkey: 'x',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['y'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Jumlah Trans'],
            xLabelAngle: 60
        });

        $('#tanggal').daterangepicker({
            "autoApply": true,
            locale: {
                format: 'DD/MM/YYYY'
            },
            "ranges": {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                "Last 7 Days": [moment().subtract(6, 'days'), moment()],
                "Last 30 Days": [moment().subtract(29, 'days'), moment()],
                "This Month": [moment().startOf('month'), moment().endOf('month')],
                "Last Month": [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "alwaysShowCalendars": true,
            //            "startDate": moment().subtract(6, 'days'),
            //            "endDate": moment()
        }, function (start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });

        $('input[name=tanggal]').change(function () {
            $('#filter-dashboard').submit();
        });
    }
</script>
