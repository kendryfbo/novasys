var app = new Vue({

    el: "#vue-app",

    data: {
        formulaID: '',
        formulas: formulas,
        items: [],
        premezcla: '',
        premezclaID: '',
        cantBatch: 1,
        totalBatch:0,

    },

    methods : {

        updateList: function() {

            for (var i = 0; i < this.formulas.length; i++) {

                if (this.formulas[i].id == this.formulaID) {

                    this.items = this.formulas[i].detalle;

                    if (this.formulas[i].premezcla) {
                        this.premezcla = this.formulas[i].premezcla.descripcion;
                        this.premezclaID = this.formulas[i].premezcla.id;
                    } else {
                        this.premezcla = 'NO POSEE PREMEZCLA ASOCIADA';
                    }
                    return;
                }
            }

        },

        calculate: function() {

            for (var i = 0; i < this.items.length; i++) {

                this.items[i].totalBatch = this.items[i].cantxbatch * this.cantBatch;
                this.totalBatch += this.items[i].totalBatch;
            }

            $('.selectpicker').selectpicker('refresh');
        }
    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    },

});
