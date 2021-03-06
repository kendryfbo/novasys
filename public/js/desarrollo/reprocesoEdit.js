var app = new Vue({
  el: '#vue-app',
  data: {
	  codigo: $('input[name=codigo]').val(),
	  descripcion: $('input[name=descripcion]').val(),
	  familia: codFamilia,
	  marca: $('select[name=marca]').val(),
	  sabor: $('select[name=sabor]').val(),
      formato: $('select[name=formato]').val(),
      marcas: [],
      sabores: [],
      formatos: formatos,
  },

  methods: {
	  updateDescripcion: function() {

          this.codigo = this.familia;
          this.descripcion = "REPROCESO";

          if (this.marca) {
              for (var i = 0; i < this.marcas.length; i++) {

                  if (this.marca == this.marcas[i].id) {
                      this.codigo = this.codigo + this.marcas[i].codigo;
                      this.descripcion = this.descripcion + " " + this.marcas[i].descripcion;
                      break;
                  }
              }
          }
          if (this.sabor) {

              for (var i = 0; i < this.sabores.length; i++) {

                  if (this.sabor == this.sabores[i].id) {

                      this.codigo = this.codigo + this.formatNumber(this.sabores[i].id);
                      this.descripcion = this.descripcion + " " + this.sabores[i].descripcion;
                      break;

                  }
              }
          }
          if (this.formato) {

              for (var i = 0; i < this.formatos.length; i++) {

                  if (this.formato == this.formatos[i].id) {

                      this.codigo = this.codigo + this.formatNumber(this.formatos[i].id);
                      this.descripcion = this.descripcion + " " + this.formatos[i].peso_uni +"g";
                      break;

                  }
              }
          }
	  },

      formatNumber : function(number) {
          return ("0" + number).slice(-2)
      },
  },

  mounted() {
	  axios.get('/api/marcas').then(response => this.marcas = response.data);
	  axios.get('/api/sabores').then(response => this.sabores = response.data);
  },
  updated() {
      $('.selectpicker').selectpicker('refresh');
  }
})
