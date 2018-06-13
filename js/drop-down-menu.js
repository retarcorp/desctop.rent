var Menu = {
    init: function(){
        var showProfile = document.querySelector('.user-profile'),
            userProfileBtn = document.querySelector('.user-profile__button'),
            menu = this.getMenu(),
            userProfile = this.getUserProfile();


        
        showProfile.addEventListener('click', function(e){

            e.preventDefault;
            userProfileBtn.classList.toggle('active');
            //menu.classList.add('active');
            userProfile.classList.toggle('active');
        });

        this.menuList.init();
        this.closeMenu();
    },
    getMenu: function(){
        return document.querySelector('.drop-down-menu');
    }
    ,getUserProfile: function(){
        return document.querySelector('.user-profile');
    }
    ,closeMenu: function(){
        $(document).click(function(e){
            var elem = $(".drop-down-menu");
            if(e.target != elem[0] && !elem.has(e.target).length){ 
                elem.toggle('active');
            } 
        });
    }
    ,menuList: {
        init: function(){
            var btns = this.getAllItemsButton(),
                blocks = this.getAllBlocks();

            btns.forEach(function(item, i) {
                item.addEventListener('click', function(e) {
                    e.preventDefault;
                    this.clearButton();
                    item.classList.add('active');
                    this.clearBlocks();
                    blocks[i].classList.add('active');
                });
            });
        }
        ,getAllItemsButton: function(){
            return Array.prototype.slice.call(document.querySelectorAll('.drop-down-list__button'), 0);
        }
        ,getAllBlocks: function(){
            return Array.prototype.slice.call(document.querySelectorAll('.drop-down-list__block'),0);
        }
        ,clearButton: function(){
            var btns = this.getAllItemsButton();

            btns.forEach(function(item) {
                item.classList.remove('active');
            });
        },
        clearBlocks: function(){
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