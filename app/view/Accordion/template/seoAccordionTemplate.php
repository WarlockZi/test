<ul class=mtree>
    <li><a href="#">Africa</a>
        <ul>
            <li><a href="#">Algeria</a></li>
            <li><a href="#">Marocco</a></li>
            <li><a href="#">Libya</a></li>
            <li><a href="#">Somalia</a></li>
            <li><a href="#">Kenya</a></li>
            <li><a href="#">Mauritania</a></li>
            <li><a href="#">South Africa</a></li>
        </ul>
    </li>
    <li><a href="#">America</a>
        <ul>
            <li><a href="#">North-America</a>
                <ul>
                    <li><a href="#">Canada</a></li>
                    <li><a href="#">USA</a>
                        <ul>
                            <li><a href="#">New York</a></li>
                            <li><a href="#">California</a>
                                <ul>
                                    <li><a href="#">Los Angeles</a></li>
                                    <li><a href="#">San Diego</a></li>
                                    <li><a href="#">Sacramento</a></li>
                                    <li><a href="#">San Francisco</a></li>
                                    <li><a href="#">Bakersville</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Lousiana</a></li>
                            <li><a href="#">Texas</a></li>
                            <li><a href="#">Nevada</a></li>
                            <li><a href="#">Montana</a></li>
                            <li><a href="#">Virginia</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="#">Middle-America</a>
                <ul>
                    <li><a href="#">Mexico</a></li>
                    <li><a href="#">Honduras</a></li>
                    <li><a href="#">Guatemala</a></li>
                </ul>
            </li>
            <li><a href="#">South-America</a>
                <ul>
                    <li><a href="#">Brazil</a></li>
                    <li><a href="#">Argentina</a></li>
                    <li><a href="#">Uruguay</a></li>
                    <li><a href="#">Chile</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a href="#">Asia</a>
        <ul>
            <li><a href="#">China</a></li>
            <li><a href="#">India</a></li>
            <li><a href="#">Malaysia</a></li>
            <li><a href="#">Thailand</a></li>
            <li><a href="#">Vietnam</a></li>
            <li><a href="#">Singapore</a></li>
            <li><a href="#">Indonesia</a></li>
            <li><a href="#">Mongolia</a></li>
        </ul>
    </li>
    <li><a href="#">Europe</a>
        <ul>
            <li><a href="#">North</a>
                <ul>
                    <li><a href="#">Norway</a></li>
                    <li><a href="#">Sweden</a></li>
                    <li><a href="#">Finland</a></li>
                </ul>
            </li>
            <li><a href="#">East</a>
                <ul>
                    <li><a href="#">Romania</a></li>
                    <li><a href="#">Bulgaria</a></li>
                    <li><a href="#">Poland</a></li>
                </ul>
            </li>
            <li><a href="#">South</a>
                <ul>
                    <li><a href="#">Italy</a></li>
                    <li><a href="#">Greece</a></li>
                    <li><a href="#">Spain</a></li>
                </ul>
            </li>
            <li><a href="#">West</a>
                <ul>
                    <li><a href="#">France</a></li>
                    <li><a href="#">England</a></li>
                    <li><a href="#">Portugal</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a href="#">Oceania</a>
        <ul>
            <li><a href="#">Australia</a></li>
            <li><a href="#">New Zealand</a></li>
        </ul>
    </li>
    <li><a href="#">Arctica</a></li>
    <li><a href="#">Antarctica</a></li>
</ul>



