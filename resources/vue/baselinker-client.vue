<template>
<div>
    <p>Translation key <code>BASELINKER_CLIENT_EXAMPLE</code> from <code>baselinker-client/resources/lang/**/js.php</code>: {{$lang.BASELINKER_CLIENT_EXAMPLE}}</p>
    <button class="form-builder__send btn" @click="testDebug">Test console log for debug</button>
    <p>From config JS file: {{this.example_data}}</p>
    <p>Example function: {{this.exampleFromFunction}}</p>
    <p>
        <button class="form-builder__send btn" @click="testLoading">Test loading</button>
        <span v-if="isLoading">is loading...</span>
    </p>
</div>
</template>

<script>
import baselinkerClientMixin from '../js/mixins/baselinker-client'
import {consoleDebug} from '../js/modules/helpers'

let _uniqSectionId = 0;

export default {

    name: 'baselinker-client',

    mixins: [ baselinkerClientMixin ],

    props: {
        name: {
            type: String,
            default() {
                return `baselinker-client-${ _uniqSectionId++ }`
            }
        },

        default: Object,

        storeData: String,
    },


    computed: {
        baselinkerClient () {
            return this.$store.state.baselinkerClient [this.name]
        },

        isLoading() {
            return this.baselinkerClient && this.baselinkerClient.isLoading
        },
    },

    created() {

        let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {})

        this.$store.commit('baselinker-client/create', {
            name: this.name,
            data
        })
    },

    mounted() {

    },

    methods: {
        testDebug(){
            consoleDebug('message', ['data1'], ['data2'])
        },

        testLoading(){
            if ( this.isLoading) return;

            AWEMA.emit(`baselinker-client::${this.name}:before-test-loading`)

            this.$store.dispatch('baselinker-client/testLoading', {
                name: this.name
            }).then( data => {
                consoleDebug('data', data);
                this.$emit('success', data.data)
                this.$store.$set(this.name, this.$get(data, 'data', {}))
            })
        }
    },


    beforeDestroy() {

    }
}
</script>
