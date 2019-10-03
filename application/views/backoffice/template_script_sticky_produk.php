<script>
    $(window).on('load', function () {
        var take_tutorial = window.localStorage.getItem('take_tutorial');
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        if (take_tutorial == '2' && uri_segment == 'kategori') {
            $(".dark-container").show();

            $('#select_2').css('right', '');
            $('#select_2').css('top', '359px');
            $('#select_2').css('left', '0px');
            $('#select_2').css('height', '43px');
            $('#select_2').css('width', '241px');
            $('#select_2').show();

            $('#tooltip_2').css('top', '300px');
            $('#tooltip_2').css('left', '255px');
            $('#tooltip_2').html('Silakan Klik PRODUK untuk menambah produk');
            $('#tooltip_2').append('<p class="tooltip-step" >Step 6/<?= $max_step ?></p>');
            $('#tooltip_2').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_2').show();

//
            $('.dark-container').click(function () {
                $('#tooltip_2').hide();
                $('#select_2').hide();
                $(".dark-container").hide();
            });
        }
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment_list = '<?= strtolower($this->uri->segment(3)) ?>';
        var take_tutorial = window.localStorage.getItem('take_tutorial');

        if (take_tutorial == '2' && uri_segment == 'produk' && uri_segment_list == '') {
            $(".dark-container").show();

            var select_top = $('#create_produk').offset().top;
            var select_left = $('#create_produk').offset().left;

            console.log(select_top);
            console.log(select_left);


            $('#select_2').css('left', select_left + 'px');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('right', '');
            $('#select_2').css('height', '32px');
            $('#select_2').css('width', '123px');
            $('#select_2').show();

            $('#tooltip_3').css('left', select_left - 200 + 'px');
            $('#tooltip_3').css('top', select_top + 50 + 'px');
//            $('#tooltip_3').css('right', select_le + 'px');
            $('#tooltip_3').html('Klik TAMBAH PRODUK untuk menambahkan produk baru');
            $('#tooltip_3').append('<p class="tooltip-step" >Step 7/<?= $max_step ?></p>');
            $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_3').show();

            $('.dark-container').click(function () {
                $('#tooltip_3').hide();
                $('#select_2').hide();
                $(".dark-container").hide();
            });
        }

        var take_tutorial = window.localStorage.getItem('take_tutorial');
        if (take_tutorial == '2' && uri_segment == 'produk' && uri_segment_list == 'tambah_produk') {
            $(".dark-container").show();

            var select_top = $('input[name=nama_produk]').offset().top;
            var select_left = $('input[name=nama_produk]').offset().left;
            var select_width = $('input[name=nama_produk]').width();
            var select_heigth = $('input[name=nama_produk]').height();

            console.log(select_top);
            console.log(select_left);
            console.log(select_width);
            console.log(select_heigth);

            $('#select_2').css('left', '');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('left', select_left + 'px');
            $('#select_2').css('height', '35px');
            $('#select_2').css('width', select_width + 20 + 'px');
            $('#select_2').show();

            $('#tooltip_2').css('top', '127px');
            $('#tooltip_2').css('left', select_left + select_width + 40 + 'px');
            $('#tooltip_2').html("Silakan isi Nama Produk (Wajib)");
            $('#tooltip_2').append('<p class="tooltip-step" >Step 7/<?= $max_step ?></p>');
            $('#tooltip_2').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_2').show();

            var first_click = 0;
            $('.dark-container').click(function () {
                first_click++;

                if (first_click >= 1 && first_click < 2) {
                    var select_top = $('select[name=kategori]').offset().top;
                    var select_left = $('select[name=kategori]').offset().left;
                    var select_width = $('select[name=kategori]').width();
                    var select_heigth = $('select[name=kategori]').height();

                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('left', '');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', select_width + 20 + 'px');

                        $('#tooltip_2').css('top', (select_top - 65) + 'px');
                        $('#tooltip_2').css('left', select_left + select_width + 40 + 'px');
                        $('#tooltip_2').html("Silakan Pilih kategori (Wajib)");
                        $('#tooltip_2').append('<p class="tooltip-step" >Step 8/<?= $max_step ?></p>');
                        $('#tooltip_2').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                    }
                }


                if (first_click >= 2 && first_click < 3) {
                    var select_top = $('#tb-outlet-list').offset().top;
                    var select_left = $('#tb-outlet-list').offset().left;
                    var select_width = $('#tb-outlet-list').width();
                    var select_heigth = $('#tb-outlet-list').height();

                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {

                        $('#select_2').css('left', '');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('height', select_heigth + 'px');
                        $('#select_2').css('width', select_width + 20 + 'px');

                        $('#tooltip_2').css('top', (select_top - 65) + 'px');
                        $('#tooltip_2').css('left', select_left + select_width + 40 + 'px');
                        $('#tooltip_2').html("Silakan Pilih Salah satu atau lebih outlet");
                        $('#tooltip_2').append('<p class="tooltip-step" >Step 9/<?= $max_step ?></p>');
                        $('#tooltip_2').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                    }
                }


                if (first_click >= 3 && first_click < 4) {
                    var select_top = $('select[name=variant]').offset().top;
                    var select_left = $('select[name=variant]').offset().left;
                    var select_width = $('select[name=variant]').width();
                    var select_heigth = $('select[name=variant]').height();

                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {

                        $('#select_2').css('left', '');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('height', 35 + 'px');
                        $('#select_2').css('width', select_width + 20 + 'px');

                        $('#tooltip_2').hide();


                        $('#tooltip_3').show();
                        $('#tooltip_3').css('top', (select_top + 60) + 'px');
                        $('#tooltip_3').css('left', select_left + 'px');
                        $('#tooltip_3').html("Silakan Tentukan Apakah Produk Memiliki variant atau tidak<br>" +
                                "Lalu isi variant jika produk memiliki variant<br>"
                                );
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 10/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                    }
                }

                if (first_click >= 4 && first_click < 5) {
//                    $('#tooltip_2').hide();
                    $('#tooltip_3').hide();
                    $('#select_2').hide();


                    $(".dark-container").hide();
                    window.localStorage.setItem('take_tutorial', '3');
                }

            });
        }
    });
</script>
<?php require_once 'template_script_sticky_report.php'; ?>