<div class="wrapper">
    <div class="pull-right">
        <a class="btn btn-default btn-sm">Total : <?php echo $jum_tot; ?></a>
    </div>
    <div class="clearfix"></div>
    <br />
    <div class="row row-xs">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: visible;">
                    <div class="pull-left form-inline">
                        Halaman customer digunakan untuk melihat data customer yang membeli produk dari outlet anda.<br>
                        <form method="POST" action="<?php echo base_url(); ?>backoffice/customer">
                            <div class="input-group">
                                <select name="outlet" class="form-control" style="width: 150px;">
                                    <option value="">All Outlet</option>
                                    <?php foreach ($comout as $rw) : ?>
                                        <option value="<?php echo $rw->idoutlet; ?>"><?php echo $rw->name_outlet; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <select name="provinsi" id="provinsi" class="form-control" style="width: 150px;">
                                    <option value="">All Provinsi</option>
                                    <?php foreach ($comprov as $rw) : ?>
                                        <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <select name="kabupaten" id="kabupaten-kota" class="form-control" style="width: 150px;">
                                    <option value="">All Kabupaten</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <select name="kecamatan" id="kecamatan" class="form-control" style="width: 150px;">
                                    <option value="">All Kecamatan</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <select name="jumlah_data" class="form-control" style="width: 150px;">
                                    <option value="10000000000">Jumlah Data</option>
                                    <option value="10"> 10 </option>
                                    <option value="100"> 100 </option>
                                    <option value="1000"> 1000 </option>
                                </select>
                            </div>
                            <button class="btn btn-default" name="filter" type="submit">Filter</button>
                            <button class="btn btn-default" name="export" type="submit">Export</button>
                        </form>
                    </div>
                    <div class="pull-right form-inline">
                        <!--
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..">
                            <span class="input-group-btn">
                                <button class="btn btn-default"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered table-condensed table-strip">
                        <thead class="bg">
                            <tr>
                                <th width="10">No</th>
                                <th>Nama Customer</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Outlet</th>
                                <th>Kabupaten</th>
                                <th>Provinsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($customer as $row) : ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row->nama_pelanggan; ?></td>
                                    <td><?php echo $row->email_pelanggan; ?></td>
                                    <td><?php echo $row->telp_pelanggan; ?></td>
                                    <td>
                                        <?php $query = $this->db->query("SELECT name_outlet FROM outlet WHERE idoutlet='$row->idoutlet'"); ?>
                                        <?php foreach ($query->result_array() as $rw) echo $rw['name_outlet']; ?>
                                    </td>
                                    <td>
                                        <?php $query = $this->db->query("SELECT name FROM tb_regencies WHERE id='$row->regencies_id'"); ?>
                                        <?php foreach ($query->result_array() as $rw) echo $rw['name']; ?>
                                    </td>
                                    <td>
                                        <?php $query = $this->db->query("SELECT name FROM tb_provinces WHERE id='$row->province_id'"); ?>
                                        <?php foreach ($query->result_array() as $rw) echo $rw['name']; ?>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="<?php echo base_url(); ?>backoffice/customer/edit_customer/<?php echo $row->idctm; ?>" class="btn btn-default btn-xs">Edit</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete<?php echo $row->idctm; ?>">Delete</a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($customer as $row) : ?>
    <div class="modal fade" id="modal-delete<?php echo $row->idctm; ?>">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url(); ?>backoffice/customer/delete">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Data</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>
                            Apakah anda yakin ingin menghapus data ini?
                        </p>
                        <input type="text" name="idctm" value="<?php echo $row->idctm; ?>" style="display:none;" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('backoffice/customer/ambil_data'); ?>",
            cache: false,
        });
        $("#provinsi").change(function() {
            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kabupaten',
                        id: value
                    },
                    success: function(respond) {
                        $("#kabupaten-kota").html(respond);
                    }
                })
            }
        });
        $("#kabupaten-kota").change(function() {
            var value = $(this).val();
            if (value > 0) {
                $.ajax({
                    data: {
                        modul: 'kecamatan',
                        id: value
                    },
                    success: function(respond) {
                        $("#kecamatan").html(respond);
                    }
                })
            }
        })
    })
</script>