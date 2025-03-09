function r(e,n){e.ondragenter=function(t){return t.preventDefault(),this.classList.toggle("hover"),!1},e.ondragleave=function(t){return t.preventDefault(),this.classList.toggle("hover"),!1},e.ondragover=function(t){return t.preventDefault(),!1},e.ondrop=function(t){t.preventDefault(),n(t.dataTransfer.files,t.target)}}export{r as default};
//# sourceMappingURL=dnd-BIsc27kd.js.map
