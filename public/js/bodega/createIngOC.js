var app = new Vue({

    el: '#vue-app',

    data: {
        tipoId: '',
        ordenesCompra: ordenesCompra,
        ordenId: '',
        itemId: '',
        item: [],
        items: [],
        cantidad: 0,
        fecha_venc: '',
        lote: '',
        totalCantidad: 0,
    },

    methods: {

        loadItems: function() {

            for (var i = 0; i < this.ordenesCompra.length; i++) {
                if ( this.ordenesCompra[i].id === this.itemId ) {

                    this.items = this.ordenesCompra[i].detalles;
                    return;
                }
            }
        },

        updateRecibidas: function(id) {

            var value = event.target.valueAsNumber;

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id === id ) {

                    this.items[i].recibidas = value;
                    return;
                }
            }
        },

        updateFechaVenc: function(id) {

            var date = event.target.valueAsDate;
            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id === id ) {

                    this.items[i].fecha_venc = date;
                    return;
                }
            }
        },

        updateTotalCantidad: function() {

            cantidad = 0;

            for (var i = 0; i < this.items.length; i++) {

                cantidad += this.items[i].cantidad;
            }

            this.totalCantidad = cantidad;
        },

    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
