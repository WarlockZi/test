import{q as s,a as t,b as e}from"./index-DSMixOGv.js";import{s as l}from"./shippableUnitsTable-DVM_Mulz.js";class r{constructor(){if(this.category=document[s](".category"),!this.category)return!1;this.mapShippableTables(),this.category[t]("click",this.handleClick.bind(this))}handleClick({target:a}){a.classList.contains(".blue-button")&&a.closest("[shipable-table]")[s](".unit-row")}mapShippableTables(){[...this.category[e](".shippable-table")].forEach(a=>{new l(a)})}}export{r as default};
