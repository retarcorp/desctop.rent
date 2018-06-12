var Menu = {
    init: function(){
        var btn = document.querySelector('.user-profile__button'),
            menu = this.getMenuList(),
            userProfile = this.getUserProfile();

        btn.addEventListener('click', function(e) {
            e.preventDefault;
            menu.classList.toggle('active');
            userProfile.classList.toggle('active');
        });

        this.menuList.init();
    },
    getMenuList: function(){
        return document.querySelector('.drop-down-list');
    }
    ,getUserProfile: function(){
        return document.querySelector('.user-profile');
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