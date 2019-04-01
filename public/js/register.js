window.addEventListener('load', function(){

    document.getElementById('formRegister').addEventListener('submit', function(e){

        e.preventDefault();

        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let password_confirmation = document.getElementById('password_confirmation').value;

        const auth = new Auth();

        const alertErrorDiv = document.getElementById('errorLoginMessage');
        
        // 
        alertErrorDiv.textContent = '';

        auth.register(name, email, password, password_confirmation)
        .then(resp => {

            alertErrorDiv.classList.add('d-none');

            window.location.href = url;
            console.log(resp.data);
        })
        .catch(err => {

            document.getElementById('errorLoginMessage').textContent = err.response.data.message;
            alertErrorDiv.classList.remove('d-none');
            console.log(err.response);
        });
    });
});