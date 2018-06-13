var Menu = {
    init: function(){
        var showProfile = document.querySelector('.user-profile'),
            userProfileBtn = document.querySelector('.user-profile__button'),
            menu = this.getMenu(),
            userProfile = this.getUserProfile();

        showProfile.addEventListener('click', function(e) {
            $(document).click(function(e){
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
            e.preventDefault;
            userProfileBtn.classList.toggle('active');
            menu.classList.toggle('active');
            userProfile.classList.toggle('active');
        });
        this.menuList.init();
        this.setMenuHeight();
        
    },
    getMenu: function(){
        return document.querySelector('.drop-down-menu');

    }
    ,getUserProfile: function(){
        return document.querySelector('.user-profile');
    },
    setMenuHeight: function(){
        var menu = this.getMenu();

        window.onscroll = function() {
            var heightPage = document.body.scrollHeight;
            var clientHeight = document.body.clientHeight;
            var position = (window.pageYOffset || document.documentElement.scrollTop) + clientHeight;

            if(position <= (heightPage - 60)){
                menu.style.height = clientHeight - 60 + 'px';
            } else {
                menu.style.height = clientHeight - 90 + 'px';
            }
        }        
    }
    ,menuList: {
        init: function(){
            var btns = this.getAllItemsButton(),
                blocks = this.getAllBlocks();

            btns.forEach(function(item, i) {
                item.addEventListener('click', function(e) {
                    e.preventDefault;
                    Menu.menuList.clearButton();
                    item.classList.add('active');
                    Menu.menuList.clearBlocks();
                    blocks[i].classList.add('active');
                });
            });
        }
        ,getAllItemsButton: function(){
            return document.querySelectorAll('.drop-down-list__button');
        }
        ,getAllBlocks: function(){
            return document.querySelectorAll('.drop-down-list__block');
        }
        ,clearButton: function(){
            var btns = this.getAllItemsButton();
            btns.forEach(function(item){
                item.classList.remove('active');
            });
        }
        ,clearBlocks: function(){
            var blocks = this.getAllBlocks();

            blocks.forEach(function(item) {
                item.classList.remove('active');
            });
        }
    }
};


window.onload = function(){
    Menu.init();
};