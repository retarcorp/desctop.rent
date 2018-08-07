_.core(function(){

    var Vm = new Vue({
        el: "#app"
        ,data: {
            Tabs:{
                phone: true
                ,sms: false
            }
            ,loader: false
            ,phone: ""
            ,phoneIsInvalid: false
            ,Messages:{
                phoneValidationMessage: "Номер телефона введен неверно. Проверьте, что он подходит под указаннный шаблон!"
                ,currentPhoneMessage: null
                ,smsCodeMessage: ""
            }
            ,smsCode: ""
            ,smsIsInvalid: false
        }   
        ,methods:{
            onPhoneEntered: function(){
                Vm.changeLoader();
                if(this.validatePhone(this.phone)){
                    Api.OnPhoneEntered.exec({phone: this.phone})
                        .then(function(result){
                            if(result.isOk){
                                Vm.Tabs.phone = false;
                                Vm.Tabs.sms = true;
                                Vm.changeLoader();
                                return;
                            }
                            Vm.changeLoader();
                            Vm.Messages.currentPhoneMessage = result.message;
                            this.phoneIsInvalid = true;
                        })                    
                }else{
                    Vm.changeLoader();
                    this.phoneIsInvalid = true;
                }
                
            }
            ,changeLoader: function(){
                var loader = document.querySelector('.loader');
                if(!Vm.loader){
                    Vm.loader = true;
                    loader.classList.remove('hidden');
                } else {
                    Vm.loader = false;
                    loader.classList.add('hidden');
                }
            }

            ,refreshPhoneMessage: function(){
                this.phoneIsInvalid=false;
                this.Messages.currentPhoneMessage = this.Messages.phoneValidationMessage
            }
            ,validatePhone: function(phone){
                return true;
                return /\+\d{8,14}/.test(phone);
            }

            ,onSmsCodeEntered: function(){
                Vm.changeLoader();
                Api.ValidateSms.exec({code: this.smsCode})
                    .then(function(result){
                        if(result.isOk){
                            Vm.changeLoader();
                            return location.assign("/");
                        }
                        Vm.changeLoader();
                        Vm.smsIsInvalid = true;
                        Vm.Messages.smsCodeMessage = result.message;
                    });
                
            }
            ,refreshSmsMessage: function(){
                this.smsIsInvalid = false;
            }
        }

        ,mounted: function(){
            
        }

    })
    //console.log(await Api.GetUsers.exec());
    //console.log(Vm);
});