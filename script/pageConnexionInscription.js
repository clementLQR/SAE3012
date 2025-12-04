    const buttons = document.querySelectorAll('.btn');
    const formulaires = document.querySelectorAll('.formulaire');

    buttons.forEach(button => {
        button.addEventListener('click', function() {

        formulaires.forEach(form => form.style.display = 'none');

        // Retirer la classe active de tous les boutons
        buttons.forEach(btn => btn.classList.remove('active'));

        // Afficher la section correspondante
        const targetId = button.getAttribute('data-target');
        document.getElementById(targetId).style.display = 'block';

        // Mettre le bouton en actif
        button.classList.add('active');
        });
    });

    // Afficher le premier texte par défaut
    buttons[0].click();