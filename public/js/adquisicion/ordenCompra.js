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

    proveedores: proveedores,
    tipos: tipos,
    tipoId: '',
    proveedorId: '',
    formaPagoDescrip: '',
    contacto: '',
    productos: [],
    listaProductos: listaProductos,
    tipoProductos: tipoProductos,
    tipoProdID: '',
    prodId: '',
    descripProd: '',
    codigoProd: '',
    umed: '',
    item: [],
    itemSelected: false,
    items: items,
    cantidad: '',
    precio: 0,
    ultPrecio: '',
    total: 0,
    subTotal: 0,
    descuento: 0,
    porcDesc: 0,
    tipo_id: '',
    iva: iva,
    impuesto: 0,
    neto: 0,
    netoLabelText: '',
    ivaLabelText: '',
    totalLabelText: '',
    boleta: 1,
    honorarios: 2,
    factura: 3,

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
            this.precio = this.productos[i].precio;
            this.umed =  this.productos[i].unidad_med ? this.productos[i].unidad_med : 'Unidad';
            this.tipo_id = this.productos[i].tipo_id;
            break;
        }
      }
    },
    loadProductos: function() {

        this.productos = this.listaProductos[this.tipoProdID];
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

      this.item = {
          id: this.prodId,
          codigo: this.codigoProd,
          descripcion: this.descripProd,
          umed: this.umed,
          tipo_id: this.tipo_id,
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

        this.item = key;
        this.prodId = this.items[key].id;
        this.codigoProd = this.items[key].codigo;
        this.descripProd = this.items[key].descripcion;
        this.umed = this.items[key].umed;
        this.tipo_id = this.items[key].tipo_id;
        this.cantidad = this.items[key].cantidad;
        this.precio = this.items[key].precio;

        this.itemSelected = true;

        $('#precio').focus().select();
    },

    removeItem: function() {

        if (this.itemSelected == false) {
            alert('Debe seleccionar producto que desea eliminar');
            return;
        }

        this.items.splice(this.item,1);

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
      if (!this.umed) {

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

      this.tipoId = 3;
  },

  updated() {

    $('.selectpicker').selectpicker('refresh');
  }
});
