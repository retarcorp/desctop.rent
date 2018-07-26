new Vue({
    el: '#control-panel',
    data: {
        showModal: false,
        user: {
            password: '',
            passwordConfirm: ''
        },
        ui: {
            response: 'Uncought response error',
            status: null
        },
        requestId: null,
        isStrongPassword: false,
        interval: null
        
    },
    
    computed: {
        isPasswordsCorrect() {
            return this.isPasswordsEqual && this.isPasswordsLengthCorrect && this.isStrongPassword
        },
        isPasswordsEqual() {
            return this.user.password === this.user.passwordConfirm
        },
        isPasswordsLengthCorrect() {
            return this.user.password.length <= 16
                   && this.user.password.length >= 8
        }
    },
    
    watch: {
        ['user.password']() {
            const arr = this.user.password.split('');
            let [upper, lower, number, symbol] = [0,0,0,0];
            arr.forEach(el => {
                if(el === el.toUpperCase() && !Number.isInteger(el) && (el.match(/['a-z']/i))) {
                    console.log(el, 'upp')
                    upper = 1;
                } else if(el === el.toLowerCase() && !Number.isInteger(el) && (el.match(/['a-z']/i))) {
                    console.log(el, 'low')
                    lower = 1;
                } else if(parseInt(el)) {
                    console.log(el, 'num')
                    number = 1;
                } else if(!(el.match(/[a-z]/i))) {
                    console.log(el, 'sym')
                    symbol = 1;
                }
            })
            if(this.user.password.length) {
                upper + lower + number + symbol >= 3 ? 
                this.isStrongPassword = true : 
                this.isStrongPassword = false
            }
        }
    },
    
    methods: {
        getPasswordStatus() {
            if(this.requestId !== null) {
                Api.GetPasswordStatus = new Api.EndPoint("GET", "/api/request/?id=" + this.requestId);
                Api.GetPasswordStatus.exec()
                    .then(res => {
                        if(res.isOk) {
                            if(res.data.status == '3' || res.data.status == '2') {
                                clearInterval(this.interval)
                            }
                            this.ui.response = res.data.message;
                            this.ui.status = res.data.status;
                            if(res.data.status == '0') {
                                this.ui.status = 1;
                            }
                        } else {
                            this.ui.status = 3;
                            this.ui.response = res.data.message
                        }
                    })
            }
        },
        
        onSetupPassword() {
            this.ui.status = 1;
            if(!this.isPasswordsCorrect) { return }
            let fd = new FormData();
            fd.append('password', this.user.password);
            
            Api.SetupPassword.exec({ 'password' : this.user.password})
                .then(res => {
                    if(res.isOk) {
                        this.ui.status = 1;
                        this.requestId = res.data.id;
                        this.setRequestUpdate();
                    } else {
                        this.ui.status = 3;
                        this.ui.response = res.data.message;
                    }
                })
        },
        
        onResetSetupPassword() {
            if(this.ui.status == 2) { location.reload() } 
            this.showModal = false;
            this.user = {
                password: '',
                passwordConfirm: ''
            }
            this.ui = {
                response: 'Uncought response error',
                status: null
            }
        },
        
        setRequestUpdate() {
            setTimeout(() => {
                this.interval = setInterval(() => {
                    this.getPasswordStatus()
                }, 5000)
            }, 10000)
        }
    },
    
    created() {
        document.getElementsByClassName('setup-password')[0].style.display = 'block';
        Api.GetRequestStatus.exec()
            .then(res => {
                if(res.isOk) {
                    this.ui.status = res.data.status;
                    if(res.data.status == '0') {
                        this.ui.status = 1;
                    }
                    this.requestId = res.data.id;
                    this.showModal = true;
                    this.interval = setInterval(() => {
                        this.getPasswordStatus()
                    }, 5000)
                } else {
                    this.ui.status = null;
                    this.showModal = false;
                }
            })
    }
    
    
})