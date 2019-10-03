<script>
    function add_ingredient_list(idingredient, nama_ingredient, qty) {
        var self = this;

        self.idingredient = ko.observable(idingredient);
        self.nama_ingredient = ko.observable(nama_ingredient);
        self.qty = ko.observable(qty);
    }

    function ingredient_model() {
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
                self.variant_list.push(new add_ingredient_list('#', '<?= $vlist['idvariant'] ?>', '<?= $vlist['sku'] ?>', '<?= $vlist['nama_variant'] ?>', '<?= $vlist['harga'] ?>', '0'));
        <?php
    }
}
?>

        self.add_variant_click = function (e) {
            var nama_variant_self = self.nama_variant_add();
            var harga_self = self.harga_add();
            var stok_self = self.stok_add();
            var sku = self.sku_variant_add();

            if (nama_variant_self.length > 0 && harga_self.length > 0) {
                self.variant_list.push(new add_ingredient_list('#', '', sku, nama_variant_self, harga_self, stok_self));
            }


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

    ko.applyBindings(new ingredient_model(), document.getElementById('ingredient-list'));
</script>
