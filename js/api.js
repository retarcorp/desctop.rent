const Api = {

    exec: function(method, path, data){
        return new Promise(function(resolve, reject){
            const _resolve = function(data){
                data.isOk = data.status == "OK";
                return resolve(data);
            };
            
            switch(method){
                case "GET":
                    _.get(path,data, function(text){return _resolve(JSON.parse(text))});
                    break;
                case "POST":
                    _.post(path, data, function(text){return _resolve(JSON.parse(text))});
            }
        })
    }

    ,EndPoint: function(method, path) {
        this.method = method;
        this.path = path;      

        this.exec = function(data){
            return Api.exec(this.method, this.path, data)
        }
    }
}

Api.OnPhoneEntered = new Api.EndPoint("GET","/api/auth/phone/entered/");
Api.ValidateSms = new Api.EndPoint("GET","/api/auth/phone/sms/validate/");