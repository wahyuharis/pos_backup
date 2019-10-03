<style>
    .dark-container{
        position: fixed;
        width: 100%;
        height: 100%;
        top:0px;
        left:0px;
        background-color: #585858;
        opacity: 0.6;
        z-index: 999;
    }
    .box-select {
        border: 1px solid #fff;
        background-color: #fff;
        width: 238px;
        height: 58px;
        position: fixed;
        top: 315px;
        left: 0px;
    }
    .tooltip-arrow {
        background: #fff;
        border-radius: 10px;
        padding: 10px 10px;
        display: inline-block;
        position: fixed;
        left: 247px;
        top: 259px;
        width: 250px;
        height: 150px;
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

</style>

<div class="dark-container" style="display: none" >
    <div id="select_1" class="box-select" style="display: none" ></div>
    <div id="select_2" class="box-select" style="top: 352px;display: none;" ></div>
</div>
<div id="tooltip_1" class="tooltip-arrow" style="display: none">
    Klik Disini Untuk Memulai Menambah Produk Yang Anda Jual,
    Menambah Kategory, Variant, Manajemen Stok dan lain lain.
</div>

<div id="tooltip_2" class="tooltip-arrow" style="top:300px;display: none;" >
    Klik Disini Untuk Memulai Menambah Produk
</div>



<script>
    $(document).ready(function () {
        $(".dark-container").show();
        $('#tooltip_1').show();
        $('#select_1').show();

        var first_click1 = 0;
        $(".dark-container").click(function () {
//            if (first_click1 == 0) {
                $('#tooltip_1').hide();
                $('#select_1').hide();
                $('#tooltip_2').hide();
                $('#select_2').hide();

                $(this).hide();
                first_click1++;
//            }
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
    });
</script>