<div class="wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Profil Anda</h4>
        </div>
        <div class="panel-body">
            <div class="form">
                <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>owner/profile/update">
                    <div class="row">
                        <?php foreach ($profile as $row) : ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nama Owner</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-id-card" aria-hidden="true"></i></div>
                                        <input type="text" class="form-control" name="nama_owner" value="<?php echo $row->nama_user; ?>" required>
                                        <input type="text" style="display:none;" name="idowner" value="<?php echo $row->idowner; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Telp Owner</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background-color: white">+62</div>
                                        <input type="text" id="no-telp" class="form-control" name="telp_owner" onkeyup="checkPhone(); return false;" value="<?php echo $row->telp_user; ?>" required>
                                    </div>
                                    <div id="error-phone"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Email Owner</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                                        <input type="text" class="form-control" name="telp_owner" value="<?php echo $row->email_user; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Password *<small>Jangan Diisi Jika Tidak Ingin Merubah</small></label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background-color: white"><i class="fa fa-unlock-alt" aria-hidden="true"></i></div>
                                        <input type="password" id="type_pass" class="form-control" onkeyup="checkPass(); return false;" name="password">
                                    </div>
                                </div>
                                <div id="error-nwl"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <hr />
                    <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
                </form>
            </div>
        </div>
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