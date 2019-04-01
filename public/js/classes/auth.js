class Auth {
    constructor(){

    }

    login(email, password){

        return new Promise( (resolve, reject) => {

            const formData = new FormData();
            formData.set('email', email);
            formData.set('password', password);

            // 
            axios.post(`${url}auth/login`, formData,{
                headers: {'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then((resp) => {
                
                resolve(resp);
            }).catch((err) => {
                
                reject(err);
            });
        });
    }

    register(name, email, password, password_confirmation){

        return new Promise( (resolve, reject) => {

            const formData = new FormData();
            formData.set('name', name);
            formData.set('email', email);
            formData.set('password', password);
            formData.set('password_confirmation', password_confirmation);

            // 
            axios.post(`${url}auth/register`, formData,{
                headers: {'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then((resp) => {
                
                resolve(resp);
            }).catch((err) => {
                
                reject(err);
            });
        });
    }
}