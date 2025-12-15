    const buttons = document.querySelectorAll('.btn');
    const formulaires = document.querySelectorAll('.formulaire');

    buttons.forEach(button => {
        button.addEventListener('click', function() {

        formulaires.forEach(form => form.style.display = 'none');

        buttons.forEach(btn => btn.classList.remove('active'));

        const targetId = button.getAttribute('data-target');
        document.getElementById(targetId).style.display = 'block';

        button.classList.add('active');
        });
    });

    buttons[0].click();

    const form = document.getElementById('formInscription');
    const mdp = document.getElementById('nouveau_mdp');
    const confirmation = document.getElementById('confirmation_mdp');

    form.addEventListener('submit', function(e) {
        if (mdp.value !== confirmation.value) {
            e.preventDefault(); 
            console.log("Les mots de passe ne correspondent pas.");
            alert("Les mots de passe ne correspondent pas.");
        }
    });
