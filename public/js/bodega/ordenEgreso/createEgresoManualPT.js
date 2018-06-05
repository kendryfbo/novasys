var app = new Vue({

    el: '#vue-app',

    data: {
        tipoId: '',
        productos: productos,
        productoId: '',
        productoIndex: '',
        itemId: '',
        item: [],
        items: [],
        cantidad: 0,
        existencia: 0,
        fecha_venc: '',
        lote: '',
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.productos.length; i++) {
                if ( this.productos[i].id === this.itemId ) {

                    this.item = this.productos[i];
                    this.productoIndex = i;
                    this.existencia = this.item.existencia;
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
            this.item.lote = this.lote;
            this.productos.splice(this.productoIndex,1);
            this.items.push(this.item);
            this.itemId = '';
            this.cantidad = 0;
            this.existencia = 0;
            this.updateTotalCantidad();
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.productos.push(this.items[i]);
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
