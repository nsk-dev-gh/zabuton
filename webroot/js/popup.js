function popupImage() {
var popup = document.getElementById('js-popup');
if(!popup) return;

var blackBg = document.getElementById('js-black-bg');

var blackBg = document.getElementById('js-black-bg');
var closeBtn = document.getElementById('js-close-btn');
var showBtn = document.getElementById('js-show-popup');

closePopUp(blackBg);
closePopUp(closeBtn);
closePopUp(showBtn);
function closePopUp(elem) {
if(!elem) return;
    elem.addEventListener('click', function() {
        popup.classList.toggle('is-show');
        });
    }
}
popupImage();

$('#odaiImg').on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $("#preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});