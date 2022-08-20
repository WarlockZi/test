import {$,post} from '../../common'

export default function product() {
  let property = $(`[data-model='product'] [custom-select]`)
  if (property){
    [].map.call(property,function(prop){

      let  observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          let id = mutation.target.dataset.value
          post('/adminsc/product/setProperty',
            {id})

        });
      });

      observer.observe(
        prop,{attributes: true,}
      );

    })


    //
    // let  observer = new MutationObserver(function(mutations) {
    //   mutations.forEach(function(mutation) {
    //     console.dir(mutation); //объект с изменениями
    //   });
    // });
    //
    // observer.observe(
    //   property[0],
    //   {
    //     childList: true,
    //     attributes: true,
    //     subtree: true,
    //     characterData: true,
    //     attributeOldValue: true,
    //     characterDataOldValue: true,
    //     attributeFilter: true
    //   }
    // );


  }
}