var app = new Vue ({

  el: '#vue-app',

  methods: {

    confirmDesautorizar: function(event) {

      var confirmation = confirm('Confirmar Desautorización de Nota de Venta?');

      if (!confirmation) {

        event.preventDefault();
      }

      event.target.submit();

    },

    confirmAutorizar: function(event) {

      var confirmation = confirm('Confirmar Autorización de Nota de Venta?');

      if (!confirmation) {

        event.preventDefault();
      }

      event.target.submit();

    }
  }
});
