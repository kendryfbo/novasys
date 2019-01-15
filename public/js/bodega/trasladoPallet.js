var trasladoPallet = new Vue({

    el: '#trasladoPallet',
    data: {
        bodegas: [],
        posiciones: [],
        bodegaID: '',
        newPosicionID: '',
        posicion: '',
    },

    methods: {

        loadPosiciones: function() {

            for (var i = 0; i < this.bodegas.length; i++) {

                if (this.bodegas[i].id == this.bodegaID) {

                    this.posiciones = this.bodegas[i].posiciones;
                    return;
                }
            }
        },

        getBodegasWithPos: function() {

            var url = '/api/bodega/';

			axios.get(url)
			.then(response => this.loadBodegas(response.data))
			.catch(error => this.handleError(error))
        },

        loadBodegas: function(data){

            this.bodegas = data;
        },

        handleError: function(error) {

            alert(error);
        }


    },

    mounted: function() {

        this.getBodegasWithPos();
    },

    updated() {

      $('.selectpicker').selectpicker('refresh');
    }
});
