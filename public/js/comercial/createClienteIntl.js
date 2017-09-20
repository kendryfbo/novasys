var app = new Vue({

    el: '#vue-app',

    data: {

        credito: '',
        creditoWithFormat: ''
    },

    methods: {

        formatCredito: function() {

            console.log('formatear credito');

            var str = this.creditoWithFormat
            this.credito = Math.round(Number(str) * 100) / 100;
            console.log("str = " + str);

            str = parseFloat(str);
            console.log("str = " + str);

            str = Math.round(str * 100) / 100;
            console.log("str = " + str);

            str = str.toLocaleString();
            console.log("str = " + str);

            this.creditoWithFormat = str;
        },

        unFormatCredito: function() {

            this.creditoWithFormat = this.credito;
        }
    }
});
