import AppForm from '../app-components/Form/AppForm';

Vue.component('master-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                userid:  '' ,
                title:  '' ,
                descr:  '' ,
                status:  '' ,
                score:  '' ,
                
            }
        }
    }

});