const menuToggle = document.querySelector('.menuToggle');
const navigation = document.querySelector('.navigation');

menuToggle.onclick = function() {
    navigation.classList.toggle('open')
}

const list = document.querySelectorAll('.list');
function activeLink() {
    list.forEach((item) =>
    item.classList.remove('active'));
    this.classList.add('active');

    var text = this.querySelector('.text').innerHTML;

    setTimeout(function() {
        let ltext = text.toLowerCase();
        window.location.href = ltext+".php";
    }, 300);
}
list.forEach((item) =>
item.addEventListener('click', activeLink))




