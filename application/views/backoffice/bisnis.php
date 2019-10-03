<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Bisnis</h4>
        </div>
        <div class="panel-body">
            <div class="form">
                <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/bisnis/update_bisnis">
                    <div class="row">
                        <?php foreach ($bisnis as $row) : ?>
                            <?php
                                $tb = $this->db->query("SELECT namatype_business FROM businesstype_setup WHERE idtb='$row->idtb'")->row_array();
                                $provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$row->province_id'")->row_array();
                                $regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$row->regencies_id'")->row_array();
                                $districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$row->district_id'")->row_array();
                                ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Bisnis</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="nama_business" value="<?php echo $row->nama_business; ?>">
                                        <input type="hidden" class="form-control" name="unik_id" value="<?php echo $row->register_business; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Provinsi</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
                                        <select name="provinsi" id="provinsi" class="form-control">
                                            <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                                            <?php foreach ($comprov as $rw) : ?>
                                                <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kabupaten</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
                                        <select name="kabupaten" id="kabupaten-kota" class="form-control">
                                            <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kecamatan/Kota</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></span>
                                        <select name="kecamatan" id="kecamatan" class="form-control">
                                            <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea cols="30" rows="5" class="form-control" name="alamat_business"><?php echo $row->alamat_business; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">No Telp</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white">+62</span>
                                        <input type="text" class="form-control" id="no-telp" name="tlp_bisnis" value="<?php echo $row->tlp_business; ?>">
                                    </div>
                                </div>
                            </div>
                            <?php $type_bus = $row->idtb; ?>
                            <!-- <div class="col-md-4">                                                         
                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea name="description_business" cols="30" rows="5" class="form-control"><?php echo $row->description_business; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Website</label>
                                    <input type="text" class="form-control" name="website_business" value="<?php echo $row->website_business; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Facebook</label>
                                    <input type="text" class="form-control" name="facebook_business" value="<?php echo $row->facebook_business; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Instagram</label>
                                    <input type="text" class="form-control" name="instagram_business" value="<?php echo $row->instagram_business; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Twitter</label>
                                    <input type="text" class="form-control" name="twitter_business" value="<?php echo $row->twitter_business; ?>">
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <!-- <div class="form-group">
                                    <label for="">ID</label>
                                    <input type="text" class="form-control" name="unik_id" value="<?php echo $row->register_business; ?>" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="">Tipe Bisnis</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="tpbusiness" value="<?php echo $tb['namatype_business']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Logo Bisnis</label>
                                    <div class="">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo base_url(); ?>picture/150/<?php echo $row->img_business; ?>" alt="" /></div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new"> <i class="icon fa fa-picture-o"></i> Pilih Gambar</span><span class="fileupload-exists">Change</span><input type="file" id="logo" name="logo"></span>
                                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-primary"> <i class="icon fa fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="success">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <div class="modal-body text-center">
                <i class="fa fa-check-circle-o fa-5x text-warning"></i>
                <br /><br />
                <p>
                    Data Berhasil Disimpan
                </p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#<?php echo $message; ?>").modal('show');

        setTimeout(function() {
            $('#<?php echo $message; ?>').modal('hide');
        }, 2000);
    });
</script>
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('backoffice/bisnis/ambil_data'); ?>",
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
        $('#no-telp').focusout(function() {
            function phoneFormat() {
                phone = phone.replace(/[^0-9]/g, '');
                phone = phone.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
                return phone;
            }
            var phone = $(this).val();
            phone = phoneFormat(phone);
            $(this).val(phone);
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