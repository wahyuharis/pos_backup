<script>
    $(window).on('load', function () { 
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';

        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');


        if ((uri_segment + '/' + uri_segment2 == 'produk/tambah_produk') && take_tutorial == '1' && step == '7') {
            var select_top = $('select[name=kategori]').offset().top;
            var select_left = $('select[name=kategori]').offset().left;
            var select_width = $('select[name=kategori]').parent().outerWidth();
            var select_heigth = $('select[name=kategori]').parent().outerHeight();

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
            $('#tooltip_3').html('Pilih kategori, ada klik tombol ( + ) dibagian kanan jika kategori masih kosong. Akan muncul popup untuk menambah kategori');
            $('#tooltip_3').append('<p class="tooltip-step" >Step 10/<?= $max_step ?></p>');
            $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
            $('#tooltip_3').show();

            $(".next-tooltip").click(function () {
                $('#select_2').hide();
                $('#tooltip_3').hide();
                $(".dark-container").show();
                take_tutorial = window.localStorage.getItem('take_tutorial');
                if (take_tutorial == '1') {
                    var select_top = $('input[name=nama_produk]').offset().top;
                    var select_left = $('input[name=nama_produk]').offset().left;
                    var select_width = $('input[name=nama_produk]').outerWidth();
                    var select_heigth = $('input[name=nama_produk]').outerHeight();

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
                    $('#tooltip_3').html('Isikan Nama Produk');
                    $('#tooltip_3').append('<p class="tooltip-step" >Step 11/<?= $max_step ?></p>');
                    $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                    $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                    $('#tooltip_3').show();

                    $(".next-tooltip").click(function () {
                        take_tutorial = window.localStorage.getItem('take_tutorial');

                        if (take_tutorial == '1') {
                            var select_top = $('input[name=sku]').offset().top;
                            var select_left = $('input[name=sku]').offset().left;
                            var select_width = $('input[name=sku]').outerWidth();
                            var select_heigth = $('input[name=sku]').outerHeight();

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
                            $('#tooltip_3').html('Isikan SKU, jika ingin auto generate maka centang autogenerate di bawah field SKU');
                            $('#tooltip_3').append('<p class="tooltip-step" >Step 12/<?= $max_step ?></p>');
                            $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                            $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                            $('#tooltip_3').show();
                        }

                        $(".next-tooltip").click(function () {
                            $('#tooltip_3').hide();

                            take_tutorial = window.localStorage.getItem('take_tutorial');

                            if (take_tutorial == '1') {
                                var select_top = $('select[name=variant]').offset().top;
                                var select_left = $('select[name=variant]').offset().left;
                                var select_width = $('select[name=variant]').outerWidth();
                                var select_heigth = $('select[name=variant]').outerHeight();

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

                                $('#tooltip_2').css('top', (select_top - 60) + 'px');
                                $('#tooltip_2').css('left', (select_left + select_width) + 20 + 'px');

                                $(".dark-container").show();
                                $('#tooltip_2').html('Jika Produk Memiliki Variant Anda dapat Mengganti Dropdown dibawah menjadi YA. Lalu Tambahkan variant dengan mengeklik tombol tambah dibawah');
                                $('#tooltip_2').append('<p class="tooltip-step" >Step 13/<?= $max_step ?></p>');
                                $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                $('#tooltip_2').show();
                            }

                            $(".next-tooltip").click(function () {
                                take_tutorial = window.localStorage.getItem('take_tutorial');

                                if (take_tutorial == '1') {
                                    var select_top = $('#tb-outlet-list').offset().top;
                                    var select_left = $('#tb-outlet-list').offset().left;
                                    var select_width = $('#tb-outlet-list').outerWidth();
                                    var select_heigth = $('#tb-outlet-list').outerHeight();

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

                                    $('#tooltip_2').css('top', (select_top - 60) + 'px');
                                    $('#tooltip_2').css('left', (select_left + select_width) + 20 + 'px');

                                    $(".dark-container").show();
                                    $('#tooltip_2').html('Tentukan outlet mana saja yang akan diberi akses untuk menjual produk');
                                    $('#tooltip_2').append('<p class="tooltip-step" >Step 14/<?= $max_step ?></p>');
                                    $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                    $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                    $('#tooltip_2').show();

                                    $(".next-tooltip").click(function () {
                                        if (take_tutorial == '1') {
                                            var select_top = $('#table-modifier-list').offset().top;
                                            var select_left = $('#table-modifier-list').offset().left;
                                            var select_width = $('#table-modifier-list').outerWidth();
                                            var select_heigth = $('#table-modifier-list').outerHeight();

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

                                            $('#tooltip_2').css('top', (select_top - 60) + 'px');
                                            $('#tooltip_2').css('left', (select_left + select_width) + 20 + 'px');

                                            $('#tooltip_2').html('Centang Modifier(toping,saus,etc), Jika modifier kosong dan anda ingin menambah anda bisa Menambahkan di menu item library > modifier');
                                            $('#tooltip_2').append('<p class="tooltip-step" >Step 15/<?= $max_step ?></p>');
                                            $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                            $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                            $('#tooltip_2').show();

                                            $(".next-tooltip").click(function () {
                                                if (take_tutorial == '1') {
                                                    $('#tooltip_2').hide();
                                                    $('#select_2').hide();
                                                    $('.dark-container').hide();

                                                    $(".wrapper").animate({scrollTop: $(document).height()}, 1);

                                                    setTimeout(function () {
                                                        var select_top = $('#bsub').offset().top;
                                                        var select_left = $('#bsub').offset().left;
                                                        var select_width = $('#bsub').outerWidth();
                                                        var select_heigth = $('#bsub').outerHeight();

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

                                                        $('#tooltip_2').css('top', (select_top - 120) + 'px');
                                                        $('#tooltip_2').css('left', (select_left + select_width) + 20 + 'px');

                                                        $('#tooltip_2').html('Jika Semua Field Telah terisi Klik Simpan');
                                                        $('#tooltip_2').append('<p class="tooltip-step" >Step 15/<?= $max_step ?></p>');
                                                        $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                                        $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                                        $('#tooltip_2').show();

                                                        $(".next-tooltip").click(function () {
                                                            $('#tooltip_2').hide();
                                                            $('#select_2').hide();
                                                            $('.dark-container').hide();
                                                            window.localStorage.setItem('step','8');
                                                        });
                                                    }, 500);
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        });
                    });
                }
            });
        }
    });
</script>
<?php require_once 'template_sticky4.php'; ?>