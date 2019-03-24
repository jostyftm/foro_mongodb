// DOM Events
window.addEventListener('load', function() {
    
    // Creamos el objeto foro de forma global
    const forum = new Forum();

    // 
    const forumId = document.getElementById('forumId').value;

    // Obtenemos todos los foros
    forum.getComments(forumId)
    .then(resp => {
        
        resp.data.map(function(forum, index){
            showForum(forum);
        })
    })
    .catch(err => {

    });

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
});