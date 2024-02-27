// Selecione o elemento .erro-msg
var erroMsg = document.querySelector('.erro-msg');

// Verifique se o elemento existe antes de prosseguir
if (erroMsg) {
    setTimeout(function() {
        erroMsg.style.display = 'none';
    }, 3050);
}
