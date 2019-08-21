
window.onload = function () {


///////////////////////////    Login     /////////////////////
   var loginButton = document.querySelector("#login"); //превряем есть ли на стр логин
/// debugger;
   if (loginButton) {
      loginButton.addEventListener("click", function (e) {
         e.preventDefault();
         var email = $('input[type = email]').val(),
         password = $('input[type= password]').val(),
         token = document.querySelector("[name = 'token']").value,
         formData = new FormData(),
         xhr = new XMLHttpRequest();
         formData.append('email', email);
         formData.append('password', password);
         formData.append('token', token);
         xhr.open('POST', '/user/login', true);
         xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
         xhr.send(formData);
         xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                  debugger;
               if (xhr.responseText !== 'true') {
                  $('body').after(xhr.responseText);
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
               }
            }
            if (xhr.responseText !== 'true' && !box) {
               window.location.href = "/user/cabinet";
            };
         };
      });
   };
};