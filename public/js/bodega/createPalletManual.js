var app = new Vue({

    el: '#vue-app',

    data: {
        tipoProducto: tipoProducto,
        tipoId: '',
        productos: '',
        prodId: '',
        itemId: '',
        condicion: '',
        item: [],
        items: [],
        cantidad: '',
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.productos.length; i++) {
                if ( this.productos[i].id === this.itemId ) {

                    this.item = this.productos[i];
                    return;
                }
            }
        },

        addItem: function() {

            if (this.cantidad < 0) {

                alert('cantidad debe ser mayor a 0');
                return ;
            }
            this.item.cantidad = this.cantidad;
            this.items.push(this.item);
            this.itemId = '';
            this.updateTotalCantidad();
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                }
            }

            this.updateTotalCantidad();
        },

        updateTotalCantidad: function() {

            cantidad= 0;

            for (var i = 0; i < this.items.length; i++) {

                cantidad += this.items[i].procesar;
            }

            this.totalCantidad = cantidad;
        },

    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
