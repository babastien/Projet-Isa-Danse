async function onSubmitForm(event) {

    // Stopper la soumission du formulaire
    event.preventDefault();

    // Récupérer les données du formulaire
    const form = event.currentTarget;
    const formData = new FormData(form);

    // Envoi des données au serveur
    const options = {
        method: 'POST',
        body: formData
    };
    const url = form.action;

    const response = await fetch(url, options);
    const data = await response.json();

    // On efface les précédents messages d'erreurs/succès
    document.querySelectorAll('p.error').forEach(error => error.remove());

    // Traitement des erreurs
    if(data.errors) {
            const p = document.createElement('p');
            p.innerHTML = data.errors;
            p.classList.add('error');
            const input = document.getElementById('delete-password');
            input.after(p);
    } else if(data.success) {
        window.location.assign(deleteAccount.dataset.redirecthome);
    }
}

document.getElementById('delete-account-form').addEventListener('submit', onSubmitForm);
const deleteAccount = document.querySelector('[name=delete-account]');