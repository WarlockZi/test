
window.onload = function () {


///////////////////////////    Login     /////////////////////
   var loginButton = document.querySelector("#login"); //превряем есть ли на стр логин
   if (loginButton) {
      loginButton.addEventListener("click", async function (e) {
         e.preventDefault();
         obj = {};
         var email = $('input[type = email]').val(),
         password = $('input[type= password]').val(),
         token = document.querySelector("[name = 'token']").value;
         obj.email = email;         
//         formData = new FormData(),
//         xhr = new XMLHttpRequest();
//         formData.append('email', email);
//         formData.append('password', password);
//         formData.append('token', token);
         debugger;
         var res = await fetch('/user/login', obj);
         debugger;

//         xhr.open('POST', '/user/login', true);
//         xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
//         xhr.send(formData);
//         xhr.onreadystatechange = function () {
//            if (xhr.readyState == 4 && xhr.status == 200) {
//               if (xhr.responseText !== 'true') {
         $('body').after(res);
         var overlay = document.querySelector(".overlay"),
         box = document.querySelector(".messageBox"),
         clos = document.querySelector(".messageClose");
         overlay.addEventListener("click", function () {
            overlay.style.display = 'none';
            box.style.display = 'none';
         });
         clos.addEventListener("click", function () {
            overlay.style.display = 'none';
            box.style.display = 'none';
         });
//               }
//            }
//            if (xhr.responseText !== 'true' && !box) {
//               window.location.href = "/user/cabinet";
//            };
//         };
      });
   }
   ;
};