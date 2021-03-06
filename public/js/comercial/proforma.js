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

    clientes: clientes,
    clienteId: '',
    formaPagoDescrip: '',
    direccion: '',
    sucursales: [],
    productos: productos,
    prodId: '',
    item: [],
    itemSelected: false,
    items: items,
    cantidad: '',
    descuento: 0,
    precio: '',
    totalPesoNeto: 0,
    totalPesoBruto: 0,
    totalVolumen: 0,
    totalCajas: 0,
    fob: 0,
    freight: 0,
    insurance: 0,
    total: 0,
    clausulas: clausulas,
    clausulaID: '',
    fobValidator: true,
    freightValidator: true,
    insuranceValidator: true,
  },

  methods: {

    loadDatos: function() {

        this.loadSucursales();
        this.loadFormaPago();

    },

    loadSucursales: function() {

        for (var i=0; i < this.clientes.length; i++) {

            if (this.clienteId == this.clientes[i].id) {

                this.sucursales = this.clientes[i].sucursales;
                this.direccion = this.clientes[i].direccion;
            }
        }
    },

    loadFormaPago: function() {

      for (var i=0; i < this.clientes.length; i++) {

        if (this.clienteId == this.clientes[i].id) {

          this.formaPagoDescrip = this.clientes[i].forma_pago.descripcion;
        }
      }
    },

    loadProducto: function() {

      for (var i=0; i < this.productos.length; i++) {

        if (this.prodId == this.productos[i].id) {

          this.item = {
            producto_id: this.productos[i].id,
            codigo: this.productos[i].codigo,
            descripcion: this.productos[i].descripcion,
            formato: this.productos[i].formato,
            peso_bruto: this.productos[i].peso_bruto,
            peso_neto: this.productos[i].peso_neto,
            volumen: this.productos[i].volumen,
            cantidad: 0,
            descuento: 0,
            precio: 0,
            sub_total: 0
          };

          break;
        }
      }
    },

    addItem: function() {

      if (!this.validateInput()) {
        return;
      }
      var order = 0;

      if (this.itemSelected) {

        for (var i = 0; i < this.items.length; i++) {

          if (this.item.producto_id == this.items[i].producto_id) {
            order = this.items[i].order;
            this.items.splice(i,1);
            break;
          }
        }

    } else {

        order = this.items.length + 1;
    }

      this.item.order = order;
      this.item.cantidad = this.cantidad;
      this.item.descuento = this.descuento;
      this.item.precio = this.precio;

      this.item.sub_total = (this.precio - this.descuento) * this.cantidad;
      this.item.sub_total = Math.round(this.item.sub_total * 100) / 100;
      this.items.push(this.item);
      this.sortItems();
      this.calculateTotal();
      this.clearItemInputs();
      $('#prodSelect').focus();

    },

    loadItem: function(id) {

      for (var i=0; i < this.items.length; i++) {

        if (id == this.items[i].producto_id) {

          this.item = {
            producto_id: this.items[i].producto_id,
            codigo: this.items[i].codigo,
            descripcion: this.items[i].descripcion,
            formato: this.items[i].formato,
            peso_bruto: this.items[i].peso_bruto,
            peso_neto: this.items[i].peso_neto,
            volumen: this.items[i].volumen,
            cantidad: this.items[i].cantidad,
            descuento: this.items[i].descuento,
            precio: this.items[i].precio,
            sub_total: this.items[i].sub_total
          };

          this.prodId = id;
          this.cantidad = this.item.cantidad;
          this.descuento = this.item.descuento;
          this.precio = this.item.precio;
          this.itemSelected = true;

          $('#precio').focus().select();
          break;
        }
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

          this.calculateTotal();
          this.clearItemInputs();
          $('#prodSelect').focus();
        }
      }
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

      if ( (this.descuento < 0) || (this.descuento === "") ) {

        alert('Debe ingresar Porcentaje de Descuento o 0 en caso de no poseer');
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

        if (this.item.codigo == this.items[i].codigo) {
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
      this.itemSelected = false;
    },

    freightChange: function() {

      this.freight = Math.round(this.freight * 100) / 100;
      this.calculateTotal();
    },

    insuranceChange: function() {

      this.insurance = Math.round(this.insurance * 100) / 100;
      this.calculateTotal();
    },

    calculateTotal: function() {

      var totalPesoNeto = 0;
      var totalPesoBruto = 0;
      var totalVolumen = 0;
      var totalCajas = 0;
      var total = 0;

      for (var i=0; i < this.items.length; i++) {

        cajas = this.items[i].cantidad;
        pesoNeto = this.items[i].peso_neto * cajas;
        pesoBruto = this.items[i].peso_bruto * cajas;
        volumen = this.items[i].volumen * cajas;
        subTotal = this.items[i].sub_total;

        totalPesoNeto += pesoNeto;
        totalPesoBruto += pesoBruto;
        totalVolumen += volumen;
        totalCajas += cajas;
        total += subTotal;
      }

      this.totalPesoNeto = totalPesoNeto;
      this.totalPesoBruto = totalPesoBruto;
      this.totalVolumen = totalVolumen;
      this.totalCajas = totalCajas;

      this.fob = total;
      this.total = this.fob + this.freight + this.insurance;

  },
    numberFormat: function(x) {

        return x.toLocaleString(undefined, {minimumFractionDigits: 2})
    },

    updateClausula: function () {

        // FOB
        if (this.clausulaID == 2) {

            this.fobValidator = true;
            this.freightValidator = false;
            this.insuranceValidator = false;

        // CFR
        } else if (this.clausulaID == 3) {

                this.fobValidator = false;
                this.freightValidator = true;
                this.insuranceValidator = false;
        } else {

            this.fobValidator = true;
            this.freightValidator = true;
            this.insuranceValidator = true;
        }
    },

    sortItems: function() {
        this.items.sort(function(a, b){
                if (a.order < b.order)
                return -1;
                if (a.order > b.order)
                return 1;
            return 0;
            }
        );
    },

  },

  computed: {

  },

  watch: {

  },

  updated() {

    $('.selectpicker').selectpicker('refresh');
  }
});
