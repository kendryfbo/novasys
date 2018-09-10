var app = new Vue({
  el: '#vue-app',
  data: {
      lastID: lastID,
      codigo: '',
      descripcion: '',
      familia: '',
      unidad: '',
      familias: familias,
  },
  methods: {

      updateCodigo: function() {

          for (var i = 0; i < this.familias.length; i++) {

              if (this.familias[i].id == this.familia) {
                  this.codigo = this.familias[i].codigo + this.lastID;
                  return;
              }
          }
      }

  },

  updated() {
      $('.selectpicker').selectpicker('refresh');
  }
})
