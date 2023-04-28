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
    document.querySelector('p.success')?.remove();

    // Traitement des erreurs
    if(data.errors) {
        for(const fieldName in data.errors) {
            const p = document.createElement('p');
            p.innerHTML = data.errors[fieldName];
            p.classList.add('error');
            const input = document.getElementById(fieldName);
            input.after(p);
        }
    } else if(data.success) {
        const p = document.createElement('p');
        p.innerHTML = data.success;
        p.classList.add('success');
        form.before(p);
        form.reset();
    }
}

document.getElementById('contact-form').addEventListener('submit', onSubmitForm);