window.addEventListener('load', function(){


    document.getElementById('formLogin').addEventListener('submit', function(e){

        e.preventDefault();

        let username = document.getElementById('usernameLoginForm').value;
        let password = document.getElementById('passwordLoginForm').value;

        const auth = new Auth();

        const alertErrorDiv = document.getElementById('errorLoginMessage');
        
        // 
        alertErrorDiv.textContent = '';

        auth.login(username, password)
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