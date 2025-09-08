// public/js/form-validation.js
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let valid = true;
        // Exemple : vérifier que le champ nomClient n'est pas vide
        const nom = form.querySelector('[name$="[nomClient]"]');
        if (nom && nom.value.trim() === '') {
            valid = false;
            nom.classList.add('error');
            alert('Le nom du client est obligatoire.');
        }
        // Ajoute d'autres règles ici...
        if (!valid) e.preventDefault();
    });
});