// Input for pesos Integer
Vue.component('moneda-input', {
    props: ["value"],
    template: `
        <div>
            <input type="text" class="form-control text-right" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true"/>
        </div>`,
    data: function() {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function() {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString()
                } else {
                    // User is not modifying now. Format display value for user interface
                    return "$ " + this.value.toFixed(0).replace(/(\d)(?=(\d{3})+(?:\,\d+)?$)/g, "$1.")
                }
            },
            set: function(modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = Math.round(parseFloat(modifiedValue.replace(/[^\d\.]/g, "")));
                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0
                }
                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit('input', newValue)
            }
        }
    }
});

// Input for pesos Integer Readonly
Vue.component('moneda-input-readonly', {
    props: ["value"],
    template: `
        <div>
            <input type="text" class="form-control text-right" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true"readonly/>
        </div>`,
    data: function() {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function() {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString()
                } else {
                    // User is not modifying now. Format display value for user interface
                    return "$ " + this.value.toFixed(0).replace(/(\d)(?=(\d{3})+(?:\,\d+)?$)/g, "$1.")
                }
            },
            set: function(modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = Math.round(parseFloat(modifiedValue.replace(/[^\d\.]/g, "")));
                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0
                }
                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit('input', newValue)
            }
        }
    }
});

// Input for USD Doubles
Vue.component('moneda-usd-input', {
    props: ["value"],
    template: `
        <div>
            <input type="text" class="form-control text-right" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true"/>
        </div>`,
    data: function() {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function() {
                if (this.isInputActive) {
                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString()
                } else {
                    // User is not modifying now. Format display value for user interface
                    return "US$ " + this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\,\d+)?$)/g, "US$1.")
                }
            },
            set: function(modifiedValue) {
                // Recalculate value after ignoring "$" and "," in user input
                let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0
                }
                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit('input', newValue)
            }
        }
    }
});
