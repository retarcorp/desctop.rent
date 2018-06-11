const Api = {

    exec: async function(method, path, data){
        return new Promise(function(resolve, reject){
            switch(method){
                case "GET":
                    _.get(path,data, (text) => resolve(JSON.parse(text)));
                    break;
                case "POST":
                    _.post(path, data, (text) => resolve(JSON.parse(text)));
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
Api.GetUsers = new Api.EndPoint("GET","/api/users/")