var app = new Vue({

  el: '#vue-app',

  data: {

      productos: productos,
      items: [],
      cantidad: 0,
      itemID: '',
  },

  methods: {

      addItem: function() {

            if (!this.itemID || !(this.cantidad > 0)) {

                alert('debe seleccionar producto y colocar la cantidad mayor a 0.');
                return;
            }
            for (var i = 0; i < this.productos.length; i++) {

                if (this.productos[i].id == this.itemID) {

                    this.productos[i].cantidad = this.cantidad;
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
