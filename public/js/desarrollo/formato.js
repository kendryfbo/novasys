var app = new Vue({
  el: '#vue-app',
  data: {
	  peso: $('input[name=peso]').val(),
	  unidad: $('select[name=unidad]').val(),
	  sobre: $('input[name=sobre]').val(),
	  display: $('input[name=display]').val(),
	  descripcion: $('input[name=descripcion]').val(),
  },
  methods: {
	  updateDescripcion: function() {

          this.descripcion = '';

		  if (this.unidad) {
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
  },

  mounted() {
      this.updateDescripcion();
  },
  updated() {
      $('.selectpicker').selectpicker('refresh');
  }
});
