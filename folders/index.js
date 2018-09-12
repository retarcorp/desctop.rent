var Folders = {
    init: function(){
        Folders.Popup.init();
        var menuItem = this.getSelectionList(),
            tabs = this.getTabsList();
        // console.log(menuItem.folders);
        menuItem.folders.addEventListener('click', this.onFolderTab.bind(Folders, menuItem, tabs));
        menuItem.access.addEventListener('click', this.onAccessTab.bind(Folders, menuItem, tabs));
        menuItem.scaners.addEventListener('click', this.onScanerTab.bind(Folders, menuItem, tabs));
    },
    getSelectionList: function(){
        return {
            folders: document.querySelector('.tab__folders'),
            access: document.querySelector('.tab__access'),
            scaners: document.querySelector('.tab__scaners')
        }
    },
    getTabsList: function(){
        return {
            folders: document.querySelector('.folders__tab'),
            access: document.querySelector('.access__tab'),
            scaners: document.querySelector('.scaners__tab')
        }
    },
    onFolderTab: function(menuItem, tabs){
        menuItem.folders.classList.add('active');
        menuItem.access.classList.remove('active');
        menuItem.scaners.classList.remove('active');
        
        tabs.folders.classList.add('active');
        tabs.access.classList.remove('active');
        tabs.scaners.classList.remove('active');
    },
    onAccessTab: function(menuItem, tabs){
        
        menuItem.access.classList.add('active');
        menuItem.folders.classList.remove('active');
        menuItem.scaners.classList.remove('active');
        
        tabs.access.classList.add('active');
        tabs.folders.classList.remove('active');
        tabs.scaners.classList.remove('active');
    },
    onScanerTab: function(menuItem, tabs){
        
        menuItem.scaners.classList.add('active');
        menuItem.folders.classList.remove('active');
        menuItem.access.classList.remove('active');
        
        tabs.scaners.classList.add('active');
        tabs.folders.classList.remove('active');
        tabs.access.classList.remove('active');
    },
    Popup: {
        init: function(){
            var btns = this.getButtonFoldersTabs(),
                popups = this.getAllPopups();
            
            btns.newFolder.addEventListener('click', this.onCreateFolder.bind(Folders.Popup, popups));
            btns.newScaner.addEventListener('click', this.onCreateScaner.bind(Folders.Popup, popups));
        },
        getButtonFoldersTabs: function(){
            return {
                newFolder: document.querySelector('#createFolder'),
                newScaner: document.querySelector('#createScaner')
            }
        },
        getAllPopups: function(){
            return {
                popCreateFolder: document.querySelector('#popupFolder'),
                popCreateScaner: document.querySelector('#popupScaner')
            }
        },
        onCreateFolder: function(popups){
            popups.popCreateFolder.classList.add('active');
            popups.popCreateFolder.addEventListener('click', this.onCloseTab);
        },
        onCreateScaner: function(popups){
            popups.popCreateScaner.classList.add('active');
            popups.popCreateScaner.addEventListener('click', this.onCloseTab);
        },
        onCloseTab: function(e){
            if(e.target.classList.contains('popup__btn-close')){
                e.currentTarget.classList.remove('active');
            }
        }
    }
}

window.onload = function(){
    Folders.init();
}