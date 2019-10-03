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
        width: 250px;
        min-height: 150px;
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
        width: 250px;
        height: 150px;
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
                    <button id="take_tutorial_false" type="button" class="btn btn-default" data-dismiss="modal">Tidak Terimakasih</button>
                    <button id="take_tutorial" type="button" class="btn btn-primary" data-dismiss="modal" >Ya</button>
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
</div>

<div id="tooltip_2" class="tooltip-arrow" style="top:340px;left: 247px;display: none;" >
    Klik Disini Untuk Memulai Menambah Kategori Produk
</div>

<div id="tooltip_3" class="tooltip-arrow-top" style="top:340px;left: 247px;display: none;" >
    Klik Disini Untuk Memulai Menambah Kategori Produk
</div>



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
            if (take_tutorial == '1') {
                $(".dark-container").show();
                $('#tooltip_1').show();
                $('#select_1').show();

                var first_click1 = 0;
                $(".dark-container").click(function () {
                    $('#tooltip_1').hide();
                    $('#select_1').hide();
                    $('#tooltip_2').hide();
                    $('#select_2').hide();

                    $(this).hide();
                    first_click1++;
                });

                var first_click = 0;
                $('#side_item_library').click(function () {
                    if (first_click == 0) {
                        $(".dark-container").show();
                        $('#tooltip_2').show();
                        $('#select_2').show();
                        first_click++;
                    }
                });
            }
        });

        var first_click2 = 0;
        uri_kategori = '<?= strtolower($this->uri->segment(2)) ?>';
        uri_kategori_segment = '<?= strtolower($this->uri->segment(3)) ?>';
        var take_tutorial = window.localStorage.getItem('take_tutorial');


        if (uri_kategori == 'kategori' && uri_kategori_segment == '' && take_tutorial == '1') {
            $(".dark-container").show();

            var select_top = $('#tambah_kategori').offset().top;
            var select_bottom = $('#tambah_kategori').offset().left;
            console.log(select_top);
            console.log(select_bottom);

            $('#select_2').css('left', select_bottom + 'px');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('height', '30px');
            $('#select_2').css('width', '126px');
            $('#select_2').show();

            $('#tooltip_3').css('top', '112px');
            $('#tooltip_3').css('left', 'auto');
            $('#tooltip_3').css('right', '5px');

            $('#tooltip_3').html('Klik Disini Untuk Menambah Kategori');
            $('#tooltip_3').show();

            $('.dark-container').click(function () {
                $(".dark-container").hide();
                $('#tooltip_3').hide();
                $('#select_2').hide();
            });


        }
        if (uri_kategori_segment == 'tambah_kategori' && take_tutorial == '1') {
            //            bsub
            var select_top = $('input[name=nama_kategori]').offset().top;
            var select_left = $('input[name=nama_kategori]').offset().left;
            var select_width = $('input[name=nama_kategori]').width();

            console.log(select_top);
            console.log(select_left);
            console.log(select_width);

            $(".dark-container").show();

            $('#select_2').css('left', select_left + 'px');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('height', '35px');
            $('#select_2').css('width', select_width + 'px');
            $('#select_2').show();

            $('#tooltip_3').css('top', select_top + 50 + 'px');
            $('#tooltip_3').css('left', select_left + 'px');
            $('#tooltip_3').css('right', '5px');
            $('#tooltip_3').html('Isikan Nama Kategori yang akan ditambahkan');
            $('#tooltip_3').show();

            var click_i = 0;
            $('.dark-container').click(function () {
                $('#tooltip_3').hide();

                var select_top = $('#bsub').offset().top;
                var select_left = $('#bsub').offset().left;
                console.log(select_top);
                console.log(select_left);

                $('#select_2').css('right', '');
                $('#select_2').css('left', select_left + 'px');
                $('#select_2').css('top', select_top + 'px');
                $('#select_2').css('height', '35px');
                $('#select_2').css('width', '75px');
                $('#select_2').show();

                $('#tooltip_2').css('top', (select_top - 70) + 'px');
                $('#tooltip_2').css('left', (select_left + 90) + 'px');
                $('#tooltip_2').html('Klik Di Sini Untuk Menyimpan');

                $('#tooltip_2').show();

                click_i++;
                if (click_i == 2) {
                    $('#tooltip_2').hide();
                    $('#select_2').hide();
                    $(".dark-container").hide();

                    window.localStorage.setItem('take_tutorial', 2);
                }
            });
        }
    });
</script>
<?php require_once 'template_script_sticky_produk.php'; ?>
