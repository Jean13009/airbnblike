
    $('#add-image').click(function(){
        // Récupérer le numéro des champs que l'on va créer
        const index = +$('#widgets_counter').val();
        //Récupérer le prototype des entrées
        const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);
        $('#annonce_images').append(tmpl);
        $('#widgets_counter').val(index + 1);

        // Gérer le bouton supprimer
        handleDeleteButtons();
    });

    function handleDeleteButtons() {
                $('button[data-action="delete"]').click(function(){
                            const target = this.dataset.target;
                            $(target).remove();
                });
    }

    function updateCounter() {
        const count = +$('#annonce_images div.form-group').length;
        $('#widgets_counter').val(count);
    }
    updateCounter();
    handleDeleteButtons();