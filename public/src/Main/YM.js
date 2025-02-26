export default function YM(name, id = 7715905, goal = 'reachGoal') {
   if (window['ym'] === undefined) return
   id = 98155100
   id = 64313887
   const consts = {
      click_on_phone: 'click_on_phone',
      click_on_email: 'click_on_email',
      url_cart: 'url_cart',
      tovar_v_korzine: 'tovar_v_korzine',
      cart_submitted: 'oformit_zakaz_korzina',
      register_opened: 'register_opened',
      click_on_register: 'registraciya',
      click_on_login: 'click_on_login',
      form_submitted: 'form_submitted',
      to_messenger: 'to_messenger',
      to_social: 'to_social',
      click_search: 'poisk_tovarov',
   }
   window['ym'](id, goal, consts.name)

}