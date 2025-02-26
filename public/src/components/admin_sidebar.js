import {$} from '../common'
let sidebar = $('.admin_sidebar')[0]
if (sidebar) {
  $('svg#burger').on('click', function () {
    let accordion = $('.admin_sidebar [accordion]')[0]
    accordion.classList.toggle('show')
  })
}

