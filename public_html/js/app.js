const modal = document.querySelector('.container-modal')
const root = document.querySelector('html');

/* Слушатель нажатия на изображения для открытия модального окна */
function onButtonClick (event){

    document.querySelector('.container-modal-img').src = event.target.dataset.href;

    let winH = root.clientHeight;
    let winW = root.clientWidth;

    modal.style.display = 'block';

    modal.style.top = (winH/2 - modal.clientHeight/2) + 'px';
    modal.style.left = (winW/2 - modal.clientWidth/2) + 'px';
}

/* назначение слушателей на все изображения тамбнейлов */
buttons = document.querySelectorAll('.button-thumb');
for (let button of buttons){
    button.addEventListener('click', onButtonClick);
}

/* Слушатель события клика закрытия модального окна */
document.querySelector('.container-modal-close')
    .addEventListener('click', (event) => modal.style.display = 'none');

