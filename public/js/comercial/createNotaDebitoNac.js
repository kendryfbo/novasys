var app = new Vue({

    el: '#vue-app',

    data: {
        descripcion: '',
        monto: 0,
        item: '',
        items: [],
        neto: '',
        iva: '',
        ValorIVA: iva,
        iaba: '',
        ValorIABA: iaba,
        statusIABA: 0,
        total: '',
        nota: '',
    },

    methods: {

        addItem: function() {

            validate = this.validateItemInputs();

            if (!validate) {

                return;
            }

            this.item = {
                'producto_id': 0,
                'descripcion': this.descripcion,
                'precio': this.monto,
                'cantidad': 1
            };

            this.items.push(this.item);
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if (item.descripcion == this.items[i].descripcion) {

                    this.items.splice(i,1);

                    break;
                }
            }
        },

        clearInputs: function() {

            this.descripcion = '';
            this.monto = 0;
            this.item = {};
        },

        validateItemInputs: function() {

            var valid = false;

            if (!this.descripcion) {

                alert('Debe ingresar descripcion');

                return valid;

            } else if (this.monto <= 0) {

                alert('Debe ingresar Monto');

                return valid;
            } else {
                valid = true;
            }

            return valid;
        },

        calculateTotal: function() {

            this.neto = 0;
            this.iaba = 0;
            this.iva = 0;
            this.total = 0;

            for (var i = 0; i < this.items.length; i++) {

                if (this.statusIABA) {

                    this.iaba += this.items[i].precio * this.ValorIABA / 100;
                }

                this.neto += this.items[i].precio;
                this.iva += this.items[i].precio * this.ValorIVA / 100;
                this.total += this.neto + this.iaba + this.iva;
            }
        },





        numberFormat: function(x) {

            return x.toLocaleString(undefined, {minimumFractionDigits: 0})
        }
    },

    watch: {

        items: function() {

            this.calculateTotal();
        }
    }

});
