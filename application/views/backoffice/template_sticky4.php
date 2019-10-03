<script>
    $(window).on('load', function () {
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';
        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');

        if (take_tutorial == '1' && step == '8' && ((uri_segment + "/" + uri_segment2) == 'produk/')) {
            var select_top = $('#report_side').offset().top;
            var select_left = $('#report_side').offset().left;
            var select_width = $('#report_side').outerWidth();
            var select_heigth = $('#report_side').outerHeight();

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
            $('#tooltip_2').css('left', (select_left + select_width + 20) + 'px');

            $(".dark-container").show();
            $('#tooltip_2').html('Untuk Melihat Laporan Penjualan Per Produk, Klik Report');
            $('#tooltip_2').append('<p class="tooltip-step" >Step 16/<?= $max_step ?></p>');
            $('#tooltip_2').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_2').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
            $('#tooltip_2').show();

            $(".next-tooltip").click(function () {
                $('#tooltip_2').hide();
                $('#select_2').hide();
                $('.dark-container').hide();
                window.localStorage.setItem('step', '9');
            });
        }



        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';
        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');

        console.log(uri_segment + "/" + uri_segment2);

        if ((uri_segment + "/" + uri_segment2) == 'report/' && take_tutorial == '1' && step == '9') {
//            console.log(step);
            //take_tutorial == '1' && step == '9' && 
            var select_top = $('input[name=tanggal]').offset().top;
            var select_left = $('input[name=tanggal]').offset().left;
            var select_width = $('input[name=tanggal]').outerWidth();
            var select_heigth = $('input[name=tanggal]').outerHeight();

            console.log(select_top);
            console.log(select_left);
            console.log(select_width);
            console.log(select_heigth);

            $('#select_2').css('left', select_left + 'px');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('height', select_heigth + 'px');
            $('#select_2').css('width', select_width + 'px');
            $('#select_2').show();

            $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
            $('#tooltip_3').css('left', (select_left - select_width) + 'px');

            $('#tooltip_3').html('Tentukan Range Tanggal');
            $('#tooltip_3').append('<p class="tooltip-step" >Step 17/<?= $max_step ?></p>');
            $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
            $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
            $('#tooltip_3').show();
            $(".dark-container").show();

            $(".next-tooltip").click(function () {
                $('#tooltip_3').hide();
                $('#select_2').hide();
                $('.dark-container').hide();
//                window.localStorage.setItem('step', '9');


                take_tutorial = window.localStorage.getItem('take_tutorial');
                if (take_tutorial == '1') {
                    var select_top = $('select[name=kategori]').offset().top;
                    var select_left = $('select[name=kategori]').offset().left;
                    var select_width = $('select[name=kategori]').outerWidth();
                    var select_heigth = $('select[name=kategori]').outerHeight();

                    console.log(select_top);
                    console.log(select_left);
                    console.log(select_width);
                    console.log(select_heigth);

                    $('#select_2').css('left', select_left + 'px');
                    $('#select_2').css('top', select_top + 'px');
                    $('#select_2').css('height', select_heigth + 'px');
                    $('#select_2').css('width', select_width + 'px');
                    $('#select_2').show();

                    $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                    $('#tooltip_3').css('left', (select_left - select_width) + 'px');

                    $('#tooltip_3').html('Pilih Kategori Produk');
                    $('#tooltip_3').append('<p class="tooltip-step" >Step 18/<?= $max_step ?></p>');
                    $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                    $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                    $('#tooltip_3').show();
                    $(".dark-container").show();
                }


                $(".next-tooltip").click(function () {
                    $('#tooltip_3').hide();
                    $('#select_2').hide();
                    $('.dark-container').hide();

                    take_tutorial = window.localStorage.getItem('take_tutorial');
                    if (take_tutorial == '1') {

                        var select_top = $('select[name=harga_produk]').offset().top;
                        var select_left = $('select[name=harga_produk]').offset().left;
                        var select_width = $('select[name=harga_produk]').outerWidth();
                        var select_heigth = $('select[name=harga_produk]').outerHeight();

                        console.log(select_top);
                        console.log(select_left);
                        console.log(select_width);
                        console.log(select_heigth);

                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', select_heigth + 'px');
                        $('#select_2').css('width', select_width + 'px');
                        $('#select_2').show();

                        $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                        $('#tooltip_3').css('left', (select_left - select_width) + 'px');

                        $('#tooltip_3').html('Pilih Rentan Harga Produk');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 19/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                        $('#tooltip_3').show();
                        $(".dark-container").show();
                    }

                    $(".next-tooltip").click(function () {
                        $('#tooltip_3').hide();
                        $('#select_2').hide();
                        $('.dark-container').hide();


                        take_tutorial = window.localStorage.getItem('take_tutorial');
                        if (take_tutorial == '1') {
                            var select_top = $('select[name=outlet]').offset().top;
                            var select_left = $('select[name=outlet]').offset().left;
                            var select_width = $('select[name=outlet]').outerWidth();
                            var select_heigth = $('select[name=outlet]').outerHeight();

                            console.log(select_top);
                            console.log(select_left);
                            console.log(select_width);
                            console.log(select_heigth);

                            $('#select_2').css('left', select_left + 'px');
                            $('#select_2').css('top', select_top + 'px');
                            $('#select_2').css('height', select_heigth + 'px');
                            $('#select_2').css('width', select_width + 'px');
                            $('#select_2').show();

                            $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                            $('#tooltip_3').css('left', (select_left - select_width) + 'px');

                            $('#tooltip_3').html('Pilih Outlet');
                            $('#tooltip_3').append('<p class="tooltip-step" >Step 20/<?= $max_step ?></p>');
                            $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                            $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                            $('#tooltip_3').show();
                            $(".dark-container").show();
                        }

                        $(".next-tooltip").click(function () {
                            $('#tooltip_3').hide();
                            $('#select_2').hide();
                            $('.dark-container').hide();

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

                                $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                                $('#tooltip_3').css('left', (select_left - select_width) + 'px');

                                $('#tooltip_3').html('Ketikkan Nama Produk Jika ingin mencari nama produk');
                                $('#tooltip_3').append('<p class="tooltip-step" >Step 21/<?= $max_step ?></p>');
                                $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                $('#tooltip_3').show();
                                $(".dark-container").show();
                            }

                            $(".next-tooltip").click(function () {
                                $('#tooltip_3').hide();
                                $('#select_2').hide();
                                $('.dark-container').hide();


                                take_tutorial = window.localStorage.getItem('take_tutorial');
                                if (take_tutorial == '1') {
                                    var select_top = $('#submit_filter').offset().top;
                                    var select_left = $('#submit_filter').offset().left;
                                    var select_width = $('#submit_filter').outerWidth();
                                    var select_heigth = $('#submit_filter').outerHeight();

                                    console.log(select_top);
                                    console.log(select_left);
                                    console.log(select_width);
                                    console.log(select_heigth);

                                    $('#select_2').css('left', select_left + 'px');
                                    $('#select_2').css('top', select_top + 'px');
                                    $('#select_2').css('height', select_heigth + 'px');
                                    $('#select_2').css('width', select_width + 'px');
                                    $('#select_2').show();

                                    $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                                    $('#tooltip_3').css('left', ((select_left - 300) + select_width) + 'px');

                                    $('#tooltip_3').html('Klik Filter Untuk Melakukan Pencarian');
                                    $('#tooltip_3').append('<p class="tooltip-step" >Step 22/<?= $max_step ?></p>');
                                    $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                    $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                    $('#tooltip_3').show();
                                    $(".dark-container").show();//export_excel
                                }

                                $(".next-tooltip").click(function () {
                                    $('#tooltip_3').hide();
                                    $('#select_2').hide();
                                    $('.dark-container').hide();

                                    $('#tooltip_3').hide();
                                    $('#select_2').hide();
                                    $('.dark-container').hide();

                                    take_tutorial = window.localStorage.getItem('take_tutorial');
                                    if (take_tutorial == '1') {
                                        var select_top = $('#export_excel').offset().top;
                                        var select_left = $('#export_excel').offset().left;
                                        var select_width = $('#export_excel').outerWidth();
                                        var select_heigth = $('#export_excel').outerHeight();

                                        console.log(select_top);
                                        console.log(select_left);
                                        console.log(select_width);
                                        console.log(select_heigth);

                                        $('#select_2').css('left', select_left + 'px');
                                        $('#select_2').css('top', select_top + 'px');
                                        $('#select_2').css('height', select_heigth + 'px');
                                        $('#select_2').css('width', select_width + 'px');
                                        $('#select_2').show();

                                        $('#tooltip_3').css('top', (select_top + select_heigth + 10) + 'px');
                                        $('#tooltip_3').css('left', ((select_left - 300) + select_width) + 'px');

                                        $('#tooltip_3').html('Klik Filter Untuk Melakukan Pencarian');
                                        $('#tooltip_3').append('<p class="tooltip-step" >Step 23/<?= $max_step ?></p>');
                                        $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                                        $('#tooltip_3').show();
                                        $(".dark-container").show();//export_excel

                                        $(".next-tooltip").click(function () {
                                            $('#tooltip_3').hide();
                                            $('#select_2').hide();
                                            $('.dark-container').hide();

                                            console.log('jangan tampilkan lagi');
                                            window.localStorage.setItem('take_tutorial', '0');
                                            window.localStorage.setItem('step', '0');
                                        });

                                    }
                                });
                            });
                        });
                    });
                });
            });
        }
    });

    $(document).on("click", '.saya-mengerti', function (event) {
        console.log('jangan tampilkan lagi');
        window.localStorage.setItem('take_tutorial', '0');
        window.localStorage.setItem('step', '0');
        $('#tooltip_1').hide();
        $('#tooltip_2').hide();
        $('#tooltip_3').hide();

        $('#select_3').hide();
        $('#select_2').hide();
        $('#select_1').hide();

        $(".dark-container").hide();
    });

</script>