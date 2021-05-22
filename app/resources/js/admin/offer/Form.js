import AppForm from '../app-components/Form/AppForm';

Vue.component('offer-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  '' ,
                descr:  '' ,
                price:  '' ,
                client:  '' ,
                master:  '' ,
                status:  '' ,
                location:  '' ,
                accepted:  '' ,
                finished:  '' ,
                
            }
        }
    }

});