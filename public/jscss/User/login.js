

window.onload = function () {


///////////////////////////    Login     /////////////////////
//   var loginButton = ; //превряем есть ли на стр логин
//   if (loginButton) {
   document.querySelector("#login").addEventListener("click", async function (e) {
      e.preventDefault();
      var obj = {};
      obj.email = $('input[type = email]').val(),
      obj.pass = $('input[type= password]').val(),
      obj.token = document.querySelector("[name = 'token']").value;
      debugger;
//      let response = await fetch('/user/login', {
//         body: 'param=' + JSON.stringify(obj),
//         method: 'POST',
//         headers: {
//            "Content-Type": "application/x-www-form-urlencoded",
////            "Content-Type": "application/json;charset=utf-8",
//            "X-Requested-With": "XMLHttpRequest"
//         }})
//      .catch(function (error) {
//         console.log('Request failed', error);
//      });

      var b = {
         login: 'andrey',
         password: 'dh7dhhd27dh',
         cache: '7fc4y7fby4c378cfy4bc4g8y4f'};

      let response = await fetch('/user/login', {

         method: 'POST',
         body: JSON.stringify(obj),
         headers: new Headers({
            'Content-Type': 'application/json'
         }),

      })
      .catch(function (error) {
         console.log('Request failed', error);
      })
//      });

      debugger;
      let text = await response.json();

//      let response = await post('/user/login', 'dd');
//      
//      
//      req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//      req.setRequestHeader('Content-Type', 'application/json');
//      req.setRequestHeader("X-Requested-With", "XMLHttpRequest");

//         xhr.open('POST', '/user/login', true);
//         xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
//         xhr.send(formData);
//         xhr.onreadystatechange = function () {
//            if (xhr.readyState == 4 && xhr.status == 200) {
//               if (xhr.responseText !== 'true') {
//      $('body').after(res);
//      var overlay = document.querySelector(".overlay"),
//      box = document.querySelector(".messageBox"),
//      clos = document.querySelector(".messageClose");
//      overlay.addEventListener("click", function () {
//         overlay.style.display = 'none';
//         box.style.display = 'none';
//      });
//      clos.addEventListener("click", function () {
//         overlay.style.display = 'none';
//         box.style.display = 'none';
//      });
//               }
//            }
//            if (xhr.responseText !== 'true' && !box) {
//               window.location.href = "/user/cabinet";
//            };
//         };
   });
//   }
   ;
};