export default class MobileMenu{
   constructor() {
      this.navExpand = [].slice.call(document.querySelectorAll('.nav-expand'))
      this.backLink = `<li class="nav-item">
	<a class="nav-link nav-back-link" href="javascript:;">
		Назад
	</a>
</li>`

      this.navExpand.forEach(item => {
         item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', this.backLink)
         item.querySelector('.nav-link').addEventListener('click', () => item.classList.add('active'))
         item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'))
      })

      this.ham = document.getElementById('ham')
      if (this.ham)
      this.ham.addEventListener('click', function () {
         document.body.classList.toggle('nav-is-toggled')
      })
   }
}
