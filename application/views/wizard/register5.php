<div class="login-form">
    <?php
    $idpr = $this->session->userdata('prov_out');
    $idkb = $this->session->userdata('kab_out');
    $idkc = $this->session->userdata('kec_out');
    $provinces = $this->db->query("SELECT * FROM tb_provinces WHERE id='$idpr'")->row_array();
    $regencies = $this->db->query("SELECT * FROM tb_regencies WHERE id='$idkb'")->row_array();
    $districts = $this->db->query("SELECT * FROM tb_districts WHERE id='$idkc'")->row_array(); ?>
    <form method="POST" id="validationForm" class="form form-login" action="<?php echo base_url(); ?>home/step5">
        <h2>Step 5/7 : Outlet Anda</h2>
        <div class="form-group">
            <label for="">Nama Outlet/Kantor</label>
            <div class="input-group">
                <div class="input-group-addon" style="background-color: white"><i class="fa fa-building-o" aria-hidden="true"></i></div>
                <input type="text" name="nama_out" value="<?php echo $this->session->userdata('nama_out'); ?>" class="form-control" placeholder="Nama Outlet" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Provinsi Outlet/Kantor</label>
                    <div class="input-group">
                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                        <select name="provinsi" id="provinsi" onchange="selectWilayah()" class="form-control">
                            <?php if ($idpr == NULL) {; ?>
                                <option value="0">-- Pilih Provinsi --</option>
                            <?php } else {; ?>
                                <option value="<?php echo $provinces['id']; ?>"><?php echo $provinces['name']; ?></option>
                            <?php }; ?>
                            <?php foreach ($comprov as $rw) : ?>
                                <option value="<?php echo $rw->id; ?>"><?php echo $rw->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Kabupaten Outlet/Kantor</label>
                    <div class="input-group">
                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                        <select name="kabupaten" id="kabupaten-kota" onchange="selectWilayah()" class="form-control">
                            <?php if ($idkb == NULL) {; ?>
                                <option value="0">-- Pilih Kabupaten --</option>
                            <?php } else {; ?>
                                <option value="<?php echo $regencies['id']; ?>"><?php echo $regencies['name']; ?></option>
                            <?php }; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Kecamatan/Kota Outlet</label>
                    <div class="input-group">
                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                        <select name="kecamatan" id="kecamatan" onchange="selectWilayah()" class="form-control">
                            <?php if ($idkc == NULL) {; ?>
                                <option value="">-- Pilih Kecamatan --</option>
                            <?php } else {; ?>
                                <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                            <?php }; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Kode Pos (Zip) Outlet/Kantor</label>
                    <div class="input-group">
                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-telegram" aria-hidden="true"></i></div>
                        <input type="text" maxlength="5" name="zip" value="<?php echo $this->session->userdata('zip_out'); ?>" placeholder="Kodepos" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">Alamat Outlet/Kantor</label>
            <textarea name="alamat" cols="30" rows="5" class="form-control" required><?php echo $this->session->userdata('ala_out'); ?></textarea>
        </div>
        <?php $pjk = $this->session->userdata('pjk_out'); ?>
        <div class="form-group">
            <label for="">Pajak</label>
            <div class="input-group">
                <div class="input-group-addon" style="background-color: white"><i class="fa fa-tags" aria-hidden="true"></i></div>
                <select name="tax" class="form-control" required>
                    <option value="" <?php if ($pjk == "0") echo 'selected'; ?>>-- Pilih Metode Pajak --</option>
                    <option value="0" <?php if ($pjk == "0") echo 'selected'; ?>>Tidak Kena Pajak</option>
                    <option value="2" <?php if ($pjk == "2") echo 'selected'; ?>>Pajak Per Transaksi</option>
                </select>
            </div>
        </div>
        <br />

        <div class="form-group">
            <a href="<?php echo base_url(); ?>home/register4" class="btn btn-default">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a> <button class="btn btn-primary" id="bsub" <?php if (($idpr == NULL) || ($idkb == NULL) || ($idkc == NULL)) {; ?>style="display:none;" <?php }; ?> type="submit">Next Input Backoffice <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            type: "POST",
            url: "<?php echo base_url('home/ambil_data'); ?>",
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

        $('#validationForm').validate({
            rules: {
                nama_out: {
                    required: true
                },
                alamat: {
                    required: true
                },
                tax: {
                    required: true
                }
            },
            messages: {
                nama_out: {
                    required: "Silahkan isi nama outlet"
                },
                alamat: {
                    required: "Silahkan isi alamat outlet"
                },
                tax: {
                    required: "Silahkan pilih metode pajak"
                },
            },

            errorElement: "em",
            errorPlacement: function(error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.css('color', '#ff6666');

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent("label"));
                } else if (element.parent('.input-group').length) {
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
            }
        });

        $("input[name='zip']").keypress(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    })
</script>

<script type="text/javascript">
    function checkPhone() {
        var phone = document.getElementById('telp');
        var butt = document.getElementById('bsub');
        var message = document.getElementById('error-phone');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";

        if (phone.value.length >= 10) {
            message.style.color = goodColor;
            message.innerHTML = "No telephone sudah memenuhi syarat"
            butt.disabled = false;
        } else {
            message.style.color = badColor;
            message.innerHTML = "No telephone minimal 10 digit"
            butt.disabled = true;
            return;
        }
    }
</script>
<script type="text/javascript">
    function selectWilayah() {
        var e = document.getElementById("provinsi");
        var provinsi = e.options[e.selectedIndex].value;

        var e = document.getElementById("kabupaten-kota");
        var kabupaten = e.options[e.selectedIndex].value;

        var e = document.getElementById("kecamatan");
        var kecamatan = e.options[e.selectedIndex].value;

        var sub = document.getElementById('bsub');

        if ((provinsi != "0") && (kabupaten != "0") && (kecamatan != "0")) {
            sub.style.display = "inline";
        } else {
            sub.style.display = "none";
        }
    }
</script>