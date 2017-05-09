var app = new Vue({
  el: '#vue-app',
  data: {
	  peso: '',
	  unidad: '',
	  sobre: '',
	  display: '',
	  descripcion: '',
  },
  methods: {
	  updateDescripcion: function() {
		  if (!(this.unidad.lenght == 0)) {
			  this.descripcion = this.unidad
		  }
		  if (this.peso) {
			  this.descripcion = this.peso + this.descripcion
		  }
		  if (this.sobre) {
			  this.descripcion = this.sobre +'x'+ this.descripcion
		  }
		  if (this.display) {
			  this.descripcion = this.display +'x'+ this.descripcion
		  }
	  }
  }
});
app.descripcion = app.peso;
