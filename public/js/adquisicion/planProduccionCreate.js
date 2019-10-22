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
      items: [],
      cantidad: 0,
      itemID: '',
      maquina: '',
      maquinaID: '',
      dia: '',
      destino: ''
  },

  methods: {

      addItem: function() {

            if (!this.itemID || !(this.cantidad > 0)) {

                alert('debe seleccionar producto y colocar la cantidad mayor a 0.');
                return;
            }
            for (var i = 0; i < this.productos.length; i++) {

                if (this.productos[i].id == this.itemID) {

                  var item = {
                    item_id: this.items.length + 1,
                    id: this.productos[i].id,
                    codigo: this.productos[i].codigo,
                    descripcion: this.productos[i].descripcion,
                    item_id: this.items.length + 1,
                    cantidad: this.cantidad,
                    producto_id: this.productos[i].id,
                    maquina: this.maquina,
                    dia: this.dia,
                    destino: this.destino
                  }

                  this.items.push(item);
                  //this.productos.splice(i,1);
                  this.itemID = '';
                  this.cantidad = 0;
                  item = {};
                  return;
                }
           }
      },

      removeItem: function(id) {

          for (var i = 0; i < this.items.length; i++) {

              if (this.items[i].item_id == id) {

                  this.productos.push(this.items[i]);
                  this.items.splice(i,1);
                  return;
              }
          }
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
