<style>
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><?= $isi ?></h4>
    </div>
    <div class="panel-body">
        <!-- <hr /> -->
        <div class="form">
            <?= form_open_multipart('', '  id="validationForm"  ') ?>
            <?= form_hidden('idbusiness', $form['id']) ?>
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Business Description</label>
                        <?= form_textarea('business_description', $form['business_description'], ' class="form-control" style="height:100px" ') ?>
                    </div>
                </div> 
            </div> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Bisnis</label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
                            <?= form_input('business_name', $form['business_name'], ' class="form-control" ') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Provinsi </label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                            <?= form_dropdown('province', $form['opt_provinces'], $form['province'], ' class="form-control" id="province_id" ') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kota</label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                            <?= form_dropdown('regency', $form['opt_regencies'], $form['regency'], ' class="form-control"  id="regency_id" ') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kecamatan</label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white"><i class="fa fa-home" aria-hidden="true"></i></div>
                            <?= form_dropdown('district', $form['opt_districts'], $form['district'], ' class="form-control"   id="district_id"  ') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <?= form_textarea('alamat', $form['alamat'], ' class="form-control" style="height:100px" ') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Telepon</label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white">+62</div>
                            <?= form_input('tlp_business', $form['tlp_business'], ' id="no-telp" class="form-control" ') ?>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Website Business </label>
                        <?= form_input('website_business', $form['website_business'], ' class="form-control" ') ?>
                    </div>
                    <div class="form-group">
                        <label for="">Instagram Business </label>
                        <?= form_input('instagram_business', $form['instagram_business'], ' class="form-control" ') ?>
                    </div>
                    <div class="form-group">
                        <label for="">Twitter Business </label>
                        <?= form_input('twitter_business', $form['twitter_business'], ' class="form-control" ') ?>
                    </div>
                    <div class="form-group">
                        <label for="">Facebook Business </label>
                        <?= form_input('facebook_business', $form['facebook_business'], ' class="form-control" ') ?>
                    </div> -->
                    <div class="form-group">
                        <label for="">Tipe Business </label>
                        <div class=input-group>
                            <div class="input-group-addon" style="background-color: white"><i class="fa fa-building" aria-hidden="true"></i></div>
                            <?= form_input('tb', $form['idtb'], ' class="form-control" disabled') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <label for="">Logo Business </label>
                                <div class="thumbnail">
                                    <a href="#" style="text-decoration: none;">
                                        <img id="img-show" src="<?= $form['img_show'] ?>" alt="Lights" style="width:55%">
                                        <div class="caption">
                                            <b></p></b>
                                            <p></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <div class="row" style="text-align: center">
                            <div class="upload-btn-wrapper">
                                <button class="btn btn-primary"><i class="fa fa-photo"></i> Ganti</button>
                                <?= form_upload('img_business', 'Foto', ' id="img_business" ') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />
            <a href="<?= base_url() . '/owner/business/' ?>" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
            <button type="submit" id="bsub" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    function show_before_upload(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-show').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img_business").change(function() {
        show_before_upload(this);
    });

    $("#province_id").change(function() {
        var value = $(this).val();
        if (value > 0) {
            $.ajax({
                url: '<?= base_url() ?>owner/business/ambil_data/',
                data: {
                    modul: 'kabupaten',
                    id: value
                },
                success: function(respond) {
                    $("#regency_id").html(respond);
                }
            });
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

    $("#regency_id").change(function() {
        var value = $(this).val();
        if (value > 0) {
            $.ajax({
                url: '<?= base_url() ?>owner/business/ambil_data/',
                data: {
                    modul: 'kecamatan',
                    id: value
                },
                success: function(respond) {
                    $("#district_id").html(respond);
                }
            });
        }
    });
</script>