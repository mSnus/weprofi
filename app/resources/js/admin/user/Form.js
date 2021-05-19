import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                usertype:  '' ,
                name:  '' ,
                email:  '' ,
                email_verified_at:  '' ,
                password:  '' ,
                two_factor_secret:  '' ,
                two_factor_recovery_codes:  '' ,
                
            }
        }
    }

});