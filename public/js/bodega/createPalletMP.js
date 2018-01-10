var app = new Vue({

    el: '#vue-app',

    data: {
        insumos: insumos,
        itemId: '',
        cantidad: '',
        item: [],
        items: [],
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.insumos.length; i++) {
                if ( this.insumos[i].id === this.itemId ) {

                    this.item = this.insumos[i];
                    this.cantidad = this.item.por_almacenar;
                    return;
                }
            }
        },

        addItem: function() {

            this.item.por_almacenar = this.cantidad;
            this.items.push(this.item);
            this.removeInsumo(this.itemId);
            this.itemId = '';
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restoreInsumo(item);
                }
            }
        },

        restoreInsumo: function(item) {

            this.insumos.push(item);
        },
        removeInsumo: function(id) {

            for (var i = 0; i < this.insumos.length; i++) {

                if ( this.insumos[i].id === id ) {

                    this.insumos.splice(i,1);
                };
            };
        },
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
