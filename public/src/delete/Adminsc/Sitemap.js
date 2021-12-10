import {post} from '../../common'
$(function () {

$('#create_sitemap').on('click', function(){
   var data = {
     action: 'createSiteMap'     
   };
   debugger;
   
   post('',data);
   
});


});