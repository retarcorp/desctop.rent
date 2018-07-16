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
        }
        
    },
    
    computed: {
        isPasswordsCorrect() {
            return this.isPasswordsEqual && this.isPasswordsLengthCorrect && this.user.password.length > 0
        },
        isPasswordsEqual() {
            return this.user.password === this.user.passwordConfirm
        },
        isPasswordsLengthCorrect() {
            return this.user.password.length < 16
                   && this.user.passwordConfirm.length < 16
        }
    },
    
    methods: {
        onSetupPassword() {
            if(!this.isPasswordsCorrect) { return }
            let fd = new FormData();
            fd.append('password', this.user.password);
            
            // Api.SetupPassword.exec(fd)
            //     .then(res => {
            //         if(res.isOk) {
                        
            //         } else {
                        
            //         }
            //     })
        },
        
        onResetSetupPassword() {
            this.showModal = false;
            this.user = {
                password: '',
                passwordConfirm: ''
            }
            this.ui = {
                response: 'Uncought response error',
                status: null
            }
        }
    },
    
    created() {
        document.getElementsByClassName('setup-password')[0].style.display = 'block';
        // document.addEventListener('click', e => {
        //     if(e.target.className !== 'setup-password__container' && e.target.className === 'setup-password') {
        //         this.onResetSetupPassword()
        //     }
        // })
    }
    
    
})