// DOM Events
window.addEventListener('load', function() {
    
    // Creamos el objeto foro de forma global
    const forum = new Forum();

    // 
    const inputForumId = document.getElementById('forumId');
    const forumId = (inputForumId) ? inputForumId.value : null;

    
    // Evento para cuando se envia el comentario
    document.getElementById('formCreateComment').addEventListener('submit', function(e){

        // Evita que el formulario ejecute el comprotamiento por defecto
        e.preventDefault();

        // Obtenemos los datos del formulario
        let bodyComment = document.getElementById('bodyComment').value;

        // Creamos el objeto para enviar los datos
        const formData = new FormData();
        formData.set('comment', bodyComment);
        formData.set('forum_id', forumId);

        // Enviamos los datos
        axios.post(url+'comments', formData,{
            headers: {'Content-Type': 'application/x-www-form-urlencoded' }
        })
        .then((result) => {
            window.location.reload();
            console.log(result.data);
        }).catch((err) => {

            console.log(err.response);
        });
    });

    // Se agrega el evento click de manera global debido a que los elementos son adicionados
    // dinamicamente
    document.addEventListener('click', function(e){

        const element = e.target;
        let parentDiv = null;

        // Preguntamos si elemento al que se le dio click fue el boton de eliminar
        if(element.classList.contains('btnDeleteComment') || element.classList.contains('fa-trash')){
            
            e.preventDefault();

            let formId = (element.tagName == 'A') ? element.getAttribute('href') : element.parentElement.getAttribute('href') ;
            parentDiv = (element.tagName == 'A') ? element.parentElement.parentElement : element.parentElement.parentElement.parentElement ;
            const form = document.getElementById(formId);
            
            axios.delete(`${url}${form.getAttribute('action')}`)
            .then(resp => {

                // 
                parentDiv.remove();

                console.log(resp.data);
            })
            .catch(err => {

            });
        }
    });
});