$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        document.getElementById("addItem").click();
        return false;
    }
});

var app = new Vue({

    el: '#vue-app',

    data: {
        tipoID: tipoID,
        productos: productos,
        productoID: '',
        existProducto: 0,
        itemId: '',
        item: [],
        items: [],
        cantidad: 0,
        totalCantidad: 0,
    },

    methods: {

        loadItem: function() {

            for (var i = 0; i < this.productos.length; i++) {
                if ( this.productos[i].id === this.itemId ) {

                    this.item = this.productos[i];
                    this.item.unidad_med = "UN";
                    this.existProducto = this.item.cantidad;
                    return;
                }
            }
        },

        addItem: function() {

            if (this.cantidad < 0) {

                alert('cantidad debe ser mayor a 0');
                return ;
            }
            if (this.cantidad > this.existProducto) {
                alert('cantidad no puede ser mayor a existencia');
                return ;
            }

            this.item.producto.cantidad = this.cantidad;
            this.items.push(this.item);
            this.itemId = '';
            this.cantidad = 0;
            this.removeProducto(this.item.id);
            this.updateTotalCantidad();
        },

        removeProducto: function(id) {

            for (var i = 0; i < this.productos.length; i++) {

                if ( this.productos[i].id == id ) {

                    this.productos.splice(i,1);
                }
            }
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

        getProductosFromBodega: function() {

            this.restore();
            var url = '/api/bodega/stockTipoDesdeBodega';
            axios.post(url,{
                bodegaID: this.bodegaID,
                tipoID: this.tipoID,
            })
			.then(response => this.loadProductos(response.data))
			.catch(error => this.handleError(error))
        },

        loadProductos: function (data) {

            this.productos = data;
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
