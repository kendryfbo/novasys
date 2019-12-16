var app = new Vue({

  el: '#vue-app',

  data: {

      items: items,
      meses: meses,
      amount: '',
      mesID: '',
      month: '',
  },

  methods: {

      addItem: function() {

          for (var i = 0; i < this.meses.length; i++) {

              if (this.meses[i].id == this.mesID) {

                    var item = {
                    item_id: this.items.length + 1,
                    mesID: this.meses[i].id,
                    month: this.meses[i].id,
                    amount: this.amount,
                    }

                  this.items.push(item);
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
