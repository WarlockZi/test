import {$} from "../common";

export default function navigate(str) {

   if (/\/adminsc\/settings/.test(str)
      || /\/adminsc\/right\/list/.test(str)
      || /\/adminsc\/post\/list/.test(str) ||
      /\/adminsc\/todo\/list/.test(str)) {
      // rights()
      $("[settings]").addClass('current')


   } else if (/\/auth\/profile/.test(str)) {
      // user()
   } else if (/\/adminsc\/crm/.test(str)) {
      $("[crm]").addClass('current')


   } else if (/\/adminsc\/planning/.test(str)) {
      $("[plan]").addClass('current')

   } else if (
      /\/adminsc\/category/.test(str) ||
      /\/adminsc\/product/.test(str)
   ) {
      $("[catalog]").addClass('current')

   } else if (
      /\/test/.test(str)
      || /\/opentest/.test(str)
      || /\/adminsc\/opentest/.test(str)
      || /\/adminsc\/test/.test(str)) {
      $("[test]").addClass('current')

   } else {
      $("[href='/adminsc']").addClass('current')
   }

}