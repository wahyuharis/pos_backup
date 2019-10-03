<script>
    $(window).on('load', function () {
        var take_tutorial = window.localStorage.getItem('take_tutorial');
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        if (take_tutorial == '3' && uri_segment == 'produk') {

            $(".dark-container").show();
            $('#select_2').css('right', '');
            $('#select_2').css('left', '0px');
            $('#select_2').css('top', '121px');
            $('#select_2').css('height', '48px');
            $('#select_2').css('width', '238px');
            $('#select_2').show();

            $('#tooltip_2').css('top', '70px');
            $('#tooltip_2').css('left', '250px');
            $('#tooltip_2').html('Klik REPORT Untuk Melihat report penjualan produk perhari/perbulan');
            $('#tooltip_2').append('<p class="tooltip-step" >Step 11/<?= $max_step ?></p>');
            $('#tooltip_2').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');


            $('#tooltip_2').show();

            $(".dark-container").click(function () {
                $('#select_2').hide();
                $('#tooltip_2').hide();
                $(".dark-container").hide();
            });
        }


        if (take_tutorial == '3' && uri_segment == 'report') {
            $(".dark-container").show();

            var select_top = $('input[name=tanggal]').offset().top;
            var select_left = $('input[name=tanggal]').offset().left;
            var select_width = $('input[name=tanggal]').width();

            console.log(select_top);
            console.log(select_left);
            console.log(select_width);

            $('#select_2').css('right', '');
            $('#select_2').css('top', select_top + 'px');
            $('#select_2').css('left', select_left + 'px');
            $('#select_2').css('height', '35px');
            $('#select_2').css('width', '210px');
            $('#select_2').show();

            $('#tooltip_3').css('top', '160px');
            $('#tooltip_3').css('left', select_left - 50 + 'px');
            $('#tooltip_3').css('height', '170px');
            
            $('#tooltip_3').html('Klik Disini Untuk Mengatur Filter tanggal.<br>Anda bisa Mengeklik tgl 01 bulan ini lalu tanggal akhir bulan ini, maka transaksi yang dihitung adalah tgl 01 hingga akhir bulan');
            $('#tooltip_3').append('<p class="tooltip-step" >Step 12/<?= $max_step ?></p>');
            $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');

            $('#tooltip_3').show();

            var click_i = 0;
            $(".dark-container").click(function () {
                click_i++;

                var select_top = $('input[name=nama_produk]').offset().top;
                var select_left = $('input[name=nama_produk]').offset().left;
                var select_width = $('input[name=nama_produk]').width();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);


                if (click_i == 1) {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('right', '');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', select_width + 30 + 'px');
                        $('#select_2').show();

                        $('#tooltip_3').css('top', select_top + 50 + 'px');
                        $('#tooltip_3').css('left', select_left - 150 + 'px');
                        $('#tooltip_3').html('Isikan nama produk lalu tekan enter jika ingin menghitung transaksi produk tertentu');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 13/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                        $('#tooltip_3').show();
                    }
                }

                var select_top = $('select[name=kategori]').offset().top;
                var select_left = $('select[name=kategori]').offset().left;
                var select_width = $('select[name=kategori]').width();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);

                if (click_i == 2) {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('right', '');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', select_width + 30 + 'px');
                        $('#select_2').show();

                        $('#tooltip_3').css('top', '160px');
                        $('#tooltip_3').css('left', select_left - 140 + 'px');
                        $('#tooltip_3').html('Pilih Kategori jika tidak di isi maka semua kategori akan ditampilkan');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 14/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');

                        $('#tooltip_3').show();
                    }
                }

                var select_top = $('select[name=outlet]').offset().top;
                var select_left = $('select[name=outlet]').offset().left;
                var select_width = $('select[name=outlet]').width();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);

                if (click_i == 3) {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('right', '');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', select_width + 30 + 'px');
                        $('#select_2').show();

                        $('#tooltip_3').css('top', '160px');
                        $('#tooltip_3').css('left', select_left - 90 + 'px');
                        $('#tooltip_3').html('Pilih juga Outlet Untuk melakukan filter outlet');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 15/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');

                        $('#tooltip_3').show();
                    }
                }

                var select_top = $('#submit_filter').offset().top;
                var select_left = $('#submit_filter').offset().left;
                var select_width = $('#submit_filter').width();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);

                if (click_i == 4) {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('right', '');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', '60px');
                        $('#select_2').show();

                        $('#tooltip_3').css('right', '');
                        $('#tooltip_3').css('left', select_left - 200 + 'px');
                        $('#tooltip_3').css('top', select_top + 50 + 'px');

                        $('#tooltip_3').html('Klik Filter Untuk Melakukan filter berdasarkan parameter yang telah anda isi');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 16/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                        $('#tooltip_3').show();
                    }
                }

                var select_top = $('#export_excel').offset().top;
                var select_left = $('#export_excel').offset().left;
                var select_width = $('#export_excel').width();

                console.log(select_top);
                console.log(select_left);
                console.log(select_width);

                if (click_i == 5) {
                    take_tutorial = window.localStorage.getItem('take_tutorial');

                    if (parseInt(take_tutorial) > 0) {
                        $('#select_2').css('right', '');
                        $('#select_2').css('left', select_left + 'px');
                        $('#select_2').css('top', select_top + 'px');
                        $('#select_2').css('height', '35px');
                        $('#select_2').css('width', '68px');
                        $('#select_2').show();

                        $('#tooltip_3').css('left', select_left - 170 + 'px');
//                    $('#tooltip_3').css('right', 'px');
                        $('#tooltip_3').css('top', select_top + 50 + 'px');

                        $('#tooltip_3').html('Klik export jika anda ingin mengeksport ke bentuk excel berdasarkan filter');
                        $('#tooltip_3').append('<p class="tooltip-step" >Step 17/<?= $max_step ?></p>');
                        $('#tooltip_3').append('<button class="btn btn-primary btn-xs saya-mengerti">Saya Mengerti</button>');
                        $('#tooltip_3').show();
                    }
                }


                if (click_i == 6) {
                    $('#select_2').hide();
                    $('#tooltip_3').hide();
                    $(".dark-container").hide();

                    window.localStorage.setItem('take_tutorial', '0');
                    window.localStorage.setItem('jangan_tampil_lagi', '1');
                }

            });
        }



    });


    $(document).on("click", '.saya-mengerti', function (event) {
        console.log('jangan tampilkan lagi');
        window.localStorage.setItem('take_tutorial', '0');
        window.localStorage.setItem('jangan_tampil_lagi', '1');
        $('#tooltip_1').hide();
        $('#tooltip_2').hide();
        $('#tooltip_3').hide();

        $(".dark-container").hide();
    });

</script>