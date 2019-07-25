

//const link = $(".site a");
//link.map(function(i){
//   $(link[i]).append("<p>Сделать неактивным</p>");
//}
//
//)
//
//let act = 1;

///////////////////////////////
//////// PRODUCTS /////////////
///////////////////////////////


$('.product.column').hover(
       function(){ 
//          $(this).wrap("<span class = 'edit' ></span>");
//          $(this).addClass('edit');
          
          $(this).find('a').click(function(event){
//             event.preventDefault();
          }); 
          
//          debugger;
          
       
       },
       
       
       function(){ 
          $(this).unwrap().unwrap();
       }
);



