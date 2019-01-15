var app = new Vue({

    el: '#vue-app',

    data: {
        premezclas: premezclas,
        itemId: '',
        cantidad: '',
        item: [],
        items: [],
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.premezclas.length; i++) {
                if ( this.premezclas[i].id === this.itemId ) {

                    this.item = this.premezclas[i];
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
            this.removePremezcla(this.itemId);
            this.itemId = '';
            this.cantidad = '';
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restorePremezcla(item);
                }
            }
        },

        restorePremezcla: function(item) {

            this.premezclas.push(item);
        },
        
        removePremezcla: function(id) {

            for (var i = 0; i < this.premezclas.length; i++) {

                if ( this.premezclas[i].id === id ) {

                    this.premezclas.splice(i,1);
                };
            };
        },
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
