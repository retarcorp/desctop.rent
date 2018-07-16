var Menu = {
    init: function(){
        this.buttons = {
            notice: document.querySelector('.button__notice'),
            setting: document.querySelector('.button__info ')
        };
        this.tabs = {
            notice: document.querySelector('.block__notice'),
            setting: document.querySelector('.block__info')
        };

        // this.buttons.notice.addEventListener('click', this.onNotice.bind(Menu));
        // this.buttons.setting.addEventListener('click', this.onSetting.bind(Menu));
        var showProfile = document.querySelector('.user-profile'),
            userProfileBtn = document.querySelector('.user-profile__button'),
            menu = this.getMenu(),
            userProfile = this.getUserProfile();
        showProfile.addEventListener('click', function(e) {
            e.preventDefault;
            $(document).click(function(e){
                e.preventDefault;
                var btn = $('.user-profile');
                if(e.target != btn[0] && !btn.has(e.target).length){
                    e.preventDefault;
                    var elem = $(".drop-down-menu");

                    if(e.target != elem[0] && !elem.has(e.target).length){ 
                        userProfileBtn.classList.remove('active');
                        menu.classList.remove('active');
                        userProfile.classList.remove('active');
                    } else {
                        elem.addClass('active');
                    }
                }
            });
            userProfileBtn.classList.toggle('active');
            menu.classList.toggle('active');
            userProfile.classList.toggle('active');
        });       
    }
    ,removeClassActive: function(obj){
        for(key in obj){
            obj[key].classList.remove('active');
        }
    }
    ,onNotice: function(){
        this.buttons.setting.classList.remove('active');
        this.tabs.setting.classList.remove('active');
        this.buttons.notice.classList.toggle('active');
        this.tabs.notice.classList.toggle('active');
    }
    ,onSetting: function(){
        this.buttons.notice.classList.remove('active');
        this.tabs.notice.classList.remove('active');
        this.buttons.setting.classList.toggle('active');
        this.tabs.setting.classList.toggle('active');
    }
    ,getMenu: function(){
        return document.querySelector('.drop-down-menu');

    }
    ,getUserProfile: function(){
        return document.querySelector('.user-profile');
    }
};


window.onload = function(){
    Menu.init();
    // LeftMenu.init();
};