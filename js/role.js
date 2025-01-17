function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function sendRole(role) {
    fetch('/~s338923/isbd/controller/profile/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ROLE=${role}&action_type=profile_selection`
    })
        .then(response => response.text())
        .then(data => {
            console.log('Ответ сервера:', data);
        })
        .catch(error => {
            console.error('Ошибка:', error);
        })
        .finally(() => {
            if (getCookie('PROFILE_ID')) {
                location.href = '/~s338923/isbd/';
            } else {
                location.reload()
            }
        })
}

document.querySelectorAll('.bcw').forEach(button => {
    button.addEventListener('click', function () {
        document.querySelectorAll('.bcw').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
    });
});

const role = getCookie('ROLE')
console.log(role);
if (role === 'Client') {
    document.querySelector('.client-btn').classList.add('active');
} else if (role === 'Master') {
    document.querySelector('.worker-btn').classList.add('active');
}
document.querySelector('.worker-btn').addEventListener('click', () => {
    sendRole('Master');
});

document.querySelector('.client-btn').addEventListener('click', () => {
    sendRole('Client');
});