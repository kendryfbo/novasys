var app = new Vue({

  el: '#vue-app',

  data: {

    clientes: clientes,
    clienteId: '',
    formaPagoDescrip: '',
    productos: productos,
    prodId: '',
    item: [],
    itemSelected: false,
    items: [],
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

  },

  methods: {

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
            id: this.productos[i].id,
            codigo: this.productos[i].codigo,
            descripcion: this.productos[i].descripcion,
            formato: this.productos[i].formato,
            pesoBruto: this.productos[i].peso_bruto,
            pesoNeto: this.productos[i].peso_neto,
            volumen: this.productos[i].volumen,
            cantidad: 0,
            descuento: 0,
            precio: 0,
            total: 0
          };

          break;
        }
      }
    },

    addItem: function() {

      if (this.validateInput()) {

        if (this.itemSelected) {


        } else {

          this.item.cantidad = this.cantidad;
          this.item.descuento = this.descuento;
          this.item.precio = this.precio;

          if (this.descuento > 0) {
            descuento = ((this.precio * this.descuento) / 100);
          } else {
            descuento = 0;
          }
          this.item.total = (this.precio - descuento) * this.cantidad;
          this.item.total = Math.round(this.item.total * 100) / 100;
          this.items.push(this.item);

        }

        this.calculateTotal();
        this.clearItemInputs();
        $('#prodSelect').focus();
      }

    },

    loadItem: function(id) {

      for (var i=0; i < this.items.length; i++) {

        if (id == this.items[i].id) {

          this.item = {
            id: this.items[i].id,
            codigo: this.items[i].codigo,
            descripcion: this.items[i].descripcion,
            formato: this.items[i].formato,
            pesoBruto: this.items[i].peso_bruto,
            pesoNeto: this.items[i].peso_neto,
            volumen: this.items[i].volumen,
            cantidad: this.items[i].cantidad,
            descuento: this.items[i].descuento,
            precio: this.items[i].precio,
            total: this.items[i].total
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

      if (this.selected == false) {
        alert('Debe seleccionar producto que desea eliminar');
        return;
      }

      for (var i=0; i < this.items.length; i++) {

        if (this.prodId == this.items[i].id) {
          this.items.splice(i,1);

          this.calculateTotal();
          this.clearItemInputs();
          this.itemSelected = false;
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
      this.descuento = '';
      this.precio = '';
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
        pesoNeto = this.items[i].pesoNeto * cajas;
        pesoBruto = this.items[i].pesoBruto * cajas;
        volumen = this.items[i].volumen * cajas;
        subTotal = this.items[i].total;

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

      this.fob = this.fob.toLocaleString();
      this.total = this.total.toLocaleString();

    }
  },

  computed: {

  },

  watch: {

  },

  updated() {

    $('.selectpicker').selectpicker('refresh');
  }
});
