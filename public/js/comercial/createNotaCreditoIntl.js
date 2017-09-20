var app = new Vue({

    el: '#vue-app',

    data: {
        descripcion: '',
        monto: 0,
        item: '',
        items: [],
        total: 0
    },

    methods: {

        addItem: function() {

            validate = this.validateItemInputs();

            if (!validate) {

                return;
            }

            this.item = {
                'descripcion': this.descripcion,
                'monto': this.monto,
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

            this.total = 0;

            for (var i = 0; i < this.items.length; i++) {

                this.total += this.items[i].monto;
            }
        },

        numberFormat: function(x) {

            return x.toLocaleString(undefined, {minimumFractionDigits: 2})
        }
    },

    watch: {

        items: function() {

            this.calculateTotal();
        }
    }

});