<style>

    ul.mtree {
           opacity: 0;
       margin-left: 0;
       padding: 1.2em;
       ul {
           margin-left: 1em; // Set default indent level (or set 0)
       }

       li {
           list-style: none; // Lets remove default bullets for all elements
       }

       a {
           @extend %mtree-transition;
           display: block;
       }

       li.mtree-node {
       > a { font-weight: bold; }
       }

       li.mtree-open {}
       li.mtree-closed {}
       ul.mtree-level-1 {
       }
           ul.mtree-level-2 { }
           ul.mtree-level-3 { }

       li.mtree-active {

       }
       }

    %mtree-transition {
         -webkit-transition: all 300ms ease-out;
         -moz-transition: all 300ms ease-out;
         -ms-transition: all 300ms ease-out;
         -o-transition: all 300ms ease-out;
         transition: all 300ms ease-out;
     }


    /*// bubba skin*/
       ul.mtree.bubba {
           ul {margin-left:0;}
           ul li { font-size: .9em; }
           li.mtree-node > a:after {content: '›'; margin-left:.5em; font-weight: normal; }
           li.mtree-node > a { font-weight: bold; text-transform: upperCase;}
           > li {border-bottom: 1px solid #DDD;}
           > li:last-child {border-bottom: none;}
           li:last-child > a {border: none; }
           > li.mtree-open > a { background: #DDD; }
           li > a:hover { background: #DDD;}
           li.mtree-active > a { background: #FFC000; color: #FFF; }
           $indent: 1em;
           a { padding: 7px 0px 7px $indent; }
           li li > a { padding-left: $indent*2; }
           li li li > a { padding-left: $indent*3; }
           li li li li > a { padding-left: $indent*4; }
           li li li li li > a { padding-left: $indent*5; }
       }

    /*// skinny skin*/
       ul.mtree.skinny {
           li { font-size: .9em; }
           a { padding: 0px 18px; color: #555; }
           a:hover { text-decoration: underline; }
           li.mtree-node:before { float: left; margin-left: .5em; zoom: .8; margin-top: .1em; color: #777;}
           li.mtree-open:before { content: '-'; }
           li.mtree-closed:before { content: '+'; }
           ul > li:first-child { margin-top: .1em; }
           ul > li:last-child { margin-bottom: .3em; }
           ul a {color:#666;}
       }

    /*// transit skin*/
       ul.mtree.transit {
           background: #111;
           ul {margin-left: 0;}
           ul > li {font-size:.9em; }
           li.mtree-node {position:relative;}
           li.mtree-node > a:before { color:#CCC; font-weight:normal; position: absolute; right: 20px; }
           li.mtree-open > a:before { content: '-';}
           li.mtree-closed > a:before { content: '+'; }
           ul > li:first-child { margin-top: 1px; }
           li.mtree-open > a {background: #222; }
           li > a:hover, li.mtree-active > a {background: #333; color: #FFF; }
           li.mtree-node > ul > li:last-child { margin-bottom: .5em; padding-bottom: .5em; border-bottom: 1px solid #333;}
           li.mtree-node:last-child > ul > li:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none;}
           $indent: .8em;
           a { padding: 5px 0px 5px $indent; color: #CCC; }
           li li > a { padding-left: $indent*2; }
           li li li > a { padding-left: $indent*3; }
           li li li li > a { padding-left: $indent*4; }
           li li li li li > a { padding-left: $indent*5; }
       }

    /*// jet skin*/
       ul.mtree.jet {
           ul { margin-left: 0; }
           li { margin-bottom: 1px; }
           li:last-child { margin-bottom: 0px; }
           li:first-child { margin-top: 1px; }
           li.mtree-active a { background: #E3E3E3; }
           li.mtree-active li:last-child > a {border-radius: 0px 0px 3px 3px;}
           li.mtree-active > a { background: #008cba; color:#FFF; border-radius: 3px 3px 0px 0px;}
           li > a:hover { background: #FFC000; color: #FFF;}
           $indent: 1em;
           a { padding: 5px 0px 5px $indent; }
           li li > a { padding-left: $indent*2; }
           li li li > a { padding-left: $indent*3; }
           li li li li > a { padding-left: $indent*4; }
           li li li li li > a { padding-left: $indent*5; }
       }

    /*// nix skin / below just reverts to default list styles.*/
                  ul.mtree.nix {
                      background: none;
                      a {display: inline;}
                      ul { margin-left: 1em; }
                      ul > li { list-style-position: inside; }
                      li {list-style: disc;}
                  }



    /*// ** DEMO STUFF ***/
    /*// disregard this ...*/
       .mtree-demo {
           .mtree {
               background: #EEE;
               margin: 20px auto;
               max-width: 320px;
               border-radius: 3px;
           }
       }

    /*// Skin selector for demo*/
       .mtree-skin-selector {
           text-align: center;
           background: #EEE;
           padding: 10px 0 15px;
           li {
               display: inline-block;
               float: none;
           }
           button {
               padding: 5px 10px;
               margin-bottom: 1px;
               background: #BBB;
               &:hover {
                   background: #999;
               }
               &.active {
                   background: #999;
                   font-weight: bold;
               }
               &.csl.active {
                   background: #FFC000;
               }
           }
       }
</style>

<script>

   // mtree.js
   // Requires jquery.js and velocity.js (optional but recommended).
   // Copy the below function, add to your JS, and simply add a list <ul class=mtree> ... </ul>
   ;(function ($, window, document, undefined) {

      // Only apply if mtree list exists
      if($('ul.mtree').length) {


         // Settings
         var collapsed = true; // Start with collapsed menu (only level 1 items visible)
         var close_same_level = false; // Close elements on same level when opening new node.
         var duration = 400; // Animation duration should be tweaked according to easing.
         var listAnim = true; // Animate separate list items on open/close element (velocity.js only).
         var easing = 'easeOutQuart'; // Velocity.js only, defaults to 'swing' with jquery animation.


         // Set initial styles
         $('.mtree ul').css({'overflow':'hidden', 'height': (collapsed) ? 0 : 'auto', 'display': (collapsed) ? 'none' : 'block' });

         // Get node elements, and add classes for styling
         var node = $('.mtree li:has(ul)');
         node.each(function(index, val) {
            $(this).children(':first-child').css('cursor', 'pointer')
            $(this).addClass('mtree-node mtree-' + ((collapsed) ? 'closed' : 'open'));
            $(this).children('ul').addClass('mtree-level-' + ($(this).parentsUntil($('ul.mtree'), 'ul').length + 1));
         });

         // Set mtree-active class on list items for last opened element
         $('.mtree li > *:first-child').on('click.mtree-active', function(e){
            if($(this).parent().hasClass('mtree-closed')) {
               $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
               $(this).parent().addClass('mtree-active');
            } else if($(this).parent().hasClass('mtree-open')){
               $(this).parent().removeClass('mtree-active');
            } else {
               $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
               $(this).parent().toggleClass('mtree-active');
            }
         });

         // Set node click elements, preferably <a> but node links can be <span> also
         node.children(':first-child').on('click.mtree', function(e){

            // element vars
            var el = $(this).parent().children('ul').first();
            var isOpen = $(this).parent().hasClass('mtree-open');

            // close other elements on same level if opening
            if((close_same_level || $('.csl').hasClass('active')) && !isOpen) {
               var close_items = $(this).closest('ul').children('.mtree-open').not($(this).parent()).children('ul');

               // Velocity.js
               if($.Velocity) {
                  close_items.velocity({
                     height: 0
                  }, {
                     duration: duration,
                     easing: easing,
                     display: 'none',
                     delay: 100,
                     complete: function(){
                        setNodeClass($(this).parent(), true)
                     }
                  });

                  // jQuery fallback
               } else {
                  close_items.delay(100).slideToggle(duration, function(){
                     setNodeClass($(this).parent(), true);
                  });
               }
            }

            // force auto height of element so actual height can be extracted
            el.css({'height': 'auto'});

            // listAnim: animate child elements when opening
            if(!isOpen && $.Velocity && listAnim) el.find(' > li, li.mtree-open > ul > li').css({'opacity':0}).velocity('stop').velocity('list');

            // Velocity.js animate element
            if($.Velocity) {
               el.velocity('stop').velocity({
                  //translateZ: 0, // optional hardware-acceleration is automatic on mobile
                  height: isOpen ? [0, el.outerHeight()] : [el.outerHeight(), 0]
               },{
                  queue: false,
                  duration: duration,
                  easing: easing,
                  display: isOpen ? 'none' : 'block',
                  begin: setNodeClass($(this).parent(), isOpen),
                  complete: function(){
                     if(!isOpen) $(this).css('height', 'auto');
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

         // Function for updating node class
         function setNodeClass(el, isOpen) {
            if(isOpen) {
               el.removeClass('mtree-open').addClass('mtree-closed');
            } else {
               el.removeClass('mtree-closed').addClass('mtree-open');
            }
         }

         // List animation sequence
         if($.Velocity && listAnim) {
            $.Velocity.Sequences.list = function (element, options, index, size) {
               $.Velocity.animate(element, {
                  opacity: [1,0],
                  translateY: [0, -(index+1)]
               }, {
                  delay: index*(duration/size/2),
                  duration: duration,
                  easing: easing
               });
            };
         }

         // Fade in mtree after classes are added.
         // Useful if you have set collapsed = true or applied styles that change the structure so the menu doesn't jump between states after the function executes.
         if($('.mtree').css('opacity') == 0) {
            if($.Velocity) {
               $('.mtree').css('opacity', 1).children().css('opacity', 0).velocity('list');
            } else {
               $('.mtree').show(200);
            }
         }
      }
   }(jQuery, this, this.document));


   /* DEMO STUFF */
   $(document).ready(function() {
      var mtree = $('ul.mtree');

      // Skin selector for demo
      mtree.wrap('<div class=mtree-demo></div>');
      var skins = ['bubba','skinny','transit','jet','nix'];
      mtree.addClass(skins[0]);
      $('body').prepend('<div class="mtree-skin-selector"><ul class="button-group radius"></ul></div>');
      var s = $('.mtree-skin-selector');
      $.each(skins, function(index, val) {
         s.find('ul').append('<li><button class="small skin">' + val + '</button></li>');
      });
      s.find('ul').append('<li><button class="small csl active">Close Same Level</button></li>');
      s.find('button.skin').each(function(index){
         $(this).on('click.mtree-skin-selector', function(){
            s.find('button.skin.active').removeClass('active');
            $(this).addClass('active');
            mtree.removeClass(skins.join(' ')).addClass(skins[index]);
         });
      })
      s.find('button:first').addClass('active');
      s.find('.csl').on('click.mtree-close-same-level', function(){
         $(this).toggleClass('active');
      });
   });
</script>