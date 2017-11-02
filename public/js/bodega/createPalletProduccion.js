var app = new Vue({

    el: '#vue-app',

    data: {
        producidos: producidos,
        itemId: '',
        condicion: '',
        item: [],
        items: [],
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.producidos.length; i++) {
                if ( this.producidos[i].id === this.itemId ) {

                    this.item = this.producidos[i];
                    return;
                }
            }
        },

        addItem: function() {

            this.items.push(this.item);
            this.removeProduccion(this.itemId);
            this.itemId = '';
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.items.splice(i,1);
                    this.restoreProduccion(item);
                }
            }
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
