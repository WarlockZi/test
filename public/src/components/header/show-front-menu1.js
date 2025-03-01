import {$} from '../../common.js'

function init() {

   const ul = $('ul.mtree').first()
   if (!ul) return false

// Settings
   const collapsed = true; // Start with collapsed menu (only level 1 items visible)
   const close_same_level = false; // Close elements on same level when opening new node.
   const duration = 400; // Animation duration should be tweaked according to easing.
   const listAnim = true; // Animate separate list items on open/close element (velocity.js only).
   const easing = 'easeOutQuart'; // Velocity.js only, defaults to 'swing' with jquery animation.

   $('.mtree ul').css({
      'overflow': 'hidden',
      'height': (collapsed) ? 0 : 'auto',
      'display': (collapsed) ? 'none' : 'block'
   });

   const node = $('.mtree li:has(ul)');
   [].forEach.call(node,(function (index, val) {
      $(this).children(':first-child').css('cursor', 'pointer')
      $(this).addClass('mtree-node mtree-' + ((collapsed) ? 'closed' : 'open'));
      $(this).children('ul').addClass('mtree-level-' + ($(this).parentsUntil($('ul.mtree'), 'ul').length + 1));
   }));

// Set mtree-active class on list items for last opened element
   $('.mtree li > *:first-child').on('click.mtree-active', function (e) {
      if ($(this).parent().hasClass('mtree-closed')) {
         $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
         $(this).parent().addClass('mtree-active');
      } else if ($(this).parent().hasClass('mtree-open')) {
         $(this).parent().removeClass('mtree-active');
      } else {
         $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
         $(this).parent().toggleClass('mtree-active');
      }
   });

// Set node click elements, preferably <a> but node links can be <span> also
   node.children(':first-child').on('click.mtree', function (e) {

      // element vars
      var el = $(this).parent().children('ul').first();
      var isOpen = $(this).parent().hasClass('mtree-open');

      // close other elements on same level if opening
      if ((close_same_level || $('.csl').hasClass('active')) && !isOpen) {
         var close_items = $(this).closest('ul').children('.mtree-open').not($(this).parent()).children('ul');

         // Velocity.js
         if ($.Velocity) {
            close_items.velocity({
               height: 0
            }, {
               duration: duration,
               easing: easing,
               display: 'none',
               delay: 100,
               complete: function () {
                  setNodeClass($(this).parent(), true)
               }
            });

            // jQuery fallback
         } else {
            close_items.delay(100).slideToggle(duration, function () {
               setNodeClass($(this).parent(), true);
            });
         }
      }

      // force auto height of element so actual height can be extracted
      el.css({'height': 'auto'});

      // listAnim: animate child elements when opening
      if (!isOpen && $.Velocity && listAnim) el.find(' > li, li.mtree-open > ul > li').css({'opacity': 0}).velocity('stop').velocity('list');

      // Velocity.js animate element
      if ($.Velocity) {
         el.velocity('stop').velocity({
            //translateZ: 0, // optional hardware-acceleration is automatic on mobile
            height: isOpen ? [0, el.outerHeight()] : [el.outerHeight(), 0]
         }, {
            queue: false,
            duration: duration,
            easing: easing,
            display: isOpen ? 'none' : 'block',
            begin: setNodeClass($(this).parent(), isOpen),
            complete: function () {
               if (!isOpen) $(this).css('height', 'auto');
            }
         });

         // jQuery fallback animate element
      } else {
         setNodeClass($(this).parent(), isOpen);
         el.slideToggle(duration);
      }

      // We can't have nodes as links unfortunately
      e.preventDefault();
   });
}


// Function for updating node class
function setNodeClass(el, isOpen) {
   if (isOpen) {
      el.removeClass('mtree-open').addClass('mtree-closed');
   } else {
      el.removeClass('mtree-closed').addClass('mtree-open');
   }
}
