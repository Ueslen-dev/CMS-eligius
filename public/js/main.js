let modalTitle = document.querySelector('.modal-title');
let modalBody = document.querySelector('.modal-body');

function delAction(bt, title, body){
    document.querySelectorAll(`.${bt}`).forEach(element => {
        modalTitle.innerHTML = title;
        modalBody.innerHTML = body;
        element.addEventListener('click', () => {
            document.querySelector('#btConfirmDel').addEventListener('click', () => {
                window.location.href = element.getAttribute('href');
            });
            
        });
    });
}
delAction('btDelUser', 'Deletar usuário', 'Tem certeza que deseja deletar esse usuário?');
delAction('btDelPage', 'Deletar página', 'Tem certeza que deseja deletar essa página?');

