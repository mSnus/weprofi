import AppForm from '../app-components/Form/AppForm';

Vue.component('moderator-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                username:  '' ,
                pass:  '' ,
                email:  '' ,
                name:  '' ,
                status:  '' ,
                
            }
        }
    }

});