$(function () {
    $('[data-toggle="popover"]').popover();
});

$(document)
    .ready(function () {

        $(".btn-copy").click(function () {
            $("#nome-copy").select();
            var divACopiar = document.querySelector("#nome-copy");
            var range = document.createRange();
            range.selectNode(divACopiar);
            window.getSelection().addRange(range);
            document.execCommand("copy");

        });
    });