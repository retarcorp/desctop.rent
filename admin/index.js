_.core(function(){

    var Vm = new Vue({
        name: 'test',
        el: "#tableSection"
        ,data: {
            data: [],
            btn : {
                close: document.querySelector('.button__license-close'),
                license: document.querySelector('.button__license'),
                rdp: document.querySelector('.button__rdp'),
                add: document.querySelector('.license__button'),
                edit: document.querySelector('.license__button-edit'),
                save: document.querySelector('.license__button-save'),
                remove: document.querySelector('.license__button-remove'),
                yes: document.querySelector('.ask-yes'),
                cancel: document.querySelector('.ask-no'),
                addLicense: document.querySelector(".button_add-license"),
                tableRows: document.querySelectorAll('.table__row')
            },
            tabs : {
                license: document.querySelector('.license__data-container'),
                rdp: document.querySelector('.rdp__data-container'),
                editor: document.querySelector('.license__edit'),
                removeSelect: document.querySelector('.edit__agree'),
                addLicense: document.querySelector('.add-license')  
            },
            fields : {
                login: document.getElementById('login'),
                password: document.getElementById('password'),
                uid: document.getElementById('uid'),
                ip: document.getElementById('ip'),
                content: document.getElementById('content'),
                valFrom: document.getElementById('validity__from'),
                valTo: document.getElementById('validity__to')
            },
            isActive: false
            ,licenseOpened: true
            ,rdpOpened: false
            ,licenseObject: {
                login: ""
                ,password: ""
                ,uid: "0"
            }
            ,rdpObject: {
                ip:""
                ,content: ""
                ,due_to: (new Date).toISOString().split("T")[0]
            }
            ,createMode: false
            ,editMode: false
            ,confirmDelete: false
            ,currentLicense: 0
        }
        ,methods:{
            getLicenses: async function (){
                return axios.get('/api/licenses/')
                .then(function (response) {
                    Vm.data = response.data.data;
                     
                    Vm.isReady = true;
                    console.log(Vm.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            onAddLicense: function(){
                event.preventDefault();
                this.isActive = true;
                this.createMode = true;
                this.editMode = false;
                
               
            },
            onLicenseClick: function(item){
                this.isActive = true;
                this.editMode = true;
                this.createMode = false;
                
                this.licenseObject = item.license
                this.rdpObject = item.rdp;
                this.currentLicense = item.license.id;
                
                // TODO get license object
            }
            
            ,tabsOpenRdp: function(){
                this.licenseOpened = false;
                this.rdpOpened = true;
            }
                
            ,tabsOpenLicense: function(){
                this.licenseOpened = true;
                this.rdpOpened = false;
            }
            
            ,onSubmitLicenseEdit: async function(){
                const data = {
                    login: this.licenseObject.login
                    ,password: this.licenseObject.password
                    ,uid: this.licenseObject.uid
                    ,rdpIp: this.rdpObject.ip
                    ,rdpDueTo: this.rdpObject.due_to
                    ,rdpContent: this.rdpObject.content
                    ,id: this.currentLicense
                };
                const result = await Api.UpdateLicense.exec(data);
                this.getLicenses();
                this.isActive = false;
            }
            
            ,onDeleteLicense: async function(){
                const result = await Api.DeleteLicense.exec({id: this.currentLicense});
                this.isActive = false;
                await this.getLicenses();
                
            }
            
            ,onCreateLicense: async function(){
                const data = {
                    login: this.licenseObject.login
                    ,password: this.licenseObject.password
                    ,uid: this.licenseObject.uid
                    ,rdpIp: this.rdpObject.ip
                    ,rdpDueTo: this.rdpObject.due_to
                    ,rdpContent: this.rdpObject.content
                };
                
                const result = await Api.CreateLicense.exec(data);
                await this.getLicenses();
                this.isActive = false;
                
            }
            
            
        }
        ,updated: function(){

        }
        ,created: function(){
            this.getLicenses();
        }

    })

});