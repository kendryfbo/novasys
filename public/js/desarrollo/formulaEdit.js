var app = new Vue({

  el: '#vue-app',

  data: {

      insumos: insumos,
      insumo: '',
      niveles: niveles,
      items: [],
      item: '',
      itemId: '',
      cantidad: '',
  },

  methods: {

    loadFormaPago: function() {


    },

    loadInsumo: function() {

        for (var i = 0; i < this.insumos.length; i++) {

            if (this.insumos[i].id == this.itemId) {

                this.insumo = this.insumos[i];
            }
        }
    },

    addItem: function() {

    },

    loadItem: function() {

    },

    removeItem: function() {

    },

    validateInput: function() {


    },

    duplicatedItem: function() {

    },

    clearItemInputs: function() {

    },

    },

    computed: {

    },

    watch: {

    },

    created() {

    },

    updated() {

        $('.selectpicker').selectpicker('refresh');
    }
});
