export default {
    emits:['toggle-impressum'],
    methods:{
        showImpressum(){
            this.$emit('toggle-impressum');
        }
    },
    template: `
        <a href="#" @click="showImpressum">Impressum</a>
    `
}
