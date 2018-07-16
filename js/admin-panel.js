var Panel = {
    arrayData: []
    ,init: function(data){
        arrayData = data;
        this.btn = {
            addLicense: document.querySelector(".button_add-license"),
            tableRows: document.querySelectorAll('.table__row')
        };
        this.tabs = {
            addLicense: document.querySelector('.add-license')  
        };


        this.btn.addLicense.addEventListener('click', this.onAddLicense.bind(Panel));
        this.btn.tableRows.forEach(function(item){
            item.addEventListener('click', Panel.onTableRow.bind(Panel, item));
        });
        Panel.license.init();
    }
    ,license: {
        init: function(){
            this.btn = {
                close: document.querySelector('.button__license-close'),
                license: document.querySelector('.button__license'),
                rdp: document.querySelector('.button__rdp'),
                add: document.querySelector('.license__button'),
                edit: document.querySelector('.license__button-edit'),
                save: document.querySelector('.license__button-save'),
                remove: document.querySelector('.license__button-remove'),
                yes: document.querySelector('.ask-yes'),
                cancel: document.querySelector('.ask-no')
            };
            this.tabs = {
                license: document.querySelector('.license__data-container'),
                rdp: document.querySelector('.rdp__data-container'),
                editor: document.querySelector('.license__edit'),
                removeSelect: document.querySelector('.edit__agree')
            }
            this.fields = {
                login: document.getElementById('login'),
                password: document.getElementById('password'),
                uid: document.getElementById('uid'),
                ip: document.getElementById('ip'),
                content: document.getElementById('content'),
                valFrom: document.getElementById('validity__from'),
                valTo: document.getElementById('validity__to')
            };

            this.btn.close.addEventListener('click', this.onClose.bind(Panel.license));
            this.btn.license.addEventListener('click', this.onLicense.bind(Panel.license));
            this.btn.rdp.addEventListener('click', this.onRdp.bind(Panel.license));
            this.btn.add.addEventListener('click', this.onAdd.bind(Panel.license));
            this.btn.edit.addEventListener('click', this.onEdit.bind(Panel.license));
            this.btn.remove.addEventListener('click', this.onRemove.bind(Panel.license));
            this.btn.save.addEventListener('click', this.onSave.bind(Panel.license));
        }
        ,onClose: function(){
            event.preventDefault();
            Panel.tabs.addLicense.classList.remove('active');
        }
        ,onLicense: function(){
            event.preventDefault();
            this.btn.license.classList.add('active');
            this.btn.rdp.classList.remove('active');
            this.tabs.license.classList.add('active');
            this.tabs.rdp.classList.remove('active');
        }
        ,onRdp: function(){
            event.preventDefault();
            this.btn.rdp.classList.add('active');
            this.btn.license.classList.remove('active');
            this.tabs.rdp.classList.add('active');
            this.tabs.license.classList.remove('active');
        }
        ,lockFields: function(){
            this.fields.login.disabled = true;
            this.fields.password.disabled = true;
            this.fields.uid.disabled = true;
            this.fields.ip.disabled = true;
            this.fields.content.disabled = true;
            this.fields.valFrom.disabled = true;
            this.fields.valTo.disabled = true;
        }
        ,unlockFields: function(){
            this.fields.login.disabled = false;
            this.fields.password.disabled = false;
            // this.fields.uid.disabled = false;
            this.fields.ip.disabled = false;
            this.fields.content.disabled = false;
            this.fields.valFrom.disabled = false;
            this.fields.valTo.disabled = false;
        }
        ,onAdd: function(){
            Request.sendLicense(this.getDataForm());
        }
        ,onEdit: function(){
            event.preventDefault();
            this.btn.edit.classList.remove('active');
            this.tabs.editor.classList.add('active');
            this.unlockFields();
        }
        ,onRemove: function(){
            event.preventDefault();
            this.tabs.removeSelect.classList.add('active');
        }
        ,onSave: function(){
            event.preventDefault();
            this.tabs.removeSelect.classList.remove('active');
            this.tabs.editor.classList.remove('active');
            this.lockFields();
            this.btn.edit.classList.add('active');
        }
        ,getDataForm: function(){
            var formData = new FormData();
            formData.append("login", Panel.license.fields.login.value);
            formData.append("password", Panel.license.fields.password.value);
            formData.append("content", Panel.license.fields.content.value);
            formData.append("uid", Panel.license.fields.uid.value);
            formData.append("ip", Panel.license.fields.ip.value);
            formData.append("created_at", Panel.license.fields.valFrom.value);
            formData.append("due_to", Panel.license.fields.valTo.value);
            return formData
        }
    }
    ,onAddLicense: function(){
        event.preventDefault();
        Panel.resetFields();
        this.tabs.addLicense.classList.add('active');
        this.license.btn.add.classList.add('active');
        this.license.btn.edit.classList.remove('active');
        this.license.tabs.editor.classList.remove('active');
        Panel.license.unlockFields();
    }
    ,onTableRow: function(row){
        
        event.preventDefault();
        this.tabs.addLicense.classList.add('active');
        // this.license.tabs.editor.classList.add('active');
        this.license.btn.edit.classList.add('active');
        this.license.btn.add.classList.remove('active');
        this.license.tabs.editor.classList.remove('active');
        Panel.license.lockFields();
        Panel.getLicenseData(row);
    }
    ,getLicenseData: function(row){
        
        arrayData.forEach(function(item){
            if (row.firstChild.innerHTML == item.license.id){
                Panel.license.fields.login.value = item.license.login;
                Panel.license.fields.uid.value = item.license.uid;
                Panel.license.fields.ip.value = item.rdp.ip;
                Panel.license.fields.valFrom.value = item.rdp.created_at.split(' ')[0];
                Panel.license.fields.valTo.value = item.rdp.due_to.split(' ')[0];
            } 
        });
    }
    ,resetFields: function(){
        Panel.license.fields.login.value = '';
        Panel.license.fields.uid.value = '';
        Panel.license.fields.ip.value = '';
        Panel.license.fields.valFrom.value = '';
        Panel.license.fields.valTo.value = '';
    }
};

var Request = {
    sendLicense: function(data){
        axios.post('/api/license/create/', data)
        .then(function (response) {
            console.log(data);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    deleteLicense: function(id){
        axios.delete('/api/license/', id)
        .then(function (response) {
            console.log(data);
        })
        .catch(function (error) {
            console.log(error);
        });
    }
}