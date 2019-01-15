var app = new Vue ({

    el: '#vue-app',

    data: {
        tipoDoc: tipoDoc,
        docId: docId,
        bodegas: bodegas,
        bodega: '',
        items: items,
        validate: false,
    },

    methods: {

        consult: function() {

            this.validate = false;

            url = '/bodega/egreso/existencia';

            axios.post(url,{
                tipoDoc: this.tipoDoc,
                docId: this.docId,
                bodega: this.bodega,
            })
			.then(response => this.updateItems(response.data))
			.catch(error => this.handleError(error))
        },

        updateItems: function(data) {


            this.items = data;
            this.validateExistencia();
        },

        validateExistencia: function() {

            for (var i = 0; i < this.items.length; i++) {

                if (this.items[i].cantidad > this.items[i].existencia) {

                    this.validate = false;

                    return;
                }
            }

            this.validate = true;
        },

        handleError: function(error) {

            alert(error);
        }
    },

    updated() {
        $('.selectpicker').selectpicker('refresh');
    }

});
