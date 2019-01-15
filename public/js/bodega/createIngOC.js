var app = new Vue({

    el: '#vue-app',

    data: {
        tipoId: '',
        ordenId: '',
        items: productos,
    },

    methods: {

        updateRecibidas: function(id) {

            var value = event.target.valueAsNumber;
            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id === id ) {

                    let temp = this.items[i];
                    temp.cant_ing = value;
                    Vue.set(this.items,i,temp);
                    return;
                }
            }
        },

        updateFechaVenc: function(id) {

            var date = event.target.value;
            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id === id ) {

                    let temp = this.items[i];
                    temp.fecha_venc = date;
                    Vue.set(this.items,i,temp);
                    return;
                }
            }
        },

        updateNumLote: function(id) {

            var lote = event.target.value;

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id === id ) {

                    let temp = this.items[i];
                    temp.num_lote = lote;
                    Vue.set(this.items,i,temp);
                    return;
                }
            }
        },

    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    },

    mounted: function() {

        for (var i = 0; i < this.items.length; i++) {

            let temp = this.items[i];
            temp.cant_ing = 0;
            temp.fecha_venc = '';
            temp.num_lote = '';
            Vue.set(this.items,i,temp);

        }
    }

});
