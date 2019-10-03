<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Step 1 : Masukan Detail Bisnis Anda</h4>
        <hr/>
        <div class="form">
		  <?php
            $idpr = $this->session->userdata('prov_business');
            $idkb = $this->session->userdata('kab_business');
            $idkc = $this->session->userdata('kec_business');
            $idbt = $this->session->userdata('typ_business');
            $provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
            $regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
            $districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array();
            $btype = $this->db->query("SELECT * FROM businesstype_setup WHERE idtb='$idbt'")->row_array(); ?>
            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>owner/business/step1">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Bisnis</label>
                            <input type="text" class="form-control" name="nama_business" value="<?php echo $this->session->userdata('nama_business'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control">
                                <?php if ($idpr == NULL) {; ?>
                                    <option value="0">Pilih Provinsi</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                                <?php }; ?>
                                <?php foreach ($comprov as $rw) : ?>
                                    <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten-kota" class="form-control">
                                <?php if ($idkb == NULL) {; ?>
                                    <option value="0">Pilih Kabupaten</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kecamatan/Kota</label>
                            <select name="kecamatan" id="kecamatan" class="form-control">
                                <?php if ($idkc == NULL) {; ?>
                                    <option value="0">Pilih Kecamatan</option>
                                <?php } else {; ?>
                                    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea cols="30" rows="5" class="form-control" name="alamat_business"><?php echo $this->session->userdata('ala_business'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">No Telp</label>
                            <input type="text" class="form-control" name="tlp_bisnis" value="<?php echo $this->session->userdata('tlp_business'); ?>">
                        </div>
                        <div class="form-group">
                          <label>Logo Bisnis</label>
                          <div class="">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <?php if ($this->session->userdata('log_business') == NULL) {; ?>
                                  <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo base_url(); ?>picture/noimage.png" alt="" /></div>
                              <?php } else {; ?>
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo base_url(); ?>picture/<?php echo $this->session->userdata('log_business'); ?>" alt="" /></div>
                            <?php }; ?>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" id="logo" name="logo"></span>
                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Tipe Bisnis</label>
                    <select name="business_type" class="form-control">
                        <?php if ($idbt == NULL) {; ?>
                            <option value="0">Pilih Tipe Bisnis</option>
                        <?php } else {; ?>
                            <option value="<?php echo $btype['idtb']; ?>"><?php echo $btype['namatype_business']; ?></option>
                        <?php }; ?>
                        <?php foreach ($comtyp as $rw) : ?>
                            <option value="<?php echo $rw->idtb; ?>"><?php echo $rw->namatype_business; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea name="description_business" cols="30" rows="5" class="form-control"><?php echo $this->session->userdata('desc_business'); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="">Website</label>
                    <input type="text" class="form-control" name="website_business" value="<?php echo $this->session->userdata('web_business'); ?>">
                </div>
                <div class="form-group">
                    <label for="">Facebook</label>
                    <input type="text" class="form-control" name="facebook_business" value="<?php echo $this->session->userdata('fac_business'); ?>">
                </div>
                <div class="form-group">
                    <label for="">Instagram</label>
                    <input type="text" class="form-control" name="instagram_business" value="<?php echo $this->session->userdata('ins_business'); ?>">
                </div>
                <div class="form-group">
                    <label for="">Twitter</label>
                    <input type="text" class="form-control" name="twitter_business" value="<?php echo $this->session->userdata('twt_business'); ?>">
                </div>
                <div class="form-group">
                    <label for="">Email Bisnis</label>
                    <input type="text" class="form-control" name="email_business" value="<?php echo $this->session->userdata('email_business'); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <?php if ($this->session->userdata('unik_idbisnis') == NULL) {; ?>
                    <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" class="form-control" name="id_new" value="<?php echo $idbusiness; ?>" readonly>
                    </div>
                <?php } else {; ?>
                    <div class="form-group">
                        <label for="">ID</label>
                        <input type="text" class="form-control" name="id_new" value="<?php echo $this->session->userdata('unik_idbisnis'); ?>" readonly>
                    </div>
                <?php }; ?>
                <?php $stk = $this->session->userdata('stok_nb'); ?>
                <div class="form-group">
                    <label for="">Metode Stok</label>
                    <select name="stok" class="form-control">
                        <option value="0" <?php if ($stk == NULL) {
                                                echo "selected";
                                            }; ?>>Pilih Metode Stok</option>
                        <option value="1" <?php if ($stk == 1) {
                                                echo "selected";
                                            }; ?>>Tidak Pakai Stok</option>
                        <option value="2" <?php if ($stk == 2) {
                                                echo "selected";
                                            }; ?>>Pakai Stok</option>
                    </select>
                </div>
            </div>
        </div>
        <hr/>
        <button type="submit" class="btn btn-primary">Next Add Outlet ></button>
    </form>
</div>
</div>
</div>
-->

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Step 1 : Masukan Detail Bisnis Anda</h4>
        </div>
    </div>
    <?php
    $idpr = $this->session->userdata('prov_business');
    $idkb = $this->session->userdata('kab_business');
    $idkc = $this->session->userdata('kec_business');
    $idbt = $this->session->userdata('typ_business');
    $provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
    $regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
    $districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array();
    $btype = $this->db->query("SELECT * FROM businesstype_setup WHERE idtb='$idbt'")->row_array(); ?>
    <div class="form">
        <form id="form-business" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>owner/business/step1" autocomplete="off">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <div class="form-group">
                                <label for="">Nama Bisnis</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></div>
                                    <input type="text" placeholder="Nama Bisnis" class="form-control" name="nama_business" value="<?php echo $this->session->userdata('nama_business'); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Provinsi</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                                    <select name="provinsi" id="provinsi" class="form-control">
                                        <?php if ($idpr == NULL) {; ?>
                                            <option value="0">Pilih Provinsi</option>
                                        <?php } else {; ?>
                                            <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                                        <?php }; ?>
                                        <?php foreach ($comprov as $rw) : ?>
                                            <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Kabupaten</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                                    <select name="kabupaten" id="kabupaten-kota" class="form-control">
                                        <?php if ($idkb == NULL) {; ?>
                                            <option value="0">Pilih Kabupaten</option>
                                        <?php } else {; ?>
                                            <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Kecamatan/Kota</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                                    <select name="kecamatan" id="kecamatan" class="form-control">
                                        <?php if ($idkc == NULL) {; ?>
                                            <option value="0">Pilih Kecamatan</option>
                                        <?php } else {; ?>
                                            <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                        <?php }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea cols="30" rows="5" class="form-control" name="alamat_business"><?php echo $this->session->userdata('ala_business'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">No Telp</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white">+62</div>
                                    <input type="text" class="form-control" name="tlp_bisnis" value="<?php echo $this->session->userdata('tlp_business'); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Tipe Bisnis</label>
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
                                    <select name="business_type" class="form-control">
                                        <?php if ($idbt == NULL) {; ?>
                                            <option value="0">Pilih Tipe Bisnis</option>
                                        <?php } else {; ?>
                                            <option value="<?php echo $btype['idtb']; ?>"><?php echo $btype['namatype_business']; ?></option>
                                        <?php }; ?>
                                        <?php foreach ($comtyp as $rw) : ?>
                                            <option value="<?php echo $rw->idtb; ?>"><?php echo $rw->namatype_business; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <div class="form-group">
                                <label for="">Deskripsi</label>
                                <textarea name="description_business" cols="30" rows="5" class="form-control"><?php echo $this->session->userdata('desc_business'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Website</label>
                                <input type="text" class="form-control" name="website_business" value="<?php echo $this->session->userdata('web_business'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Facebook</label>
                                <input type="text" class="form-control" name="facebook_business" value="<?php echo $this->session->userdata('fac_business'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Instagram</label>
                                <input type="text" class="form-control" name="instagram_business" value="<?php echo $this->session->userdata('ins_business'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Twitter</label>
                                <input type="text" class="form-control" name="twitter_business" value="<?php echo $this->session->userdata('twt_business'); ?>">
                            </div>
                             <div class="form-group">
                                <label for="">Email Bisnis</label>
                                <input type="text" class="form-control" name="email_business" value="<?php echo $this->session->userdata('email_business'); ?>">
                            </div> 
                        </div>
                    </div>
                </div> -->

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body same_height">
                            <?php if ($this->session->userdata('unik_idbisnis') == NULL) {; ?>
                                <input type="hidden" class="form-control" name="id_new" value="<?php echo $idbusiness; ?>" readonly>
                                <!-- <div class="form-group">
                                    <label for="">ID</label>
                                </div> -->
                            <?php } else {; ?>
                                <input type="hidden" class="form-control" name="id_new" value="<?php echo $this->session->userdata('unik_idbisnis'); ?>" readonly>
                                <!-- <div class="form-group">
                                    <label for="">ID</label>
                                </div> -->
                            <?php }; ?>
                            <?php $stk = $this->session->userdata('stok_nb'); ?>
                            <div class="form-group">
                                <label for="">Metode Stok</label>
                                <select name="stok" class="form-control">
                                    <option value="" <?php if ($stk == NULL) {
                                                            echo "selected";
                                                        }; ?>>Pilih Metode Stok</option>
                                    <option value="1" <?php if ($stk == 1) {
                                                            echo "selected";
                                                        }; ?>>Tidak Pakai Stok</option>
                                    <option value="2" <?php if ($stk == 2) {
                                                            echo "selected";
                                                        }; ?>>Pakai Stok</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Logo Bisnis</label>
                                <div class="">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <?php if ($this->session->userdata('log_business') == NULL) {; ?>
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo base_url(); ?>picture/noimage.png" alt="" /></div>
                                        <?php } else {; ?>
                                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo base_url(); ?>picture/<?php echo $this->session->userdata('log_business'); ?>" alt="" /></div>
                                        <?php }; ?>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-file btn-primary"><span class="fileupload-new"><i class="fa fa-upload" aria-hidden="true"></i> Pilih Gambar</span>
                                                <span class="fileupload-exists"><i class="fa fa-edit" aria-hidden="true"></i> Ubah</span><input type="file" id="logo" name="logo"></span>
                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <button type="submit" id="bsub" class="btn btn-primary">Next Add Outlet <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

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

    $(function() {
        $('#form-business').validate({
            rules: {
                nama_business: {
                    required: true
                },
                alamat_business: {
                    required: true
                },
                provinsi: {
                    required: true
                },
                kabupaten: {
                    required: true
                },
                kecamatan: {
                    required: true
                },
                tlp_bisnis: {
                    required: true,
                    minlength: 9
                },
                business_type: {
                    required: true
                },
                stok: {
                    required: true
                }
            },
            messages: {
                nama_business: {
                    required: "Silahkan masukkan nama bisnis anda"
                },
                alamat_business: {
                    required: "Silahkan masukkan alamat bisnis anda"
                },
                provinsi: {
                    required: "Silahkan pilih provinsi"
                },
                kabupaten: {
                    required: "Silahkan pilih kabupaten"
                },
                kecamatan: {
                    required: "Silahkan pilih provinsi"
                },
                tlp_bisnis: {
                    required: "Silahkan masukkan nomor telephone",
                    minlength: "Format telephone salah",
                },
                business_type: {
                    required: "Silahkan pilih tipe bisnis anda"
                },
                stok: {
                    required: "Silahkan pilih metode stok"
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.css('color', '#ff6666');

                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },

            highlight: function(element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            },

            unhighlight: function(element, errorClass, validClass) {
                $(element).parents(".form-group").removeClass("has-error");
            },
        })
    })
    $("input[name='tlp_bisnis']").keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
</script>