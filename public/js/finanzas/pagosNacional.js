var app = new Vue({
  	el: '#vue-app',
  data: {
    clienteId: '',
    clientes: clientes,
    credito: '',
    facturas: facturas,
    facturaId: [],
    abonos: abonos,
    saldoTotalAbono: saldoTotalAbono,
    saldoTotalNC: saldoTotalNC,
    montoDepo: '',
    montoNC: '',
    montoAnticipo: '',
    abonoId: '',
    restante: '',
    notasCredito: notasCredito,
    facturaFromClienteURL: facturaFromClienteURL,
    abonoFromClienteURL: abonoFromClienteURL,
    },

    methods: {

    formatPrice(value) {
       let val = (value/1).toFixed(2).replace(',', '.')
       return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },

        numberFormat: function(x) {

        return x.toLocaleString(undefined, {minimumFractionDigits: 2})
    },

        loadDatos: function() {

            this.getFacturasByCliente();
            this.getAbonosByCliente();

        },

        cargarPago: function(facturaID,event) {

          console.log(event);
          for (var i = 0; i < this.facturas.length; i++) {
            if (this.facturas[i].id == facturaID) {
              if (this.facturas[i].deuda <= this.montoDepo) {
                event.target.value = Number(this.facturas[i].deuda);
                return;
              }
              else {
                event.target.value = Number(this.montoDepo);
                break;
              }
            }
          }

        },

        cargarAbono: function(abonoID,event) {

          console.log(event);
          for (var i = 0; i < this.abonos.length; i++) {
            if (this.abonos[i].id == abonoID) {
              if (this.abonos[i].restante <= this.saldoTotalAbono) {
                event.target.value = this.abonos[i].restante;
                break;
              }
              else {
                event.target.value = this.abonos[i].restante;
                break;
              }
            }
          }

        },

        cargarNotaCredito: function(notaCreditoID,event) {

          console.log(event);
          for (var i = 0; i < this.notasCredito.length; i++) {
            if (this.notasCredito[i].id == notaCreditoID) {
              if (this.notasCredito[i].restante >= this.saldoTotalAbono) {
                event.target.value = this.notasCredito[i].restante;
                break;
              }
              else {
                event.target.value = this.notasCredito[i].restante;
                break;
              }
            }
          }

        },

        registrarPago: function(facturaID) {

        var pago = document.getElementById(facturaID).value;

          for (var i = 0; i < this.facturas.length; i++) {
            if (this.facturas[i].id == facturaID) {

              if (pago > this.facturas[i].deuda) {
                alert('el monto del pago es mayor al monto restante de la factura');
                break;
              }
              this.facturas[i].pago = Number(pago)
              this.montoDepo = this.montoDepo - this.facturas[i].pago;
              break;
            }
          }
          document.getElementById(facturaID).value = 0;
        },

        utilizarAbono: function(abonoID) {

          var anticipo = document.getElementById(abonoID).value;

          for (var i = 0; i < this.abonos.length; i++) {
            if (this.abonos[i].id == abonoID) {

              if (anticipo > this.abonos[i].restante) {
                alert('el monto del Anticipo es mayor al saldo restante');
                break;
              }
              this.abonos[i].anticipo = anticipo
              this.saldoTotalAbono = this.saldoTotalAbono - anticipo;
              this.montoDepo = this.abonos[i].anticipo;
              this.montoAnticipo = this.abonos[i].anticipo;
              break;
            }
          }
          document.getElementById(abonoID).value = 0;
        },

        utilizarNotaCredito: function(notaCreditoID) {

          var notaCredito = document.getElementById(notaCreditoID).value;

         for (var i = 0; i < this.notasCredito.length; i++) {
            if (this.notasCredito[i].id == notaCreditoID) {

              if (notaCredito > this.notasCredito[i].restante) {
                alert('el monto de Nota de Crédito es mayor al saldo restante');
                break;
              }
              this.notasCredito[i].notaCredito = notaCredito
              this.saldoTotalNC = this.saldoTotalNC - notaCredito;
              this.montoDepo = this.notasCredito[i].notaCredito;
              this.montoNC = this.notasCredito[i].notaCredito;
              break;
            }
          }
          document.getElementById(notaCreditoID).value = 0;
        },

        handleError: function(error){
            console.log(error);
            alert(error);

        },

    },

    computed: {
        montoAbonado: function() {
               if (!this.abonos) {
                   return 0;
               }
               return this.abonos.reduce(function (total, value) {
                   return (total + Number(value.restante));
               }, 0);
        },

        montoFactura: function() {
                if (!this.facturas) {
                    return 0;
                }
                return this.facturas.reduce(function (deuda, value) {
                    return (deuda + Number(value.deuda));
                }, 0);
        },

  },

   updated() {
     $('.selectpicker').selectpicker('refresh');
 },

});
