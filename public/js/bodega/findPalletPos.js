
var findPalletPos = new Vue({

    el: '#findPalletPos',
    data: {

        palletNumForFind: '',
        pallet: [],
        bodegaDescrip: '',
        posicionDescrip: '',
        msg:'',
        findPalletPosURL: findPalletPosURL,
    },

    methods: {

        findPallet: function() {

            var palletNum = this.palletNumForFind;
            var url =findPalletPosURL;
            this.clearInputs();
            this.palletNumForFind = palletNum;

			axios.post(url,{
                palletNum: palletNum,
            })
			.then(response => this.getPallet(response.data))
			.catch(error => this.handleError(error))
        },

        getPallet: function(data) {

            if (data) {

                this.pallet = data;

                if (this.pallet.posicion) {

                    this.bodegaDescrip = this.pallet.posicion.bodega.descripcion;
                    this.posicionDescrip = this.pallet.posicion.bloque +'-'+this.pallet.posicion.columna+'-'+this.pallet.posicion.estante
                    this.msg= "Encontrado";
                    return;
                }

                this.msg= "Pallet no almacenado";
                return;

            }
            this.msg= "Numero de pallet no existe";
            return;
        },

        handleError: function(error) {

            console.log(error);
			alert(error);
        },

        clearInputs: function() {

            this.palletNumForFind = '';
            this.pallet = [];
            this.bodegaDescrip = '';
            this.posicionDescrip = '';
            this.msg ='';
        }
    },

    mounted: function() {
        this.clearInputs();
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
