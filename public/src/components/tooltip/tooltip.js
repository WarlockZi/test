import './tooltip.scss'

export default function tooltips() {

  document.addEventListener('mouseenter', showTip, true)
  document.addEventListener('mouseleave', hideTip, true)


  function showTip({target}) {
// debugger
    // если у нас есть подсказка...
    if (!target.dataset||!target.dataset.tooltip) return;

    let tooltipHtml = target.dataset.tooltip
    // ...создадим элемент для подсказки
    let tooltipElem = document.createElement('div');
    tooltipElem.className = 'tooltip';
    tooltipElem.innerHTML = tooltipHtml;
    document.body.append(tooltipElem);

    // спозиционируем его сверху от аннотируемого элемента (top-center)
    let coords = target.getBoundingClientRect();

    let left = coords.left + (target.offsetWidth - tooltipElem.offsetWidth) / 2;
    if (left < 0) left = 0; // не заезжать за левый край окна

    let top = coords.top - tooltipElem.offsetHeight - 5;
    if (top < 0) { // если подсказка не помещается сверху, то отображать её снизу
      top = coords.top + target.offsetHeight + 5;
    }

    tooltipElem.style.left = left + 'px';
    tooltipElem.style.top = top + 'px';
  };

  function hideTip() {
    let tooltips = document.querySelectorAll('.tooltip')
    if (tooltips) {
      [].forEach.call(tooltips, (tip) => {
          tip.remove();
        }
      )
    }
  };
}
