_.core(function(){

    var Vm = new Vue({
        el: "#app"
        ,data: {
            Tabs:{
                phone: true
                ,sms: false
            }
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
                if(this.validatePhone(this.phone)){
                    Api.OnPhoneEntered.exec({phone: this.phone})
                        .then(function(result){
                            if(result.isOk){
                                this.Tabs.phone = false;
                                this.Tabs.sms = true;
                                return;
                            }
                            this.Messages.currentPhoneMessage = result.message;
                            
                        })                    
                }
                this.phoneIsInvalid = true;
                
            }

            ,refreshPhoneMessage: function(){
                this.phoneIsInvalid=false;
                this.Messages.currentPhoneMessage = this.Messages.phoneValidationMessage
            }
            ,validatePhone: function(phone){
                return /\+\d{8,14}/.test(phone);
            }

            ,onSmsCodeEntered: function(){
                Api.ValidateSms.exec({code: this.smsCode})
                    .then(function(result){
                        if(result.isOk){
                            return location.assign("/");
                        }
                        this.smsIsInvalid = true;
                        this.Messages.smsCodeMessage = result.message;
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