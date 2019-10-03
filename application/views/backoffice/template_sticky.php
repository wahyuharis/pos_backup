<style>
    .dark-container{
        position: fixed;
        width: 100%;
        height: 100%;
        top:0px;
        left:0px;
        background-color: #585858;
        opacity: 0.3;
        z-index: 999;
    }
    .box-select {
        border: 1px solid #fff;
        background-color: #fff;
        width: 238px;
        height: 45px;
        position: fixed;
        top: 322px;
    }
    .tooltip-arrow {
        background: #fff;
        border-radius: 10px;
        padding: 10px 10px;
        display: inline-block;
        position: fixed;
        top: 259px;
        width: 300px;
        min-height: 170px;
        background-color: #fff;
        color: #595959;
        z-index: 1000
    }
    .tooltip-arrow:before {
        content:"";
        position: absolute;
        height: 0px;
        width: 0px;
        top: 60px;
        left: -29px; /* 1px buffer for zooming problems while rendering*/
        border-width: 15px;
        border-color: transparent #fff transparent transparent;
        border-style: solid;
    }

    .tooltip-arrow-top {
        background: #fff;
        border-radius: 10px;
        padding: 10px 10px;
        display: inline-block;
        position: fixed;
        top: 259px;
        width: 300px;
        height: 170px;
        background-color: #fff;
        color: #595959;
        z-index: 1000
    }
    .tooltip-arrow-top:before {
        top: -15px;
        right: 15px;
        content: "";
        position: absolute;
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-bottom: 25px solid #fff;    
    }
    .tooltip-step{
        position: absolute;
        bottom: 0px;
        right: 10px;
    }
    .saya-mengerti{
        position: absolute;
        bottom: 8px;
        left: 10px;
    }
    .next-tooltip{
        position: absolute;
        bottom: 8px;
        left: 100px;
    }
</style>

<div class="modal fade" id="notif-tutorial" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selamat Datang di AIO POS</h4>
            </div>
            <div class="modal-body">
                <p>Kami menyediakan bantuan untuk memberi tutorial dasar menggunakan aplikasi ini, silakan klik ya jika ingin tutorial</p>
                <h4>Butuh Tutorial ?</h4>
            </div>
            <div class="modal-footer">
                <div class="row col-md-6">
                    <div class="checkbox pull-left">
                        <label style="color: red"><input id="jangan_tampil_lagi" type="checkbox" > Jangan Tampilkan Lagi</label>
                    </div>                  
                </div>
                <div class="row col-md-6">
                    <button id="take_tutorial" type="button" class="btn btn-info" data-dismiss="modal" >Ya</button>
                    <button id="take_tutorial_false" type="button" class="btn btn-success" data-dismiss="modal">Tidak Terimakasih</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="dark-container" style="display: none" >
    <div id="select_1" class="box-select" style="display: none;left: 0px;" ></div>
    <div id="select_2" class="box-select" style="top: 400px;display: none;left: 0px;" ></div>
</div>

<div id="tooltip_1" class="tooltip-arrow" style="display: none;left: 247px;">
    Klik Disini Untuk Memulai Menambah Produk Yang Anda Jual,
    Menambah Kategory, Variant, Manajemen Stok dan lain lain.
    <!--<p class="tooltip-step" ></p>-->
</div>

<div id="tooltip_2" class="tooltip-arrow" style="top:340px;left: 247px;display: none;" >
    Klik Disini Untuk Memulai Menambah Kategori Produk
    <!--<p class="tooltip-step" ></p>-->
</div>

<div id="tooltip_3" class="tooltip-arrow-top" style="top:340px;left: 247px;display: none;" >
    Klik Disini Untuk Memulai Menambah Kategori Produk
</div>
<?php $max_step = 23; ?>


