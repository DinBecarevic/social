console.log("main.js loaded")
const pomurska = document.getElementById('pomurska')
const podravska = document.getElementById('podravska')
const koroska = document.getElementById('koroska')
const savinjska = document.getElementById('savinjska')
const zasavska = document.getElementById('zasavska')
const posavska = document.getElementById('posavska')
const jugovzhodnaslo = document.getElementById('jugo-vzhodna-slo')
const primorskonotranjska = document.getElementById('primorsko-notranjska')
const goriska = document.getElementById('goriska')
const obalnokraska = document.getElementById('obalno-kraska')
const gorenjska = document.getElementById('gorenjska')
const osrednjeslovenska = document.getElementById('osrednje-slovenska')

const desc = document.getElementById("desc")
const form_login = document.getElementById("regi_form")

let regija = []
//-----------------------------------------------------
pomurska.addEventListener('click', function(){
    regija = 'Pomurska'
    sprememba_regije(regija)
})
podravska.addEventListener('click', function(){
    regija = 'Podravska'
    sprememba_regije(regija)
})
koroska.addEventListener('click', function(){
    regija = 'Koroska'
    sprememba_regije(regija)
})
savinjska.addEventListener('click', function(){
    regija = 'Savinjska'
    sprememba_regije(regija)
})
zasavska.addEventListener('click', function(){
    regija = 'Zasavska'
    sprememba_regije(regija)
})
posavska.addEventListener('click', function(){
    regija = 'Posavska'
    sprememba_regije(regija)
})
jugovzhodnaslo.addEventListener('click', function(){
    regija = 'Jugo-Vzhodna Slo'
    sprememba_regije(regija)
})
primorskonotranjska.addEventListener('click', function(){
    regija = 'Primorsko-Notranjska'
    sprememba_regije(regija)
})
goriska.addEventListener('click', function(){
    regija = 'Goriška'
    sprememba_regije(regija)
})
obalnokraska.addEventListener('click', function(){
    regija = 'Obalno-Kraška'
    sprememba_regije(regija)
})
gorenjska.addEventListener('click', function(){
    regija = 'Gorenjska'
    sprememba_regije(regija)
})
osrednjeslovenska.addEventListener('click', function(){
    regija = 'Osrednje-Slovenska'
    sprememba_regije(regija)
})

function sprememba_regije(ime) {
    console.log("sprememba regije")
    desc.innerHTML = ime;
    form_login.setAttribute('action', 'includes/' + ime + '/signup.inc.php');
}

//-----------Switchbox------------------------------------------
function switchbox() {
    var x = document.getElementById("register-box");
    var y = document.getElementById("login-box")
    if(x.style.display == "none") {
        x.style.display = "block";
        y.style.display = "none";
    }
    else {
        x.style.display = "none";
        y.style.display = "block";
    }
}
const pomurska_sijaj = document.getElementById('pomurska_sijaj')
function sijaj(name) {
    console.log("sijaj")
    pomurska_sijaj.style.visibility = "visible"
}
function sijajout(name) {
    console.log("sijaj out")
    pomurska_sijaj.style.visibility = "hidden"
}
//-----------------------------------------------------
var bx1 = document.getElementById("reg_box1");
var bx2 = document.getElementById("reg_box2");
var bx3 = document.getElementById("reg_box3");
var bx4 = document.getElementById("reg_box4");
var bx1_btn = document.getElementById("reg_box1_btn");
var bx2_btn = document.getElementById("register_sub_btn");
var bx_back = document.getElementById("final_sub_back_btn")

function RegSwitchBox() {
    console.log("RegSwitchBox")
    if (bx3.style.display == "block") {
        bx1.style.display = "none";
        bx2.style.display = "none";
        bx3.style.display = "none";
        bx4.style.display = "block";
        return;
    }
    if (bx1.style.display == "block") {
        bx1_btn.style.display = "none";
        bx2.style.display = "block";
        bx3.style.display = "block";
        return;
    }
    console.log("RegSwitchBox2")
}
function nazaj() {
    console.log("nazaj")
    bx4.style.display = "none";
    bx1.style.display = "block";
    bx2.style.display = "block";
    bx3.style.display = "block";

    var psbar = document.getElementById("psbar");
    var status = psbar.value;

    psbar.setAttribute("value", 1);
    return;
}//-----------DateSwitch------------------------------------------
function dateswitch() {
    var input = document.getElementById("tempdate");
    if($("#tempdate").attr("id") == "tempdate") {
        console.log("dateswitch if")
        input.setAttribute('id', 'dateinput');
        input.setAttribute("type", "date");
    }
    return;
}
//-----------Progress------------------------------------------
function progress_bar() {
    var psbar = document.getElementById("psbar");
    var status = psbar.value;
    psbar.setAttribute("value", 1);
}
function progress_bar2() {
    var psbar = document.getElementById("psbar");
    var status = psbar.value;

    psbar.setAttribute("value", 2);
}
//-----------regsubmit()------------------------------------------
function regsubmit() {

    var form = document.getElementById("regi_form");
    var button = document.getElementById("final_sub_reg_btn");
    var p = document.getElementsByClassName("switchbox_link");
    setTimeout(function(){
        form.submit();
    },2000);

    var psbar = document.getElementById("psbar");
    var status = psbar.value;
    var loader1 = document.getElementById("reg_loader");
    var loader2 = document.getElementById("reg_loader2");
    psbar.setAttribute("value", 3);
    bx4.style.display = "none";
    bx1.style.display = "none";
    bx2.style.display = "none";
    bx3.style.display = "none";
    loader1.style.display = "block";
    loader2.style.display = "block";
    p[0].style.display = "none";
}
