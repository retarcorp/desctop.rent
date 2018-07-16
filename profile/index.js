const Profile = {
    init: function(){

        var vm = new Vue({
            el: "#content"
            ,data:{
                saved: false
                ,profileData: ["","","","","",""]
                ,loader: false
                
            }
            ,methods:{
                onSave: function(){
                    vm.changeLoader();
                    vm.saved = false;
                    var serialized = this.serialize();
                    
                    Api.GetCompanyDataByInn
                        .exec({inn: $("#inn").val()})
                        .then(function(data){
                            if(!data.data.kpp){
                                vm.changeLoader();
                                return alert("Компания с таким ИНН не найдена! Проверьте введенные данные.");
                            }
                            
                            return Api.ChangeProfileData
                                .exec(serialized)
                                .then(function(result){
                                    console.log(result);
                                    if(result.status == "OK"){
                                        vm.changeLoader();
                                        vm.saved = true;
                                    } else {
                                        vm.changeLoader();
                                        alert(result.message);
                                    }
                                })
                                
                        })
                        
                    
                }
                ,changeLoader: function(){
                    var loader = document.querySelector('.loader');
                    if(!vm.loader){
                        vm.loader = true;
                        loader.classList.remove('hidden');
                    } else {
                        vm.loader = false;
                        loader.classList.add('hidden');
                    }
                }

                ,onInput: function(e){
                    vm.saved = false;
                }

                ,serialize: function(){
                    var data = {};
                    $("#content input").each(function(el){
                        
                        data[this.id] = this.value;
                    })
                    delete data.phone;
                    return data;
                }
                
                ,onInnChanged: function(e){
                    var val = e.target.value.trim();
                   
                    if(/^\d{10}$/.test(val)){
                        Api.GetCompanyDataByInn.exec({inn: val})
                            .then(function(data){
                                
                                if(!data.data.kpp){
                                    console.error("Error retrieving company data by INN!");
                                    return;
                                }
                                
                                data = data.data;
                                
                                
                                $("#field-0").val(data.name);
                                $("#field-1").val(data.region);
                                $("#field-3").val(data.kpp);
                                
                                // vm.profileData[0] = data.name;
                                // vm.profileData[1] = data.region;
                                // vm.profileData[3] = data.kpp;
                            })
                            .catch(function(e){console.error(e)})
                    }
                }
            }       
        }); 
        
        // TEST! rewrite on VUE
        
        
        var btnCompany = document.querySelector('.button__company'),
            btnAssociate = document.querySelector('.button__associate');
        var tabCompany = document.querySelector('.form__company'),
            tabAssociate = document.querySelector('.form__associate');
        // btnCompany.addEventListener('click', function(e){
        //     e.preventDefault();
        //     btnAssociate.classList.remove('active');
        //     btnCompany.classList.add('active');
        //     tabAssociate.classList.remove('active');
        //     tabCompany.classList.add('active');
        // });
        btnAssociate.addEventListener('click', function(e){
            e.preventDefault();
            btnAssociate.classList.add('active');
            btnCompany.classList.remove('active');
            tabAssociate.classList.add('active');
            tabCompany.classList.remove('active');
        });
        // function getCompanyData(){
        //     var data = {
        //         // form: $('.form__company').data('form'),
        //         inn: $('#inn').val(),       
        //         email: $('#email').val(),       
        //         phone: $('#phone').val(),    
        //         feature: 2,
        //         'field-0': $('#field-0').val(),       
        //         'field-1': $('#field-1').val(),       
        //         'field-2': $('#field-2').val(),       
        //         'field-3': $('#field-3').val(),       
        //         'field-4': $('#field-4').val(),       
        //         'field-5': $('#field-5').val()       
        //     };
            
        //     return data;
        // }
        function getAssociateData(){
            var data = {
                // form: $('.form__company').data('form'),
                inn: $('#innAssociate').val(),       
                email: $('#emailAssociate').val(),       
                phone: $('#phoneAssociate').val(),       
                feature: 1,
                'field-6': $('#field-6').val(),       
                'field-7': $('#field-7').val(),       
                'field-8': $('#field-8').val()    
            };
            
            return data;
        }
        
        // $('#companySend').click(function(e){
        //     console.log(getCompanyData());
        //     e.preventDefault();
        //     const data = getCompanyData();
        //     const params = new URLSearchParams();
        //     Object.keys(data).forEach(key => params.append(key, data[key]));
        //     axios.post('/api/profile/data/', params)
        //     .then(function(respones){
        //         //vm.changeLoader();
        //         console.log('Работает');
        //     })
        // });
        $('#associateSend').click(function(e){
            console.log(getAssociateData());
            e.preventDefault();
            const data = getAssociateData();
            const params = new URLSearchParams();
            Object.keys(data).forEach(key => params.append(key, data[key]));
            axios.post('/api/profile/data/', params)
            .then(function(respones){
                //vm.changeLoader();
                console.log('Работает');
            })
        });
        
        // end test code!
        
        this.vm = vm;
        $("#content input").on("input", vm.onInput)
        
    }

}
$(Profile.init.bind(Profile)) 