<script>
    $('select[name=<?= $select_name ?>]').ready(function () {
        $('select[name=<?= $select_name ?>]').select2({
            ajax: {
                url: '<?= $url_ajax ?>',
                data: function (params) {
                    console.log(params);
                    
                    
                    var query = {
                        <?=$param?>: params.term,
<?php if (!empty($depends)) { ?>
                <?=$depends_param?>: $('<?= $depends ?>').val(),
<?php } ?>
                        page:params.page,
                        type: 'public'
                    };

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                }
            },
            allowClear: true,
            placeholder: '<?= $placeholder ?>',
        });
<?php if (!empty($depends)) { ?>
    $('<?= $depends ?>').change(function(){
        $('select[name=<?= $select_name ?>]').val(null).trigger('change');
    });
<?php } ?>

    });
</script>