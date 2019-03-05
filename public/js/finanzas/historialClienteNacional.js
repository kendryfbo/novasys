var app = new Vue({
  	el: '#vue-app',
  data: {
    clienteId: '',
    clientes: clientes,
    credito: '',
    facturas: [],
    facturaId: [],
    historialFromClienteURL: historialFromClienteURL,
            },

        methods: {

            getHistorialByCliente: function() {

                var url = this.historialFromClienteURL;

    			axios.post(url,{
                    clienteId: this.clienteId
                })
    			.then(response => this.loadFacturas(response.data))
    			.catch(error => this.handleError(error))

            },

            loadFacturas: function(data) {

                this.facturas = data;

            },


            handleError: function(error){
                console.log(error);
                alert(error);

            },

        updated() {
          $('.selectpicker').selectpicker('refresh');
        }
    }
});
