var app = new Vue({

    el: '#vue-app',

    data: {
        productos: productos,
        itemId: '',
        cantidad: '',
        item: [],
        items: [],
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.productos.length; i++) {
                if ( this.productos[i].id === this.itemId ) {

                    this.item = this.productos[i];
                    this.cantidad = this.item.por_procesar;
                    return;
                }
            }
        },

        addItem: function() {

            if (this.cantidad > this.item.por_procesar) {
                alert('Cantidad ingresada Mayor a la disponible');
                return;
            }

            this.item.cantidad = this.cantidad;
            this.items.push(this.item);
            this.removeproducto(this.itemId);
            this.itemId = '';
            this.cantidad = '';
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restoreproducto(item);
                }
            }
        },

        restoreproducto: function(item) {

            this.productos.push(item);
        },
        removeproducto: function(id) {

            for (var i = 0; i < this.productos.length; i++) {

                if ( this.productos[i].id === id ) {

                    this.productos.splice(i,1);
                };
            };
        },
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
