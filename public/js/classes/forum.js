class Forum {
    constructor(){
    }

    setTitle(title){
        this.title = title;
    }

    getTitle(){
        return this.title;
    }

    setDescription(description){
        this.description = description;
    }

    getDescription(){
        return this.description;
    }

    getData(){
        return {
            title: this.title,
            description: this.description
        };
    }
    
    getAll(){
        return new Promise( (resolve, reject) => {

            axios.get(url+'forums')
            .then((result) => {
                
                console.log(result.data);
                resolve(result);
            }).catch((err) => {
                console.log(err.response);
                reject(err);
            });

        });
    }

    save(){
        
        return new Promise( (resolve, reject) => {

            const formData = new FormData();
            formData.set('title', this.getTitle());
            formData.set('description', this.getDescription());

            axios.post(url+'forums', formData,{
                headers: {'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then((result) => {
                
                resolve(result);
            }).catch((err) => {

                reject(err);
            });
        });
    }

    saveComment(forum_id, comment){
        
        return new Promise( (resolve, reject) => {

            const formData = new FormData();
            formData.set('comment', comment);
            formData.set('forum_id', forum_id);

            axios.post(url+`/${forum_id}/addComent`, formData,{
                headers: {'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then((result) => {
                
                resolve(result);
            }).catch((err) => {

                reject(err);
            });
        });
    }

    getComments(forum_id)
    {
        return new Promise( (resolve, reject) => {
            axios.get(url+`forums/${forum_id}/comments`)
            .then(resp => {
                resolve(resp);
            })
            .catch(err => {
                reject(err);
            });
        });
    }
}