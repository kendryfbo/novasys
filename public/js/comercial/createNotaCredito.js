var app = new Vue({

    el: '#vue-app',

    data: {
        prodId: '',
        productos: productos,
        factura: factura,
        impIaba: impIaba,
        nota: '',
        cantidad: '',
        precio: 0,
        items: [],
        item: '',
        itemSelected: false,
        sub_total: sub_total,
        neto: neto,
        iaba: iaba,
        iva: iva,
        total: total,
    },

    methods: {

        loadProducto: function() {

            for (var i = 0; i < this.productos.length; i++) {

                if (this.prodId == this.productos[i].id) {

                    this.cantidad = this.productos[i].cantidad;
                    this.precio = Number(this.productos[i].precio);

                    this.item = {
                      producto_id: this.productos[i].id,
                      codigo: this.productos[i].codigo,
                      descripcion: this.productos[i].descripcion,
                      cantidad: this.productos[i].cantidad,
                      precio: Number(this.productos[i].precio),
                      iaba: this.productos[i].iaba,
                      sub_total: 0
                    };
                }
            }
        },

        addItem: function() {

            if (!this.validateInput()) {
              return;
            }

            if (this.itemSelected) {

              for (var i = 0; i < this.items.length; i++) {

                if (this.item.producto_id == this.items[i].producto_id) {

                  this.items.splice(i,1);
                }
              }

            }

            this.item.cantidad = this.cantidad;
            this.item.precio = this.precio;
            this.item.sub_total = this.precio * this.cantidad;
            this.item.sub_total = Math.round(this.item.sub_total);

            this.items.push(this.item);

            //this.calculateTotal();
            this.clearItemInputs();
        },

        loadItem: function(id) {

          for (var i=0; i < this.items.length; i++) {

            if (id == this.items[i].producto_id) {

              this.item = {
                producto_id: this.items[i].producto_id,
                codigo: this.items[i].codigo,
                descripcion: this.items[i].descripcion,
                cantidad: this.items[i].cantidad,
                precio: Number(this.items[i].precio),
                iaba: this.items[i].iaba,
                sub_total: this.items[i].sub_total
              };

              this.prodId = id;
              this.cantidad = this.item.cantidad;
              this.precio = this.item.precio;
              this.itemSelected = true;

              break;
            }
          }
        },

        processAnulation: function() {

            if (!this.factura) {

                return;
            }

            this.addAllItems();
            this.nota = "Nota de Credito Anula Factura N°"+ this.factura;

        },
        addAllItems: function() {

            for (var i = 0; i < this.productos.length; i++) {

                this.prodId = this.productos[i].id;

                this.loadProducto();
                this.addItem();
            }
        },

        removeItem: function() {

            if (this.itemSelected == false) {
              alert('Debe seleccionar producto que desea eliminar');
              return;
            }

            for (var i=0; i < this.items.length; i++) {

              if (this.prodId == this.items[i].producto_id) {
                this.items.splice(i,1);

                //this.calculateTotal();
                this.clearItemInputs();
                $('#prodSelect').focus();
              }
            }
        },

        calculateTotal: function() {

            var subTotal = 0;
            var neto = 0;
            var iva = 0;
            var iaba = 0;
            var total = 0;
            var totalSubTotal = 0;
            var totalNeto = 0;
            var totalIva = 0;
            var totalIaba = 0;
            var tTotal = 0;

            for (var i = 0; i < this.items.length; i++) {

                subTotal = this.items[i].precio * this.items[i].cantidad;
                neto = subTotal;

                if (this.items[i].iaba) {

					iaba = (neto * this.impIaba) / 100;

                } else {

                    iaba = 0;
                }

                iva = (neto * 19) / 100;

                totalSubTotal += subTotal;
                totalNeto += neto;
                totalIva += iva;
                totalIaba += iaba;
                tTotal += neto + iva;
            }

            this.sub_total = totalSubTotal;
            this.neto = totalNeto;
            this.iva = totalIva;
            this.iaba = totalIaba;
            this.total = tTotal;

            console.log('CalculateTotal');

        },

        validateInput: function() {

            if (!this.prodId) {

              alert('Debe Seleccionar Producto');
              return false;
            }
            if (this.duplicatedItem() && !this.itemSelected) {
              alert('Producto ya se encuentra ingresado');
              return false;
            }

            if (this.cantidad <= 0) {

              alert('Debe ingresar la cantidad.');
              return false;
            }

            if (!this.precio) {

              alert('Debe ingresar Precio');
              return false;
            }

            return true;
        },

        duplicatedItem: function() {

          for (var i=0; i < this.items.length; i++) {

            if (this.item.producto_id == this.items[i].producto_id) {
              return true;
            }
            return false;
          }
        },

        clearItemInputs: function() {

            this.prodId = '';
            this.cantidad = 0;
            this.precio = 0;
            this.item = {};
            this.itemSelected = false;
        },

        numberFormat: function(x) {

            x = Math.round(x);

			return x.toLocaleString(undefined, {minimumFractionDigits: 0})
		},

        numberFormatDecimal: function(x) {

            x = Math.round(x);

			return x.toLocaleString(undefined, {minimumFractionDigits: 0})
		}
    },

    watch: {

        items: function() {

            this.calculateTotal();
        }
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }

});
