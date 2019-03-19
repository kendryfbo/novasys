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
    docuPago: '',
    formaPago: '',
    bancoCheque: '',
    fechaCobroCheque: '',
    antAbono: '',
    restante: '',
    notasCredito: notasCredito,
    notasDebito: notasDebito,
    notaCred: '',
    facturaFromClienteURL: facturaFromClienteURL,
    abonoFromClienteURL: abonoFromClienteURL,
    abonoStatus: 'Usar',
    ncStatus: 'Usar',
    pagoDirecto: 1,
    pagoAbono: 0,
    pagoNC: 0,
    inputPagoDirectoDisabled: false,
    },

    methods: {

    formatPrice(value) {
       let val = (value/1).toFixed(0).replace(',', '.')
       return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    },

        numberFormat: function(x) {

        return x.toLocaleString(undefined, {minimumFractionDigits: 0})
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

        cargarNotaDebito: function(notaDebitoID,event) {

          console.log(event);
          for (var i = 0; i < this.notasDebito.length; i++) {
            if (this.notasDebito[i].id == notaDebitoID) {
              if (this.notasDebito[i].deuda <= this.montoDepo) {
                event.target.value = this.notasDebito[i].deuda;
                return;
              }
              else {
                event.target.value = Number(this.montoDepo);
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
              this.facturas[i].deuda = this.facturas[i].deuda - this.facturas[i].pago;
              this.montoDepo = this.montoDepo - this.facturas[i].pago;
              break;
            }
          }
          document.getElementById(facturaID).value = 0;
        },

        registrarPagoND: function(notaDebitoID) {

        var pago = document.getElementById(notaDebitoID).value;
          for (var i = 0; i < this.notasDebito.length; i++) {
            if (this.notasDebito[i].id == notaDebitoID) {

              if (pago > this.notasDebito[i].deuda) {
                alert('el monto del pago es mayor al monto restante de la factura');
                break;
              }
              this.notasDebito[i].pago = Number(pago);
              this.notasDebito[i].deuda = this.notasDebito[i].deuda - this.notasDebito[i].pago;
              this.montoDepo = this.montoDepo - this.notasDebito[i].pago;
              break;
            }
          }
          document.getElementById(notaDebitoID).value = 0;
        },

        utilizarAbono: function(abonoID) {

          var anticipo = document.getElementById(abonoID).value;

          for (var i = 0; i < this.abonos.length; i++) {
            if (this.abonos[i].id == abonoID) {

              if (anticipo > this.abonos[i].restante) {
                alert('el monto del Anticipo es mayor al saldo restante');
                break;
              }
              this.antAbono = this.abonos[i].id;
              this.abonos[i].anticipo = Number(anticipo);
              this.abonos[i].restante = this.abonos[i].restante - this.abonos[i].anticipo;
              this.saldoTotalAbono = this.saldoTotalAbono - this.abonos[i].anticipo;
              this.montoDepo = this.abonos[i].anticipo;
              this.montoAnticipo = this.abonos[i].anticipo;
              this.docuPago = this.abonos[i].docu_abono;
              if (this.abonos[i].formaPago_id == null) {
                  this.formaPago = 6;
              } else {
                    this.formaPago = this.abonos[i].formaPago_id;
              }
              this.bancoCheque = this.abonos[i].banco_id;
              this.fechaCobroCheque = this.abonos[i].fecha_cobro;
              this.abonoStatus = "Usado";
              this.setPagoAbono();
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
              this.notaCred = this.notasCredito[i].id;
              this.notasCredito[i].notaCredito = Number(notaCredito);
              this.notasCredito[i].restante = this.notasCredito[i].restante - this.notasCredito[i].notaCredito;
              this.saldoTotalNC = this.saldoTotalNC - this.notasCredito[i].notaCredito;
              this.formaPago = 6;
              this.montoDepo = this.notasCredito[i].notaCredito;
              this.montoNC = this.notasCredito[i].notaCredito;
              this.docuPago = 'NC ' + this.notasCredito[i].numero;
              this.ncStatus = "Usado";
              this.setPagoNC();
              break;
            }
          }
          document.getElementById(notaCreditoID).value = 0;
        },

        handleError: function(error){
            console.log(error);
            alert(error);

        },

        setPagoAbono: function() {

          this.pagoDirecto = 0;
          this.pagoNC = 0;
          this.pagoAbono = 1;
          this.inputPagoDirectoDisabled = true;
        },
        setPagoNC: function() {

          this.pagoDirecto = 0;
          this.pagoNC = 1;
          this.pagoAbono = 0;
          this.inputPagoDirectoDisabled = true;
        }
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
