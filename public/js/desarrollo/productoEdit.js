var app = new Vue({
  el: '#vue-app',
  data: {
	  codigo: codigo,
	  descripcion: descripcion,
	  marca: marca,
	  formato: formato,
	  sabor: sabor,
      peso_bruto: peso_bruto,
      peso_neto: peso_neto,
      volumen: volumen,
      marcas: marcas,
      formatos: formatos,
      sabores: sabores,
  },
  methods: {

      formatChange: function() {

        this.updatePesoNeto();
        this.updateDescripcion();
      },

      updatePesoNeto: function() {

        for (var i = 0; i < this.formatos.length; i++) {

            if (this.formato == this.formatos[i].id) {

                this.peso_neto = this.formatos[i].peso_neto;
                break;
            }

        }
      },

	  updateDescripcion: function() {

          this.codigo = '';
          this.descripcion = '';

          if (this.marca) {
              for (var i = 0; i < this.marcas.length; i++) {

                  if (this.marca == this.marcas[i].id) {

                      this.codigo = this.marcas[i].codigo + this.marcas[i].id;
                      this.descripcion = this.marcas[i].descripcion;
                      break;

                  }
              }
          }
          if (this.formato) {
              for (var i = 0; i < this.formatos.length; i++) {

                  if (this.formato == this.formatos[i].id) {

                      this.codigo = this.codigo + this.formatos[i].id;
                      this.descripcion = this.descripcion + " " + this.formatos[i].descripcion;
                      break;

                  }
              }
          }
          if (this.sabor) {

              for (var i = 0; i < this.sabores.length; i++) {

                  if (this.sabor == this.sabores[i].id) {

                      this.codigo = this.codigo + this.sabores[i].id;
                      this.descripcion = this.descripcion + " " + this.sabores[i].descripcion;
                      break;

                  }
              }
          }
	  },
  },

  mounted() {

      axios.get('/api/marcas').then(response => this.marcas = response.data);
      axios.get('/api/formatos').then(response => this.formatos = response.data);
      axios.get('/api/sabores').then(response => this.sabores = response.data);
  },
  updated() {
      $('.selectpicker').selectpicker('refresh');
  }
})
