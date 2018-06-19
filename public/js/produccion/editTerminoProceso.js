var app = new Vue({

    el: "#vue-app",

    data: {

        productos: productos,
        prodId: prodId,
        fechaProd: fechaProd,
        fechaVenc: fechaVenc,
        fechavencLoteString: '',
        vidaUtil: '',
        turnos: turnos,
        turno: turno,
        maquina: '',
        operador: '',
        codigo: '',
        batch: '',
        lote: lote,
    },

    methods : {

        updateVenc: function() {

            if (!this.vidaUtil) {

                return;
            }

            var fechaProd = new Date();
            var fechaVenc = new Date(this.fechaProd);

            fechaVenc.setMonth(fechaVenc.getMonth() + this.vidaUtil);

            var day = ("0" + fechaVenc.getDate()+1).slice(-2);
            var month = ("0" + (fechaVenc.getMonth() + 1)).slice(-2);
            var year = fechaVenc.getFullYear();

            this.fechavencLoteString = day + month + year;
            this.fechaVenc = year + '-' + month + '-' + day;

        },

        updateVidaUtil: function() {

            for (var i = 0; i < this.productos.length; i++) {

                if (this.productos[i].id == this.prodId) {

                    this.vidaUtil = this.productos[i].vida_util;
                }
            }

            this.updateVenc();
        },

        updateNumLote: function() {

            if (this.fechavencLoteString && this.turno && this.maquina && this.operador && this.batch) {


                this.lote = this.fechavencLoteString + this.maquina + this.operador + this.turno.charAt(0) + this.codigo + this.batch;
            }
        }
    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    }

});
