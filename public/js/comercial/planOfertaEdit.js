var app = new Vue({

  el: '#vue-app',

  data: {

      productos: productos,
      clientes: clientesNac,
      items: items,
      descuento: 0,
      itemID: '',
      clientID: '',
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
                    nombre_cliente: this.clientes[j].descripcion,
                    nombre_producto: this.productos[i].descripcion,
                    descuento: this.descuento,
                    producto_id: this.productos[i].id,
                    cliente_id: this.clientID,

                    }

                  this.items.push(item);
                  this.itemID = '';
                  this.clientID = '';
                  this.descuento = 0;
                  item = {};
                  return;
                  }
                }
              }
            }
      },

      removeItem: function(key) {

            this.items.splice(key,1);

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
