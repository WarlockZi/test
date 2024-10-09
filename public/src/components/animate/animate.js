import {$} from "../../common.js";
import './animate.scss';
import anime from "./anime.js";

$(document).ready(async () => {
   // const animateLr = $('.animate-lr')[0]
   // const animateRl = $('.animate-rl')[0]

   //gloves img
   anime({
      targets: ['.gloves','.boot-cover .banner__text'],
      translateX: [
         {value: 50, duration: 0},
         {value: 0, duration: 1500},
      ],
      opacity: [
         {value: 0, duration: 0},
         {value: 1, duration: 1500},
      ],
      easing: 'easeOutExpo',
      delay:anime.stagger(1500),
   })
   //gloves badge
   anime({
      targets: ['.boot-cover','.gloves .banner__text'],
      translateX: [
         {value: -150, delay: 0, duration: 0},
         {value: 0, delay: 500,duration: 1500},
      ],
      opacity: [
         {value: 0, delay: 0,duration: 0},
         {value: 1, delay: 500,duration: 1500},
      ],
      easing: 'easeOutExpo',
   })



   //cover img
   anime({
      targets: '.boot-cover',
      translateX: [
         {value: -50, duration: 0},
         {value: 0, duration: 1500},
      ],
      opacity: [
         {value: 0, duration: 0},
         {value: 1, duration: 1500},
      ],
      easing: 'easeOutExpo',
      delay: 1000,
   })
   //cover badge
   anime({
      targets: '.boot-cover .banner__text',
      translateX: [
         {value: 50, duration: 0},
         {value: 0, duration: 1500},
      ],
      opacity: [
         {value: 0, duration: 0},
         {value: 1, duration: 1500},
      ],
      delay:1500,
      easing: 'easeOutExpo',
   })
})