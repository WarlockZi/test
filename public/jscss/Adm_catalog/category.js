$(function () {
var url = '/adminsc/catalog';
// При закрытии окна выбора свойств
$('body').on('click', '.messageClose', function () {
debugger;
var close = document.querySelector('.messageClose'),
overlay = document.querySelector('.overlay'),
propIds = Array(),
box = document.querySelector('.messageBox')
;
var propEls = $('.prop-list>.prop-name');
var catId = $_GET('id');
for (var i = 0; i < propEls.length; i++) {
var checked = propEls[i].getElementsByTagName('input')[0].checked;
if (checked) {
propIds.push(propEls[i].id);
}
}

var data = {
action: 'addCatProps',
propIds: propIds,
catId: catId
}
post(url, data);
overlay.remove();
box.remove();
});
// Добавить свойство
$('.properties').on('click', '.add-prop', function () {
var catId = $_GET('id');
var propsCollection = $('.property'); //; 
var propIdsOnPage = {}; //.data('prop'); 
for (var i = 0; i < propsCollection.length; i++) {
propIdsOnPage[i] = propsCollection[i].getAttribute('data-prop');
}
var param = {
action: 'getCatProps',
catId: catId,
propIdsOnPage: propIdsOnPage
};
post(url, param).then(function (data) {
//         debugger;
if (data) {
var data = JSON.parse(data);
$('body').append(data.snippet);
}
});
});
function addProp(self, enter) {
var a = $(self).parent().find('.value'),
b = a[0],
a = $(b).clone();
$(a).text('');
// установка курсора в начало ред строки
var list = $('.val:first');
if (enter) {
$(self).parent().append(a);
}
else {
$(self).prev().append(a);
}
$(a).focus();
};



$('.category-update-btn').on('click',function(event){
   
   let id = $('#id').text(),
   name = $('#name').text(),
   alias = $('#alias').text(),
   title = $('#title').text(),
   keywords = $('#keywords').text(),
   description = $('#description').text(),
   core = $('#core').text(),
   text = $('#text').text(),
   props = $('.properties select option:selected'),
   prop = ''
   ;
 
   for(let val of props){
      if(val.value)
      prop+=val.value+',';
   }
   param = 'param='+JSON.stringify({
      
      'action':'update',
      'model':'category',
      'field':'id',
      'id':id,
      values:{
      'name':name,
      'alias':alias,
      'prop':prop,
      'title':title,
      'keywords':keywords,
      'description':description,
      'core':core,
      'text':text
      },
   });
//   debugger;

   
   $.ajax({
      url:'/adminsc/catalog',
      method:'POST',
      data:param,
      success:function(res){
   debugger;
         let d = res;
      },
      error:function(res){
   debugger;
         let d = res;
      },
      
   });
   
   
   
  
});

});
