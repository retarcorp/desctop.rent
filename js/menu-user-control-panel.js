var LeftMenu = {
    init: function(){
        this.links = {
            employees: document.querySelector(".item__employees"),
            folders: document.querySelector(".item__folders"),
            payments: document.querySelector(".item__payments"),
            data: document.querySelector(".item__data"),
            support: document.querySelector(".item__support"),
            services: document.querySelector(".item__services")
        };
        this.tabs = {
            employees: document.querySelector(".tab-employees"),
            folders: document.querySelector(".tab-folders"),
            payments: document.querySelector(".tab-payments"),
            data: document.querySelector(".tab-data"),
            support: document.querySelector(".tab-support"),
            services: document.querySelector(".tab-services")
        };


        this.links.employees.addEventListener('click', this.onEmployeesClick.bind(LeftMenu));
        this.links.folders.addEventListener('click', this.onFoldersClick.bind(LeftMenu));
        this.links.payments.addEventListener('click', this.onPaymentsClick.bind(LeftMenu));
        this.links.data.addEventListener('click', this.onDataClick.bind(LeftMenu));
        this.links.support.addEventListener('click', this.onSupportClick.bind(LeftMenu));
        this.links.services.addEventListener('click', this.onServicesClick.bind(LeftMenu));

        this.onAdaptiveMenu();
        
    }
    ,onEmployeesClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.employees.classList.add('active');
        this.links.employees.classList.add('active');
        
    }
    ,onFoldersClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.folders.classList.add('active');
        this.links.folders.classList.add('active');
        
    }
    ,onPaymentsClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.payments.classList.add('active');
        this.links.payments.classList.add('active');

    }
    ,onDataClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.data.classList.add('active');
        this.links.data.classList.add('active');

    }
    ,onSupportClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.support.classList.add('active');
        this.links.support.classList.add('active');
    }
    ,onServicesClick: function(e){
        e.preventDefault;
        this.removeClassActive(this.links);
        this.removeClassActive(this.tabs);
        this.tabs.services.classList.add('active');
        this.links.services.classList.add('active');

    }
    ,removeClassActive: function(obj){
        for(key in obj){
            obj[key].classList.remove('active');
        }
    }
    ,onAdaptiveMenu: function(){
        var btn = document.querySelector('.header__button-adaptive');
        var menu = document.querySelector('.left-menu');

        btn.addEventListener('click', function(e) {
            e.preventDefault;
            menu.classList.toggle('active');
        });
    }
};

$(LeftMenu.init)