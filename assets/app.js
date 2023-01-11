import './styles/app.scss';
require('bootstrap');
const $ = require('jquery');
require('select2');

$('select').select2();

// const deleteMethod = ($path, $csrfToken) => {
//     return fet
// };

document.addEventListener('DOMContentLoaded', () => {
    console.log(document.querySelectorAll('.delete-button'));
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            console.log(button);
            const csrfToken = button.getAttribute("csrftoken");
            const path = button.getAttribute("href");
            csrfToken && path && fetch(path, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body : JSON.stringify({ '_token': csrfToken })
                })
            .then(res => {

            })
            .catch(err => {
                console.log(err);
            })
            
        })
    })
})



