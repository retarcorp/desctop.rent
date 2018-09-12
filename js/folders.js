Vue.component('tree-menu', { 
    template: '#tree-menu',
    props: [ 'nodes', 'label', 'depth' ],
    data() {
        return {
            showChildren: false
        }
    },
    computed: {
        iconClasses() {
            return {
                'fa-plus-square-o': !this.showChildren,
                'fa-minus-square-o': this.showChildren
            }
        },
        labelClasses() {
            return { 'has-children': this.nodes }
        },
        indent() {
            return { transform: `translate(${this.depth * 50}px)` }
        }
    },
    methods: {
        toggleChildren() {
           this.showChildren = !this.showChildren;
        }
    }
});


let vm = new Vue({
    
    el: '#fileManager',
    
    data: {
        isPopUpVisible: false,
        content: [],
        loaded: [],
        consts: {
            ROOT_NAME: "/",
            ROW_HEIGHT: 39
        }
    },
    
    methods: {
        
        getFormData: function(props){
            let fd = new FormData();
            for(let prop in props){
                fd.append(prop, props[prop]);
            }
            return fd;
        },
        
        togglePopUp: function(){
            this.isPopUpVisible = !this.isPopUpVisible;
        },
        
        openCreatePopUp: function(){
            this.togglePopUp();
        },
        
        openEditPopUp: function(){
            this.togglePopUp();
        },
        
        toggleFolderContent: function(event){
            let target = event.target;
            let name = '';
            let folder = null;
            
            while( target != event.currentTarget ){
                if( target.classList.contains('file') ){
                    this.openFile();
                    return;
                }
                
                if( target.classList.contains('button__folder-edit') ){
                    this.openEditPopUp();
                    return;
                }
                
                if( target.classList.contains('folder') ){
                    folder = folder === null ? target : folder;
                    let parentFolder = target.querySelector('.folder__name');
                    let subName = parentFolder !== null ? '/' + parentFolder.innerText : '';
                    name = subName + name;
                }
                
                target = target.parentNode;
            }
            
            this.openFolder(folder, name);
        },
        
        openFolder: function(folderElem, folderName){
            folder = this.findFolderObjectByTitle(folderName);
            console.log(folderName)
            if( !this.loaded.includes(folderName) ){
                this.addLoadedName(folderName);
                
                new Promise(function(resolve, reject){
                    vm.getFolderContent(folder, folderName, resolve);
                }).then(result => {
                    this.changeFolderHeight(folderElem)
                }).catch(err => console.warn(err));
                
            }else{
                this.changeFolderHeight(folderElem)
            }
            
            folderElem.classList.toggle('active');
        },
        
        changeFolderHeight: function(folderElem){
            let subfolder = folderElem.querySelector('.folder__subfolders');
            let realHeight = parseInt(getComputedStyle(subfolder).height);
            let heightForVisibility = subfolder.children.length * this.consts.ROW_HEIGHT + "px";
            let height = realHeight ? 0 : heightForVisibility;
            subfolder.style.height = height;
        },
        
        addLoadedName: function(name){
            this.loaded.push(name);
        },
        
        findFolderObjectByTitle: function(title){
            let subTitles = title.split('/').splice(1);
            let folder = this.content;
            
            subTitles.forEach( name => {
                for(let elem of folder){
                    if(elem.title == name){
                        folder = elem.subfolders;
                        break;
                    }
                }
            });
            
            return folder;
        },
        
        getFolderContent: function(folder, name, cb){
            axios.get(`/api/filemanager/folder/content/?folder=${name}`)
                .then(function(res){
                    vm.handleFolderContentResult(res.data, folder, cb);
                })
                .catch(function (error) {
                    console.warn(error);
                });
        },
        
        handleFolderContentResult: function(res, folder, cb){
            if(res.status != "OK"){
                throw new Error(res.message);
            }
            res.data.forEach( e => folder.push(e));
            if( cb ){
                cb();
            }
            console.log(this.content);
        },
        
        createFolder: function(parentFolder, newName){
            let data =this.getFormData({
                parentFolder: parentFolder, 
                name: newName
            });
            axios.post('/api/filemanager/folder/create/', data)
                .then();
        },
        
        openFile: function(fileName){
            
        }
    },
    
    created: function(){
        this.getFolderContent(this.content, this.consts.ROOT_NAME);
    }
    
});