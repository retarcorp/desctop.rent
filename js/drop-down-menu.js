var Menu = {
    init: function(){
        // this.setMenuHeight();
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
    },
    getMenu: function(){
        return document.querySelector('.drop-down-menu');

    }
    ,getUserProfile: function(){
        return document.querySelector('.user-profile');
    }
    // setMenuHeight: function(){
    //     var menu = this.getMenu();
    //     var heightPage = document.body.scrollHeight;
    //     var clientHeight = document.body.clientHeight;

    //     if(clientHeight < heightPage){
    //         menu.style.height = heightPage - 90 + 'px';
    //     }


    //     window.onscroll = function() {
    //         var position = (window.pageYOffset || document.documentElement.scrollTop) + clientHeight;
    //         console.log(position);
    //         if(position < (heightPage - 30)){
    //             menu.style.height = heightPage - 60 + 'px';
    //         } else {
    //             menu.style.height = clientHeight - 90 + 'px';
    //         }
    //     }        
    // }
};


window.onload = function(){
    Menu.init();
};