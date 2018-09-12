let CURL = {
    
    init(){
        this.setSendEventHandler();
        this.Storage.fillInputs();
    },
    
    DOM: {
        form: document.getElementById('form'),
        send: document.getElementById('send'),
        res: document.getElementById('results'),
        
        pathElem: document.getElementById('path'),
        bodyElem: document.getElementById('body'),
        cookiesElem: document.getElementById('cookies'),
        methodElem: document.getElementById('method'),
        headersElem: document.getElementById('headers'),
        
        spinnerElem: document.getElementById('spinner'),
    },
    
    Keys: {
        PATH_KEY: 'path',
        METHOD_KEY: 'method',
        BODY_KEY: 'body',
        COOKIES_KEY: 'cookies',
        HEADERS_KEY: 'headers'
    },
    
    Spinner: {
        
        launch() {
            CURL.DOM.spinnerElem.classList.add('visible');
        },
        
        stop() {
            CURL.DOM.spinnerElem.classList.remove('visible');
        }
        
    },
    
    Api: {
        
        EXEC_FILE_PATH: 'exec.php',
        
        exec(path, method, body, cookies, headers, func) {
            CURL.Spinner.launch();
            
            let xhr = new XMLHttpRequest();
            let fd = new FormData();
            
            fd.append(CURL.Keys.PATH_KEY, path);
            fd.append(CURL.Keys.METHOD_KEY, method);
            fd.append(CURL.Keys.BODY_KEY, body);
            fd.append(CURL.Keys.COOKIES_KEY, cookies);
            fd.append(CURL.Keys.HEADERS_KEY, headers)
            
            xhr.open('POST', this.EXEC_FILE_PATH, true);
            xhr.addEventListener('load', () => {
                CURL.Spinner.stop();
                func(xhr.responseText);
            });
            xhr.send(fd);
        }
    },
    
    Storage: {
        
        save(path, method, body, cookies, headers) {
            localStorage.setItem(CURL.Keys.PATH_KEY, path);
            localStorage.setItem(CURL.Keys.METHOD_KEY, method);
            localStorage.setItem(CURL.Keys.BODY_KEY, body);
            localStorage.setItem(CURL.Keys.COOKIES_KEY, cookies);
            localStorage.setItem(CURL.Keys.HEADERS_KEY, headers);
        },
        
        fillInputs() {
            let path = localStorage.getItem(CURL.Keys.PATH_KEY);
            if(path){
                CURL.DOM.pathElem.value = path;
            }
            CURL.DOM.bodyElem.value = localStorage.getItem(CURL.Keys.BODY_KEY);
            CURL.DOM.cookiesElem.value = localStorage.getItem(CURL.Keys.COOKIES_KEY);
            CURL.DOM.methodElem.value = localStorage.getItem(CURL.Keys.METHOD_KEY);
            CURL.DOM.headersElem.value = localStorage.getItem(CURL.Keys.HEADERS_KEY);
        }
        
    },
    
    setSendEventHandler(){
        CURL.DOM.send.addEventListener('click', (e) => {
            e.preventDefault();
            
            let path = CURL.DOM.pathElem.value;
            let body = CURL.DOM.bodyElem.value;
            let cookies = CURL.DOM.cookiesElem.value;
            let method = CURL.DOM.methodElem.value;
            let headers = CURL.DOM.headersElem.value;
            
            CURL.Api.exec(path, method, body, cookies, headers, (data) => {
                CURL.DOM.res.innerText = data;
            });
            
            CURL.Storage.save(path, method, body, cookies, headers);
        });
    }
    
}

CURL.init();