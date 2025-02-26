import {getPhpSession, setCookie} from "@src/common.js";

export default async function setLocalStorageCartId() {
   const loc_storage_cart_id = 'ls_cart_id_' + getPhpSession()
   const ls_cart_id = localStorage.loc_storage_cart_id;
   if (!ls_cart_id) {
      localStorage.setItem('loc_storage_cart_id', loc_storage_cart_id);
   }else{
      const savedCartId  = localStorage.getItem('loc_storage_cart_id');
      setCookie('loc_storage_cart_id',
         savedCartId,
         3000,
         'd',
         '/',
         'vi-prod',
         false,
         false)
      setCookie('loc_storage_cart_id',
         savedCartId,
         3000,
         'd',
         '/',
         'vitexopt.ru',
         false,
         false)
   }
}