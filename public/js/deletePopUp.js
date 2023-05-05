// editUser / editPack / profile

const deleteButton = document.querySelector('.delete');
const popUpForm = document.querySelector('.pop-up');
const popUpBackground = document.querySelector('.pop-up-background');
const cancelButton = document.querySelector('.cancel');

deleteButton.addEventListener('click', () => {
    popUpForm.style.display = 'block';
    popUpBackground.style.display = 'block';
})

cancelButton.addEventListener('click', () => {
    popUpForm.style.display = 'none';
    popUpBackground.style.display = 'none';
})

popUpBackground.addEventListener('click', () => {
    popUpForm.style.display = 'none';
    popUpBackground.style.display = 'none';
})