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
            ,validatedPhone: ''
        }   
        ,methods:{
            onPhoneEntered: function(){
                Vm.changeLoader();
                if(this.validatedPhone){
                    Api.OnPhoneEntered.exec({phone: this.validatedPhone})
                        .then(function(result){
                            if(result.data.id){
                                return location.assign("/");
                            }
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
                    Vm.Messages.currentPhoneMessage = Vm.Messages.phoneValidationMessage;
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
            
            ,checkAuthUser: function(){
                axios.get('/api/auth/phone/')
                     .then(function(res){
                        console.log(res); 
                     });
               
            }
            ,checkPhoneNumber: function(){
                // Delete comments from this part of code to allow enter by phone numbers
                this.validatedPhone = this.phone;
                return;
                
                const input = document.getElementById('phone');
                
                let matches = this.phone.match(/^\+?\s*(7)\s*\(?(\d{3})\)?\s*(\d{7})$/);
                if( matches !== null){
                    let phone = matches[1] + matches[2] + matches[3];
                    input.classList.remove('authorization__phone-invalid');
                    input.classList.add('authorization__phone-valid');
                    this.validatedPhone = phone;
                }else{
                    input.classList.remove('authorization__phone-valid');
                    input.classList.add('authorization__phone-invalid');
                    this.validatedPhone = '';
                }
            }
            
            ,refreshPhoneMessage: function(){
                this.phoneIsInvalid=false;
                this.Messages.currentPhoneMessage = this.Messages.phoneValidationMessage
            }

            ,onSmsCodeEntered: function(){
                Vm.changeLoader();
                Api.ValidateSms.exec({phone: this.validatedPhone, code: this.smsCode})
                    .then(function(result){
                        if(result.isOk){
                            Vm.changeLoader();
                            return location.assign("/profile");
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
});