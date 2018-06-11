const Api = {

    exec: async function(method, path, data){
        return new Promise(function(resolve, reject){
            const _resolve = (data) => resolve(Object.assign(data, {isOk: data.status == "OK"}));
            
            switch(method){
                case "GET":
                    _.get(path,data, (text) => _resolve(JSON.parse(text)));
                    break;
                case "POST":
                    _.post(path, data, (text) => _resolve(JSON.parse(text)));
            }
        })
    }

    ,EndPoint: class {
        constructor(method, path){
            this.method = method;
            this.path = path;
        }

        exec(data){
            return Api.exec(this.method, this.path, data)
        }
    }
}

Api.OnPhoneEntered = new Api.EndPoint("GET","/api/auth/phone/entered/");
Api.ValidateSms = new Api.EndPoint("GET","/api/auth/phone/sms/validate/");