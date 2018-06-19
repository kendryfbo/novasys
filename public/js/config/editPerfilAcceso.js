var app = new Vue({

    el: '#vue-app',

    data: {
        modulos: modulos,
        accesos: accesos,
    },

    methods: {

        updateAcceso: function(id) {

            for (var i = 0; i < this.accesos.length; i++) {

                if (this.accesos[i].id == id) {

                    let temp = this.accesos[i];
                    temp.access = !temp.access;
                    Vue.set(this.accesos,i,temp);
                    return;
                }
            }
        },

        updateModulo: function(modulo,event) {

            let check = event.target.checked;

            for (var i = 0; i < this.accesos.length; i++) {

                if (this.accesos[i].modulo == modulo) {

                    let temp = this.accesos[i];
                    temp.access = check;
                    Vue.set(this.accesos,i,temp);
                }
            }
        },

        unSelectAll: function() {

            for (var i = 0; i < this.accesos.length; i++) {

                let temp = this.accesos[i];
                temp.access = false;
                Vue.set(this.accesos,i,temp);
            }
        },

        selectAll: function() {

            for (var i = 0; i < this.accesos.length; i++) {

                let temp = this.accesos[i];
                temp.access = true;
                Vue.set(this.accesos,i,temp);
            }
        }
    },
});
