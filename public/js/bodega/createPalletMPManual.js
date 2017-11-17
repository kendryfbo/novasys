var app = new Vue({

    el: '#vue-app',

    data: {
        tipoId: '',
        detalles: detalles,
        itemId: '',
        item: [],
        items: [],
        cantidad: 0,
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.detalles.length; i++) {
                if ( this.detalles[i].item_id === this.itemId ) {

                    this.item = this.detalles[i];
                    this.cantidad = this.item.cantidad
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
            this.removeDetalle(this.item.id);
            this.itemId = '';
            this.cantidad = 0;
            this.updateTotalCantidad();
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restoreDetalle(item);
                }
            }

            this.updateTotalCantidad();
        },

        updateTotalCantidad: function() {

            cantidad = 0;

            for (var i = 0; i < this.items.length; i++) {

                cantidad += this.items[i].cantidad;
            }

            this.totalCantidad = cantidad;
        },

        restoreDetalle: function(item) {

            this.detalles.push(item);
        },

        removeDetalle: function(id) {

            for (var i = 0; i < this.detalles.length; i++) {

                if ( this.detalles[i].id === id ) {

                    this.detalles.splice(i,1);
                };
            };
        },

    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
