const Billing = {
    init: function(){
        var vm = new Vue({
            el: "#content",
            data: {
                billings: []
            },
            methods:{
                getBillings() {
                    axios.get('/api/user/transactions/')
                            .then(function(response){
                                vm.billings = response.data.data;
                            })
                            .catch(function(error){
                                console.log(error);
                            })
                }
                
            },
            created: function(){
                this.getBillings();
            }
        })
    }
}

$(Billing.init.bind(Billing))