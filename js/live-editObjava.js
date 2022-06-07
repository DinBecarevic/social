// edit-objave live preview

$(document).ready(function () {

    $('.edit-objava-texarea').keyup(function (e) {
        var vsebina = $('.edit-objava-texarea').val();
        var vsebina2 = vsebina.replaceAll("\n", "<br>");
        document.querySelector('.comment-paragraph-edit').innerHTML = vsebina2;
    });
});