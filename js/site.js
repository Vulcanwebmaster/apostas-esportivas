$('.carousel').carousel();

$('#form-login')
    .adminPage({
        module: 'entrar',
        controller: 'login',
        autoSearch: false,
    })
    .on("success", function (event, e) {
        if (e.result == 1) {
            window.location.href = e.url;
        }
    });