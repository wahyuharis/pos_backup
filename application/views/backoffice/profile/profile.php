<!--
<div class="wrapper">
    <div class="panel-body">
        <h4>Edit Profil Anda</h4>
        <hr/>
        <div class="form">
            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/profile/update">
                <div class="row">
                    <?php foreach ($profile as $row) : ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama Anda</label>
                                <input type="text" class="form-control" name="nama_user" value="<?php echo $row->nama_user; ?>" required>
                                <input type="text" style="display:none;" name="iduser" value="<?php echo $row->iduser; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Telp Anda</label>
                                <input type="text" id="telp" class="form-control" name="telp_user" onkeyup="checkPhone(); return false;" value="<?php echo $row->telp_user; ?>" required>
                                <div id="error-phone"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Email Anda</label>
                                <input type="text" class="form-control" name="email_user" value="<?php echo $row->email_user; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                <input type="password" id="type_pass" class="form-control" onkeyup="checkPass(); return false;" name="password">
                            </div>
                            <div id="error-nwl"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr/>
                <button type="submit" id="bsub" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
-->

<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-body">
            <h4>Edit Profil Anda</h4>
        </div>
    </div>

    <div class="form">
        <form id="validationForm" method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>backoffice/profile/update" autocomplete="off">
            <div class="row">
                <?php foreach ($profile as $row) : ?>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body same_height">
                                <div class="form-group">
                                    <label for="">Nama Anda</label>
                                    <div class=input-group>
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-id-card" aria-hidden="true"></i></div>
                                        <input type="text" class="form-control" name="nama_user" value="<?php echo $row->nama_user; ?>" required>
                                        <input type="text" style="display:none;" name="iduser" value="<?php echo $row->iduser; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Telp Anda</label>
                                    <div class=input-group>
                                        <div class="input-group-addon" style="background-color: white">+62</div>
                                        <input type="text" id="no-telp" class="form-control" name="telp_user" onkeyup="checkPhone(); return false;" value="<?php echo $row->telp_user; ?>" required>
                                    </div>
                                    <div id="error-phone"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <div class=input-group>
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-user" aria-hidden="true"></i></div>
                                        <input type="text" class="form-control" name="email_user" value="<?php echo $row->username; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body same_height">
                                <div class="form-group">
                                    <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                    <div class=input-group>
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                    <div class=input-group>
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                        <input type="password" id="type_pass" class="form-control" onkeyup="checkPass(); return false;" name="password">
                                    </div>
                                </div>
                                <div id="error-nwl"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function checkPass() {
        var pass1 = document.getElementById('password');
        var pass_new = document.getElementById('type_pass');
        var butt = document.getElementById('bsub');
        var message = document.getElementById('error-nwl');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";

        if (pass1.value == pass_new.value) {
            message.style.color = goodColor;
            message.innerHTML = "Password sudah cocok"
            butt.disabled = false;
        } else {
            message.style.color = badColor;
            message.innerHTML = " Password tidak cocok"
            butt.disabled = true;
            return;
        }
    }

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