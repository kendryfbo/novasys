var app = new Vue({

    el: '#vue-app',

    data: {
        tipoID: tipoID,
        insumos: insumos,
        bodegas: bodegas,
        bodegaID: '',
        bodegaTwoID: '',
        insumoId: '',
        existInsumo: 0,
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

            for (var i = 0; i < this.insumos.length; i++) {
                if ( this.insumos[i].id === this.itemId ) {

                    this.item = this.insumos[i];
                    this.existInsumo = this.item.existencia;
                    return;
                }
            }
        },

        addItem: function() {

            if (this.cantidad < 0) {

                alert('cantidad debe ser mayor a 0');
                return ;
            }
            if (this.cantidad > this.existInsumo) {
                alert('cantidad no puede ser mayor a existencia');
                return ;
            }

            this.item.cantidad = this.cantidad;
            this.item.fecha_venc = this.fecha_venc;
            this.item.lote = this.lote;
            this.items.push(this.item);
            this.itemId = '';
            this.cantidad = 0;
            this.removeInsumo(this.item.id);
            this.updateTotalCantidad();
        },

        removeInsumo: function(id) {

            for (var i = 0; i < this.insumos.length; i++) {

                if ( this.insumos[i].id == id ) {

                    this.insumos.splice(i,1);
                }
            }
        },

        removeItem: function(item) {

            for (var i = 0; i < this.items.length; i++) {

                if ( this.items[i].id == item.id ) {

                    this.insumos.push(this.items[i]);
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

        getInsumosFromBodega: function() {

            this.restore();
            var url = '/api/bodega/stockTipoDesdeBodega';
            axios.post(url,{
                bodegaID: this.bodegaID,
                tipoID: this.tipoID
            })
			.then(response => this.loadInsumos(response.data))
			.catch(error => this.handleError(error))
        },

        loadInsumos: function (data) {

            this.insumos = data;
        },

        handleError: function(error) {
			console.log(error);
			alert(error);
		},

        restore: function() {
            this.items = [];
        }
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
