var app = new Vue({
  	el: '#vue-app',
  data: {
    clienteId: '',
    clientes: clientes,
    credito: '',
    facturas: [],
    facturaId: [],
    facturaFromClienteURL: facturaFromClienteURL,
    abonoId: '',
    abonos: [],
    abonoFromClienteURL: abonoFromClienteURL,
    },

    computed: {
        montoAbonado: function() {
               if (!this.abonos) {
                   return 0;
               }
               return this.abonos.reduce(function (total, value) {
                   return (total + Number(value.monto));
               }, 0);
        },

        montoFactura: function() {
                if (!this.facturas) {
                    return 0;
                }
                return this.facturas.reduce(function (total, value) {
                    return (total + Number(value.total));
                }, 0);
        }
   },

    methods: {

        loadDatos: function() {

            this.getFacturasByCliente();
            this.getAbonosByCliente();

        },

        getFacturasByCliente: function() {

            var url = this.facturaFromClienteURL;

    		axios.post(url,{
                clienteId: this.clienteId
            })
    		.then(response => this.loadFacturas(response.data))
    		.catch(error => this.handleError(error))

        },

            loadFacturas: function(data) {

                this.facturas = data;
                for (var i = 0; i < this.clientes.length; i++) {
                    if (this.clienteId ==  this.clientes[i].id) {
                        this.credito = this.clientes[i].credito;
                    }
                }
            },

            getAbonosByCliente: function() {

                var url = this.abonoFromClienteURL;

                axios.post(url,{
                    clienteId: this.clienteId
                })
                .then(response => this.loadAbonos(response.data))
                .catch(error => this.handleError(error))

            },

            loadAbonos: function(data) {
                this.abonos = data;

                for (var i = 0; i < this.abonos.length; i++) {
                    if (this.clienteId ==  this.abonos[i].cliente_id) {
                        this.montoAbonado = this.abonos[i].monto;

                    }
                }

            },

            cargarPagos: function(facturaID,cantPago) {

                //

            },

            handleError: function(error){
                console.log(error);
                alert(error);

            },

        updated() {
          $('.selectpicker').selectpicker('refresh');
      }
    },





});
