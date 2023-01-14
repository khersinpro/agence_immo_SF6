import './styles/app.scss';
require('bootstrap');
const $ = require('jquery');
require('select2');

$('select').select2();

const deletePictureMethod = (path, data, element) => {
    fetch(path, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body : JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        data.success ? element.closest('.form-img-box').remove() : alert('une erreur est survenue, veuillez réessayer plus tard.')
    })
    .catch(err => {
        console.log("error");
    })
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            const csrfToken = button.getAttribute("csrftoken");
            const path = button.getAttribute("href");
            csrfToken && path && deletePictureMethod(path, { '_token': csrfToken }, button);     
        })
    })
})



