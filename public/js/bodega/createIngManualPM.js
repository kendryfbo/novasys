var app = new Vue({

    el: '#vue-app',

    data: {
        tipoId: '',
        premezclas: premezclas,
        premezclaId: '',
        fecha_ing: fecha,
        itemId: '',
        item: [],
        items: [],
        cantidad: 0,
        fecha_venc: '',
        lote: '',
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.premezclas.length; i++) {
                if ( this.premezclas[i].id === this.itemId ) {

                    this.item = this.premezclas[i];
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
            this.item.fecha_venc = this.fecha_venc;
            this.item.fecha_ing = this.fecha_ing;
            this.item.lote = this.lote;
            this.items.push(this.item);
            this.itemId = '';
            this.cantidad = 0;
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
