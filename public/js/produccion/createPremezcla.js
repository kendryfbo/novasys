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
        vidaUtil: '',
        fechaProd: fechaProd,
        fechaVenc: '',
    },

    methods : {

        updateList: function() {

            for (var i = 0; i < this.formulas.length; i++) {

                if (this.formulas[i].id == this.formulaID) {

                    this.items = this.formulas[i].detalle;

                    if (this.formulas[i].premezcla) {
                        this.premezcla = this.formulas[i].premezcla.descripcion;
                        this.premezclaID = this.formulas[i].premezcla.id;
                        this.vidaUtil = this.formulas[i].producto.vida_util;
                        this.updateVenc();
                    } else {
                        this.premezcla = 'NO POSEE PREMEZCLA ASOCIADA';
                    }
                    return;
                }
            }

        },
        
        updateVenc: function() {

            if (!this.vidaUtil || !this.fechaProd) {

                return;
            }

            var fechaProd = new Date();
            var fechaVenc = new Date(this.fechaProd);

            fechaVenc.setMonth(fechaVenc.getMonth() + this.vidaUtil);
            var day = ("0" + (fechaVenc.getDate()+1)).slice(-2);
            var month = ("0" + (fechaVenc.getMonth() + 1)).slice(-2);
            var year = fechaVenc.getFullYear();

            this.fechavencLoteString = day + year + month;
            this.fechaVenc = year + '-' + month + '-' + day;

        },

        calculate: function() {

            for (var i = 0; i < this.items.length; i++) {

                this.items[i].totalBatch = this.items[i].cantxbatch * this.cantBatch;
                this.items[i].totalBatch = Math.round(this.items[i].totalBatch * 100) / 100;
                this.totalBatch += this.items[i].totalBatch;
            }
            this.totalBatch =  Math.round(this.totalBatch * 100) / 100;
            $('.selectpicker').selectpicker('refresh');
        }
    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    },

});
