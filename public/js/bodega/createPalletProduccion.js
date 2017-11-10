var app = new Vue({

    el: '#vue-app',

    data: {
        producidos: producidos,
        itemId: '',
        condicion: '',
        item: [],
        items: [],
        cantidad: '',
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.producidos.length; i++) {
                if ( this.producidos[i].id === this.itemId ) {

                    this.item = this.producidos[i];
                    this.cantidad = this.item.por_procesar;
                    return;
                }
            }
        },

        addItem: function() {

            if (this.cantidad > this.item.por_procesar) {

                alert('cantidad ingresada mayor a la disponible');
                this.cantidad = this.item.por_procesar;
                return ;
            }
            this.item.procesar = this.cantidad;
            this.items.push(this.item);
            this.removeProduccion(this.itemId);
            this.itemId = '';
            this.updateTotalCantidad();
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restoreProduccion(item);
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

        restoreProduccion: function(item) {

            this.producidos.push(item);
        },
        removeProduccion: function(id) {

            for (var i = 0; i < this.producidos.length; i++) {

                if ( this.producidos[i].id === id ) {

                    this.producidos.splice(i,1);
                };
            };
        },
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
