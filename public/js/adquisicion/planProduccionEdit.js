$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        document.getElementById("addItem").click();
        return false;
    }
});

var app = new Vue({

  el: '#vue-app',

  data: {

      productos: productos,
      items: items,
      cantidad: 0,
      itemID: '',
      maquina: '',
      maquinaID: '',
      dia: '',
      destino: ''
  },

  methods: {

      addItem: function() {


            if (!this.validateInput()) {
              return;
            }

            for (var i = 0; i < this.productos.length; i++) {

                if (this.productos[i].id == this.itemID) {


                    this.productos[i].cantidad = this.cantidad;
                    this.productos[i].producto_id = this.productos[i].id;
                    this.productos[i].maquina = this.maquina;
                    this.productos[i].dia = this.dia;
                    this.productos[i].destino = this.destino;
                    this.items.push(this.productos[i]);
                    this.productos.splice(i,1);
                    this.itemID = '';
                    this.cantidad = 0;

                    return;
                }
            }
      },

      removeItem: function(id) {

          for (var i = 0; i < this.items.length; i++) {

              if (this.items[i].id == id) {

                  this.productos.push(this.items[i]);
                  this.items.splice(i,1);
                  return;
              }
          }
      },

      validateInput: function() {

        if (!this.itemID || !(this.cantidad > 0)) {

            alert('debe seleccionar producto y colocar la cantidad mayor a 0.');
            return false;
        }

        if (this.duplicatedItem()) {
          alert('Producto ya se encuentra ingresado');
          return false;
        }

        return true;
      },

      duplicatedItem: function() {

        for (var i = 0; i < this.items.length; i++) {
          if (this.items[i].producto_id == this.itemID) {
            return true;
          }
        }
        return false;
      }
  },

  computed: {

  },

  watch: {

  },

  updated() {

    $('.selectpicker').selectpicker('refresh');
  }
});
