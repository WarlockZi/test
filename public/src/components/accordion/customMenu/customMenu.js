export default function showCustomMenu(e) {
  if (e.which == 3){
    e.target.append(render())
  }

  return false
}

function render() {
  let div = document.createElement('div')
  div.classList.add('update')
  div.innerText = 'Изменить'
  return div
}