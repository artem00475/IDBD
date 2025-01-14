
function sendRole(role) {
    fetch('role.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ROLE=${role}`
    })
    .then(response => response.text())
    .then(data => {
        console.log('Ответ сервера:', data);
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
    
}


function ready() {
    setTimeout(() => {
        location.reload(true);
    }, 100);
}

document.querySelectorAll('.bcw').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.bcw').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});


document.querySelector('.worker-btn').addEventListener('click', () => {
    sendRole('Master');
});

document.querySelector('.client-btn').addEventListener('click', () => {
    sendRole('Client');
});

document.querySelector('.ready-btn').addEventListener('click', () => {
    ready();
});