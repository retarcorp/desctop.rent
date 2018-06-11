_.core(async ()=>{

    const Vm = new Vue({
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
            async onPhoneEntered(){
                if(this.validatePhone(this.phone)){
                    const result = await Api.OnPhoneEntered.exec({phone: this.phone});
                    if(result.isOk){
                        this.Tabs.phone = false;
                        this.Tabs.sms = true;
                        return;
                    }
                    this.Messages.currentPhoneMessage = result.message;
                }
                this.phoneIsInvalid = true;
                
            }

            ,refreshPhoneMessage(){
                this.phoneIsInvalid=false;
                this.Messages.currentPhoneMessage = this.Messages.phoneValidationMessage
            }
            ,validatePhone(phone){
                return /\+\d{8,14}/.test(phone);
            }

            ,async onSmsCodeEntered(){
                const result = await Api.ValidateSms.exec({code: this.smsCode});
                if(result.isOk){
                    return location.assign("/");
                }
                this.smsIsInvalid = true;
                this.Messages.smsCodeMessage = result.message;
            }
            ,refreshSmsMessage(){
                this.smsIsInvalid = false;
            }
        }

        ,mounted(){
            
        }

    })
    //console.log(await Api.GetUsers.exec());

});