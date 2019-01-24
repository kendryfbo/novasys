var app = new Vue({
  	el: '#vue-app',
  data: {
    clienteId: '',
    facturas: facturas,
    monto: '',
    },

    methods: {

        getFacturasByCliente: function() {

            for (var i = 0; i < this.facturas.length; i++) {
                    if (this.clienteId ==  this.facturas[i].cliente_id) {
                        this.monto = this.facturas[i].total;

                    }
                }

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
