var app = new Vue({
  el: '#vue-app',
  data: {
	  codigo: '',
	  descripcion: '',
	  marca: '',
	  formato: '',
	  sabor: '',
  },
  methods: {
	  updateDescripcion: function() {
          this.codigo = '';
          this.descripcion = '';

          if (this.marca.length) {
              this.codigo = this.marca;
              this.descripcion = this.marca;
          }

          if (this.formato.length) {
              this.codigo = this.codigo + this.formatNumber(this.formato);
              this.descripcion = this.descripcion + this.formatNumber(this.formato);
          }

          if (this.sabor.length) {
              this.codigo = this.codigo + this.formatNumber(this.sabor);
              this.descripcion = this.descripcion + this.formatNumber(this.sabor);
          }
	  },
      formatNumber : function(number) {
          return ("0" + number).slice(-2)
      }
  }
});
