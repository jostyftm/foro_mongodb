window.addEventListener('load', function(){

    const formUpdate = document.getElementById('formUpdateForum');

    formUpdate.addEventListener('submit', function(e){

        e.preventDefault();

        let forumTitle = document.getElementById('forumTitle').value;
        let forumDescription = document.getElementById('forumDescription').value;
        let forumId = document.getElementById('forumId').value;
        let forumIsOpen = document.getElementById('forumIsOpen');

        // 
        const forum = new Forum();
        forum.setTitle(forumTitle);
        forum.setDescription(forumDescription);

        if(forumIsOpen.checked){
            forum.setIsOpen(true);
        }else{
            forum.setIsOpen(false);
        }

        // 
        forum.update(forumId)
        .then(resp => {
            window.location.href = `${url}forums/${forumId}`;
        })
        .catch(err => {
            
        });
    });
});