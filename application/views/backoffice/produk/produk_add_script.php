<script>
    function add_variant_list(number_row, id_variant, sku, nama_variant, harga, stok) {
        var self = this;

        self.id_variant = ko.observable(id_variant);
        self.sku = ko.observable(sku);
        self.number_row = ko.observable(number_row);
        self.nama_variant = ko.observable(nama_variant);
        self.harga = ko.observable(harga);
        self.stok = ko.observable(stok);
    }

    function variant_model() {
        var self = this;

        self.nama_variant_add = ko.observable('');
        self.harga_add = ko.observable('');
        self.stok_add = ko.observable('');
        self.sku_variant_add = ko.observable('');

        self.variant_list = ko.observableArray([]);

<?php
if (isset($variant_list)) {
    foreach ($variant_list as $vlist) {
        ?>
                self.variant_list.push(new add_variant_list('#', '<?= $vlist['idvariant'] ?>', '<?= $vlist['sku'] ?>', '<?= $vlist['nama_variant'] ?>', '<?= $vlist['harga'] ?>', '0'));
        <?php
    }
}
?>

        self.add_variant_click = function (e) {
            var nama_variant_self ='';
            var harga_self = '';
            var stok_self = '';
            var sku = '';

//            if (nama_variant_self.length > 0 && harga_self.length > 0) {
                self.variant_list.push(new add_variant_list('#', '', sku, nama_variant_self, harga_self, stok_self));
//            }


            self.nama_variant_add('');
            self.harga_add('');
            self.stok_add('');
        }

        self.add_variant_enter = function (data, event) {

        }

        self.remove_list = function (row) {
            self.variant_list.remove(row);
        }
    }

    ko.applyBindings(new variant_model(), document.getElementById('variant-list'));
</script>