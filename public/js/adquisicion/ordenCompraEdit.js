var app = new Vue({

  el: '#vue-app',

  data: {

    proveedores: proveedores,
    tipos: tipos,
    tipoId: tipoId,
    proveedorId: proveedorId,
    formaPagoDescrip: '',
    contacto: '',
    productos: productos,
    prodId: '',
    descripProd: '',
    codigoProd: '',
    unidad: '',
    item: [],
    itemSelected: false,
    items: items,
    cantidad: '',
    precio: 0,
    ultPrecio: '',
    total: 0,
    subTotal: 0,
    descuento: 0,
    porcDesc: porcDesc,
    iva: iva,
    impuesto: 0,
    neto: 0,
    netoLabelText: '',
    ivaLabelText: '',
    totalLabelText: '',
    boleta: 1,
    honorarios: 2,
    factura: 3,
    active: false,
    select: '',

  },

  methods: {

    loadDatos: function() {

        for (var i=0; i < this.proveedores.length; i++) {

          if (this.proveedorId == this.proveedores[i].id) {

            this.formaPagoDescrip = this.proveedores[i].forma_pago.descripcion;
            this.contacto = this.proveedores[i].contacto;
          }
        }
    },

    loadProducto: function() {

      for (var i=0; i < this.productos.length; i++) {

        if (this.prodId == this.productos[i].id) {

            this.descripProd =  this.productos[i].descripcion;
            this.codigoProd =  this.productos[i].codigo;
            this.ultPrecio = this.productos[i].precio;
            this.precio = this.ultPrecio;
            this.unidad =  this.productos[i].unidad_med ? this.productos[i].unidad_med : 'Unidad';

          break;
        }
      }
    },

    addItem: function() {

      if (!this.validateInput()) {
        return;
      }

      if (this.itemSelected) {

        for (var i = 0; i < this.items.length; i++) {

          if (this.item.item_id == this.items[i].item_id) {
            this.items[i].id.splice(i,1);
          }
        }

      }

      this.item = {
          item_id: this.prodId,
          codigo: this.codigoProd,
          descripcion: this.descripProd,
          unidad: this.unidad,
          cantidad: this.cantidad,
          precio: this.precio,
          sub_total: this.precio * this.cantidad
      }
      this.items.push(this.item);

      this.calculateTotal();
      this.clearItemInputs();
      $('#prodSelect').focus();

    },

    loadItem: function(key) {

        this.active = true;
        this.select = key;
        this.prodId = this.items[key].item_id;
        this.codigoProd = this.items[key].codigo;
        this.descripProd = this.items[key].descripcion;
        this.unidad = this.items[key].unidad;
        this.cantidad = this.items[key].cantidad;
        this.precio = this.items[key].precio;

        this.itemSelected = true;

        $('#precio').focus().select();
    },

    removeItem: function() {

      if (!(this.select === '')) {

				this.items.splice(this.select,1);
			}
        this.calculateTotal();
        this.clearItemInputs();
        $('#prodSelect').focus();
    },

    selectTipo: function(item) {

        alert(item);
    },

    validateInput: function() {

      if (!this.prodId) {

        alert('Debe Seleccionar Producto');
        return false;
      }
      if (!this.descripProd) {

        alert('Debe Contener Descripcion Producto');
        return false;
      }
      if (!this.unidad) {

        alert('Debe Contener unidad de medicion');
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

        if (this.descripProd == this.items[i].descripcion) {
          return true;
        }
        return false;
      }
    },

    clearItemInputs: function() {

      this.cantidad = '';
      this.descuento = 0;
      this.precio = '';
      this.prodId = '';
      this.ultPrecio = '';
      this.itemSelected = false;
    },

    calculateTotal: function() {

      var subTotal = 0;
      var total = 0;
      var descuento = 0;

      for (var i=0; i < this.items.length; i++) {

        subTotal += this.items[i].sub_total;
      }

      this.subTotal = subTotal;
      this.descuento = (subTotal * this.porcDesc) / 100;

      if (this.tipoId == this.honorarios) {

          this.total = this.neto - this.descuento;
          this.neto = this.total / 0.9;
          this.impuesto = this.neto * 0.1;

      } else if (this.tipoId == this.boleta) {

          this.neto = this.subTotal - this.descuento;
          this.impuesto = 0;
          this.total = this.neto + this.impuesto;

      } else {

          this.neto = this.subTotal - this.descuento;
          this.impuesto = (this.neto * this.iva) / 100;
          this.total = this.neto + this.impuesto;
      }
  },

    numberFormat: function(x) {

        return Number(x).toLocaleString(undefined, {minimumFractionDigits: 2})
    }

  },

  computed: {

  },

  watch: {
        tipoId: function() {

            // equal to boleta-exenta
            if (this.tipoId == this.boleta) {
                this.ivaLabelText = "";
                this.netoLabelText = "TOTAL NETO:";
                this.totalLabelText = "TOTAL PAGO:";

            }
            // equal to Boleta
            else if (this.tipoId == this.honorarios) {
                this.netoLabelText = "BRUTO:";
                this.ivaLabelText = "RETENCION:";
                this.totalLabelText = "LIQUIDO:";
            } else {
                this.netoLabelText = "TOTAL NETO:";
                this.ivaLabelText = "TOTAL IVA:";
                this.totalLabelText = "TOTAL PAGO:";
            }
        }
  },

  mounted: function() {

      this.calculateTotal();
      this.loadDatos();
  },

  updated() {

    $('.selectpicker').selectpicker('refresh');
  }
});
