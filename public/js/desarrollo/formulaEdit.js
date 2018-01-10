var app = new Vue({

  el: '#vue-app',

  data: {

      formato: formato,
      insumos: insumos,
      insumoSelected: '',
      nivelSelected: '',
      insumoID: '',
      niveles: niveles,
      nivelID: '',
      items: items,
      item: '',
      itemID: '',
      cantidad: '',
      selected: false,
      cantCaja: 0,
      cantBatch: 0,
      batch: batch,
  },

  methods: {

    loadFormaPago: function() {


    },

    loadInsumo: function() {

        this.selected = false;

        for (var i = 0; i < this.insumos.length; i++) {

            if (this.insumos[i].id == this.insumoID) {

                this.insumoSelected = this.insumos[i];
            }
        }
    },
    loadNivel: function() {

        this.selected = false;

        for (var i = 0; i < this.niveles.length; i++) {

            if (this.niveles[i].id == this.nivelID) {

                this.nivelSelected = this.niveles[i];
            }
        }
    },

    addItem: function() {

        if (!this.validateInput()) {
            alert('campos vacios');
            return;
        }

        this.calculate();

        if (this.selected) {
            for (var i = 0; i < this.items.length; i++) {

                if (this.items[i].id == this.itemID) {

                    this.items[i].nivel_id = this.nivelID;
                    this.items[i].insumo_id = this.insumoID;
                    this.items[i].cantxuni = this.cantidad;
                    this.items[i].cantxcaja = this.cantCaja;
                    this.items[i].cantxbatch = this.cantBatch;
                }
            }

        } else {

            if (this.duplicatedItem()) {
                alert('insumo ya se encuentra ingresado en la formula, seleccione de la lista para modificar.');
                return;
            }

            var item = {

                batch: this.batch,
                cantxcaja: this.cantCaja,
                cantxbatch: this.cantBatch,
                cantxuni: this.cantidad,
                descripcion: this.insumoSelected.descripcion,
                insumo_id: this.insumoSelected.id,
                nivel_id: this.nivelID,
                insumo: this.insumoSelected,
                nivel: this.nivelSelected,
            };

            this.items.push(item);
        }

        this.clearItemInputs();
        this.selected = false;
    },

    loadItem: function(id) {

        for (var i = 0; i < this.items.length; i++) {

            if (this.items[i].id == id) {

                this.itemID = this.items[i].id;
                this.nivelID = this.items[i].nivel_id;
                this.loadNivel();
                this.insumoID = this.items[i].insumo_id;
                this.cantidad = this.items[i].cantxuni;
                this.selected = true;

            }
        }

    },

    removeItem: function() {

        if (!this.selected) {
            alert('debe seleccionar un item para borrar.');
            return;
        }

        for (var i = 0; i < this.items.length; i++) {

            if (this.items[i].id == this.itemID) {

                this.items.splice(i,1);
            }
        }

        this.clearItemInputs();
        this.selected = false;
    },

    calculate: function() {

        this.cantCaja = ((this.cantidad * this.formato.peso_neto) / this.formato.peso_uni) * 1000;
        this.cantBatch = ((this.batch * this.cantidad) / (this.formato.peso_uni)) * 1000;
    },

    validateInput: function() {

        if (this.batch && this.cantidad) {
            return true;
        }
        return false;
    },

    duplicatedItem: function() {

        for (var i = 0; i < this.items.length; i++) {

            if (this.items[i].insumo.id == this.insumoID) {

                return true;
            }
        }
        return false;
    },

    clearItemInputs: function() {

        this.insumoID = "";
        this.nivelID = "";
        this.cantidad = "";
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
