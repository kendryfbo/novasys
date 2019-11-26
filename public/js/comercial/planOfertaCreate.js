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
      clientes: clientesNac,
      canales: canales,
      items: [],
      descuento: 0,
      itemID: '',
      clientID: '',
      canalID: '',
  },

  methods: {

      addItem: function() {

          for (var i = 0; i < this.productos.length; i++) {

              if (this.productos[i].id == this.itemID) {

                for (var j = 0; j < this.clientes.length; j++) {

                  if (this.clientes[j].id == this.clientID) {

                    var item = {

                    item_id: this.items.length + 1,
                    id: this.productos[i].id,
                    clientID: this.clientID,
                    cliente: this.clientes[j].descripcion,
                    descripcion: this.productos[i].descripcion,
                    descuento: this.descuento,
                    producto_id: this.productos[i].id

                    }

                  this.items.push(item);
                  this.clientID = '';
                  this.itemID = '';
                  this.descuento = 0;
                  item = {};
                  return;
                  }
                }
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
