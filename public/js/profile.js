async function onSubmitForm(event) {

    // Stop form submition
    event.preventDefault();

    // Get form datas
    const form = event.currentTarget;
    const formData = new FormData(form);

    // Send datas to server
    const options = {
        method: 'POST',
        body: formData
    };
    const url = form.action;

    const response = await fetch(url, options);
    const data = await response.json();

    // Delete previous errors/success messages
    document.querySelectorAll('p.error').forEach(error => error.remove());

    // Actions based on data response (errors or success)
    if (data.errors) {
            const p = document.createElement('p');
            p.innerHTML = data.errors;
            p.classList.add('error');
            const input = document.getElementById('delete-password');
            input.after(p);
    } else if (data.success) {
        window.location.assign(deleteAccount.dataset.redirecthome);
    }
}

document.getElementById('delete-account-form').addEventListener('submit', onSubmitForm);

const deleteAccount = document.querySelector('[name=delete-account]');