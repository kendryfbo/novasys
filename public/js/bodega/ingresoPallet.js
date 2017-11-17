var app = new Vue({

    el: '#vue-app',

    data: {
        palletNum: '',
        pallet: '',
        posicion: '',
    },

    methods: {

        getPallet: function() {

            this.pallet= '';
            this.posicion= '';

            var url = '/bodega/pallet/data';
			axios.post(url,{
                numero: this.palletNum
            })
			.then(response => this.loadPallet(response.data))
			.catch(error => this.handleError(error))
        },

        loadPallet: function(data) {

            this.pallet = data;

            if (this.pallet.almacenado) {

                alert('Pallet ya se encuentra almacenado');
                this.pallet= [];
                this.posicion= [];
                return;
            }

            this.getPosition();
        },

        getPosition: function() {

            var url = '/bodega/pallet/'+ this.pallet.id +'/findPosition';

			axios.get(url)
			.then(response => this.loadPosition(response.data))
			.catch(error => this.handleError(error))
        },

        loadPosition: function(data) {

            this.posicion = data;

        },

        handleError: function() {

            alert(error);
        }
    },


    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