<script>
    $(document).ready(function () {
        $('.sub-menu.active').parent().css('display', 'block');
        $('#sticky_allow').click(function () {
            window.localStorage.setItem('jangan_tampil_lagi', '0');
            window.location = '<?= base_url() . 'backoffice/dashboard' ?>';
        });
    });


    $(window).on('load', function () {
        modal_take_totorial = '<?= strtolower($this->uri->segment(2)) ?>';
        jangan_tampil_lagi = window.localStorage.getItem('jangan_tampil_lagi');
        if (modal_take_totorial == 'dashboard' && jangan_tampil_lagi != '1') {
            $('#notif-tutorial').modal('show');
        }

        $('#take_tutorial').click(function () {
            window.localStorage.setItem('take_tutorial', '1');
            window.localStorage.setItem('step', '1');
        });

        $('#take_tutorial_false').click(function () {
            window.localStorage.setItem('take_tutorial', '0');
        });

        $('#jangan_tampil_lagi').change(function () {
            if ($(this).prop('checked')) {
                window.localStorage.setItem('jangan_tampil_lagi', '1');
            } else {
                window.localStorage.setItem('jangan_tampil_lagi', '0');
            }
        });

        $('#notif-tutorial').on('hidden.bs.modal', function () {
            take_tutorial = window.localStorage.getItem('take_tutorial');
            step = window.localStorage.getItem('step');

            if (take_tutorial == '1' && step == '1') {

                var select_top = $('#karyawan_side').offset().top;
                var select_left = $('#karyawan_side').offset().left;
                var select_width = $('#karyawan_side').width();
                var select_heigth = $('#karyawan_side').height();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);
                console.log(select_heigth);

                $('#select_1').css('height', select_heigth + 'px');
                $('#select_1').css('width', select_width + 'px');
                $('#select_1').css('top', select_top + 'px');
                $('#select_1').css('left', select_left + 'px');

                $('#tooltip_1').css('top', select_top - 60 + 'px');


                $(".dark-container").show();
                $('#tooltip_1').append('<p class="tooltip-step" >Step 1/<?= $max_step ?></p>');
                $('#tooltip_1').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                $('#tooltip_1').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                $('#tooltip_1').show();
                $('#select_1').show();

                $(".next-tooltip").click(function () {
                    $('#tooltip_1').hide();
                    $('#select_1').hide();
                    $('#tooltip_2').hide();
                    $('#select_2').hide();
                    $(".dark-container").hide();
                    window.localStorage.setItem('step', '2');
                });
            }
        });


        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';

        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');

        if (uri_segment + '/' + uri_segment2 == 'user/') {
            if (take_tutorial == '1' && step == '2') {
                var select_top = $('#tambah_karyawan').offset().top;
                var select_left = $('#tambah_karyawan').offset().left;
                var select_width = $('#tambah_karyawan').width();
                var select_heigth = $('#tambah_karyawan').height();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);
                console.log(select_heigth);

                $('#select_2').css('left', select_left + 'px');
                $('#select_2').css('top', select_top + 'px');
                $('#select_2').css('height', 30 + 'px');
                $('#select_2').css('width', 134 + 'px');
                $('#select_2').show();

                $('#tooltip_3').css('top', (select_top + 60) + 'px');
                $('#tooltip_3').css('left', 'auto');
                $('#tooltip_3').css('right', '50px');

                $(".dark-container").show();
                $('#tooltip_3').html('Klik Disini Untuk Menambah Karyawan Sebagai Kasir dan Backoffice');
                $('#tooltip_3').append('<p class="tooltip-step" >Step 2/<?= $max_step ?></p>');
                $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                $('#tooltip_3').show();

                $(".next-tooltip").click(function () {
                    $('#tooltip_3').hide();
                    $('#select_2').hide();
                    $(".dark-container").hide();
                    window.localStorage.setItem('step', '3');
                });
            }
        }

        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';

        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');

        if (uri_segment + '/' + uri_segment2 == 'user/tambah_user') {

            if (take_tutorial == '1' && step == '3') {

                var select_top = $('input[name=username]').offset().top;
                var select_left = $('input[name=username]').offset().left;
                var select_width = $('input[name=username]').outerWidth();
                var select_heigth = $('input[name=username]').outerHeight();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);
                console.log(select_heigth);

                $('#select_2').css('left', select_left + 'px');
                $('#select_2').css('top', select_top + 'px');
                $('#select_2').css('height', select_heigth + 'px');
                $('#select_2').css('width', select_width + 'px');
                $('#select_2').show();

                $(".dark-container").show();

                $('#tooltip_3').css('top', (select_top + 60) + 'px');
                $('#tooltip_3').css('left', select_left + 'px');

                $(".dark-container").show();
                $('#tooltip_3').html('Isi field ini untuk username yang akan digunakan pada karyawan kasir atau backoffice');
                $('#tooltip_3').append('<p class="tooltip-step" >Step 3/<?= $max_step ?></p>');
                $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                $('#tooltip_3').show();

                $(".next-tooltip").click(function () {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (take_tutorial == '1') {
                        var select_top = $('input[name=password]').offset().top;
                        var select_left = $('input[name=password]').offset().left;
                        var select_width = $('input[name=password]').outerWidth();
                        var select_heigth = $('input[name=password]').outerHeight();

                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', select_heigth + 'px');
                        $('#select_2').css('width', select_width + 'px');

                        $('#tooltip_3').css('top', (select_top + 60) + 'px');
                        $('#tooltip_3').css('left', select_left + 'px');

                        $('#tooltip_3').html('Isikan pula passwordnya, lalu ulangi pada field dibawah');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 4/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                    }


                    $(".next-tooltip").click(function () {
                        $('#tooltip_3').hide();

                        var select_top = $('select[name=role]').offset().top;
                        var select_left = $('select[name=role]').offset().left;
                        var select_width = $('select[name=role]').outerWidth();
                        var select_heigth = $('select[name=role]').outerHeight();

                        console.log(select_top);
                        console.log(select_left);
                        console.log(select_width);
                        console.log(select_heigth);

                        take_tutorial = window.localStorage.getItem('take_tutorial');

                        if (take_tutorial == '1') {
                            $('#select_2').css('top', select_top + 'px');
                            $('#select_2').css('left', select_left + 'px');
                            $('#select_2').css('height', select_heigth + 'px');
                            $('#select_2').css('width', select_width + 'px');
                            $('#select_2').show();

                            $('#tooltip_2').html('Role adalah jabatan untuk user karyawan yang akan ditambahkan pilih kasir atau backoffice');
                            $('#tooltip_2').append('<p class="tooltip-step" >Step 5/<?= $max_step ?></p>');
                            $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                            $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');


                            $('#tooltip_2').css('top', (select_top) - 80 + 'px');
                            $('#tooltip_2').css('left', select_left + select_width + 20 + 'px');
                            $('#tooltip_2').show();
                        }

                        $(".next-tooltip").click(function () {
//                            $('#select_2').hide();
//                            $('#tooltip_2').hide();
//                            $(".dark-container").hide();

                            var select_top = $('#bsub').offset().top;
                            var select_left = $('#bsub').offset().left;
                            var select_width = $('#bsub').outerWidth();
                            var select_heigth = $('#bsub').outerHeight();

                            console.log(select_top);
                            console.log(select_left);
                            console.log(select_width);
                            console.log(select_heigth);

                            take_tutorial = window.localStorage.getItem('take_tutorial');

                            if (take_tutorial == '1') {
                                $('#select_2').css('top', select_top + 'px');
                                $('#select_2').css('left', select_left + 'px');
                                $('#select_2').css('height', select_heigth + 'px');
                                $('#select_2').css('width', select_width + 'px');
                                $('#select_2').show();

                                $('#tooltip_2').html('Jika Semua Field Telah diisi lalu klik simpan');
                                $('#tooltip_2').append('<p class="tooltip-step" >Step 6/<?= $max_step ?></p>');
                                $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');


                                $('#tooltip_2').css('top', (select_top - 150) + 'px');
                                $('#tooltip_2').css('left', select_left + 100 + 'px');
                                $('#tooltip_2').show();

                                $(".next-tooltip").click(function () {
                                    window.localStorage.setItem('step', '4');
                                    $('#select_2').hide();
                                    $('#tooltip_2').hide();
                                    $(".dark-container").hide();
                                });
                            }
                        });
                    });


                });
            }
        }
    });
</script>
<?php require_once 'template_sticky2.php'; ?>

