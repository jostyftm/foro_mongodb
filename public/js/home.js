// DOM Events
window.addEventListener('load', function(){
    
    // Creamos el objeto foro de forma global
    const forum = new Forum();

    // Obtenemos todos los foros
    forum.getAll()
    .then(resp => {
        
        resp.data.map(function(forum, index){
            showForum(forum);
        })
    })
    .catch(err => {

    });

    // Función que se encargar de renderizar los foros obtenidor por ajax
    showForum = function(forum){

        const forumListHome = document.getElementById('forumListHome');
        const element = document.createElement('a');

        let hasPoint = (forum.description.length >= 200) ? '...' : '';

        element.innerHTML = `
        <div class="forum d-flex d-flex align-items-center p-3">
            <div class="mr-4">
                <img src="http://via.placeholder.com/50" alt="..." class="rounded-circle">
            </div>
            <div class="forum_body mr-4">
                <a class="text-decoration-none text-dark" href="#">
                    <h5>${forum.title}</h5>
                </a>
                <div class="forum_body_description">
                    <p class="text-muted">${forum.description.substring(0, 200)}${hasPoint}</p>
                </div> 
            </div>
        </div>
        `;

        element.setAttribute('href', `forums/${forum._id.$oid}`);
        element.setAttribute('class', 'text-decoration-none');
        forumListHome.appendChild(element);
    }

    // Acción que se ejecuta cuando se envia el formulario para crear un foro
    document.getElementById('formCreateForum').addEventListener('submit', function(e){

        // 
        e.preventDefault();

        // Obtenemos los datos del forumario
        let title = document.getElementById('forumTitle').value;
        let description = document.getElementById('forumDescription').value;

        // Agregamos los datos recibidos por el formulario
        forum.setTitle(title);
        forum.setDescription(description);

        // Enviamos los datos al servidos
        forum.save()
        .then((result) => {
            
            $("#modalCreateForum").modal('hide');
        }).catch((err) => {
            
        });
        
    });
    
});