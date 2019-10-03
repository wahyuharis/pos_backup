<script>
    $(window).on('load', function () {
        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';

        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');


        if ((uri_segment + '/' + uri_segment2 == 'user/') && take_tutorial == '1' && step == '4') {
            //side_item_library

            var select_top = $('#side_item_library').offset().top;
            var select_left = $('#side_item_library').offset().left;
            var select_width = $('#side_item_library').width();
            var select_heigth = $('#side_item_library').height();

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
            $('.tooltip-step').html('Step 7/<?= $max_step ?>');
            $('#tooltip_1').html('Silakan Klik Item Library untuk menambah dan mengatur produk');
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
                window.localStorage.setItem('step', '5');

            });
        }


        $('#side_item_library').click(function () {
            take_tutorial = window.localStorage.getItem('take_tutorial');
            step = window.localStorage.getItem('step');

            sub_is_open = $('#side_item_library > a.accordion').hasClass('active');

            if (sub_is_open && take_tutorial == '1' && step == '5') {
                var select_top = $('#side_produk').offset().top;
                var select_left = $('#side_produk').offset().left;
                var select_width = $('#side_produk').width();
                var select_heigth = $('#side_produk').height();

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
                $('.tooltip-step').html('Step 8/<?= $max_step ?>');
                $('#tooltip_1').html('Lalu Klik Sub Menu Produk');
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
                    window.localStorage.setItem('step', '6');
                });
            }
        });




        take_tutorial = window.localStorage.getItem('take_tutorial');
        step = window.localStorage.getItem('step');

        var uri_segment = '<?= strtolower($this->uri->segment(2)) ?>';
        var uri_segment2 = '<?= strtolower($this->uri->segment(3)) ?>';
        if (uri_segment + '/' + uri_segment2 == 'produk/') {
            if (take_tutorial == '1' && step == '6') {

                var select_top = $('#create_produk').offset().top;
                var select_left = $('#create_produk').offset().left;
                var select_width = $('#create_produk').width();
                var select_heigth = $('#create_produk').height();

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
                $('#tooltip_3').html('Klik Disini Untuk Menambah Produk');
                $('#tooltip_3').append('<p class="tooltip-step" >Step 9/<?= $max_step ?></p>');
                $('#tooltip_3').append('<button class="btn btn-default btn-xs saya-mengerti">Saya Mengerti</button>');
                $('#tooltip_3').append('<button class="btn btn-primary btn-xs next-tooltip">Lanjut</button>');
                $('#tooltip_3').show();


                $(".next-tooltip").click(function () {
                    $('#tooltip_3').hide();
                    $('#select_2').hide();
                    $(".dark-container").hide();
                    window.localStorage.setItem('step', '7');
                });


            }
        }
    });
</script>
<?php require_once 'template_sticky3.php'; ?>