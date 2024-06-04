import '../404/404.scss'
import './main.scss'
// import ViteProxyWebsocket from 'vite-proxy-websocket'
import {d, qs, ael} from '../constants';
import Search from "../components/search/search";
import {$} from "../common";
import  '../share/hoist/hoist';

document.addEventListener('DOMContentLoaded', async function () {
    new Search();
    const gumburger = document[qs]('.gamburger');
    if (gumburger) {
        gumburger[ael]('click', opentMobilePanel)
    }
    if ($('.modal-wrapper')){
        const {default:Modal} = await import("../components/Modal/modal")
        new Modal()
    }
    function opentMobilePanel(e) {
        const mm = e.target.closest('.utils')[qs]('.mobile-menu');
        mm.classList.toggle('show')
    }


    const category = document[qs]('.category')
    if (category) {
        const {default: Category} = await import('../Category/category')
        new Category()
    }
    const promotions = document[qs]('.promotions-index')
    if (promotions) {
        const {default: Promotions} = await import('../Promotions/Promotion')
        new Promotions;
    }

    const cart = document[qs]('.user-content .cart')
    if (cart) {
        const {default: Cart} = await import('../Cart/cart')
        new Cart()
    }
});


