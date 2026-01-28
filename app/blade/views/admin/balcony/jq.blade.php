<script src="{{$data['js']}}jquery-3.6.0.min.js"></script>
<script src="{{$data['js']}}mosq-calc.js"></script>


<script>


   jQuery(document).ready(function () {

      $("form").prepend('<input type="hidden" name="capt" value="453457686796898745345gh355q5yh3" />');


      $(".main-banner__form button").click(function (e) {


         var checked = $(this).closest(".main-banner__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".main-banner__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".main-banner__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(".main-banner__form input[name='user-phone']").val());

         var capt = $.trim($(".main-banner__form input[name='capt']").val());

         if (phone.length != 16) {
            $(".main-banner__form input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(".main-banner__form input[name='user-phone']").removeClass('just-validate-error-field');
         }

         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".main-banner__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".window-decor-form__main:not(.modal-mosqit-order) button").click(function (e) {

         var checked = $(this).closest(".window-decor-form__main").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".window-decor-form__main").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".window-decor-form__main").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".window-decor-form__main").find("input[name='phone']").val());
         if (phone.length != 16) {
            $(this).closest(".window-decor-form__main").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".window-decor-form__main").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         var capt = $.trim($(this).closest(".window-decor-form__main").find("input[name='capt']").val());


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".window-decor-form__main").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".modal-mosqit-order button").click(function (e) {

         var checked = $(this).closest(".modal-mosqit-order").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".modal-mosqit-order").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".modal-mosqit-order").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".modal-mosqit-order").find("input[name='phone']").val());
         var order = $.trim($(this).closest(".modal-mosqit-order").find("input[name='order']").val());
         var price = $.trim($(this).closest(".modal-mosqit-order").find("input[name='price']").val());
         if (phone.length != 16) {
            $(this).closest(".modal-mosqit-order").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".modal-mosqit-order").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         var capt = $.trim($(this).closest(".modal-mosqit-order").find("input[name='capt']").val());

         if ((phone.length == 16) && (checked == 1)) {

            $.post('/ajax/sendMailMosqit.php', {
               action: "send",
               phone: phone,
               order: order,
               price: price,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".modal-mosqit-order").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".free-meas-form__form button").click(function (e) {

         var checked = $(this).closest(".free-meas-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".free-meas-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".free-meas-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".free-meas-form__form").find("input[name='phone']").val());
         var name = $.trim($(this).closest(".free-meas-form__form").find("input[name='name']").val());

         var capt = $.trim($(this).closest(".free-meas-form__form").find("input[name='capt']").val());


         if (phone.length != 16) {
            $(this).closest(".free-meas-form__form").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".free-meas-form__form").find("input[name='phone']").removeClass('just-validate-error-field');
         }


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMail.php', {action: "send", phone: phone, name: name, capt: capt}, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".free-meas-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".feedback-form__form button").click(function (e) {

         var checked = $(this).closest(".feedback-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".feedback-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".feedback-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".feedback-form__form").find("input[name='phone']").val());
         var name = $.trim($(this).closest(".feedback-form__form").find("input[name='name']").val());
         var message = $.trim($(this).closest(".feedback-form__form").find("textarea[name='message']").val());

         if (phone.length != 16) {
            $(this).closest(".feedback-form__form").find("input[name='phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".feedback-form__form").find("input[name='phone']").removeClass('just-validate-error-field');
         }

         var capt = $.trim($(this).closest(".feedback-form__form").find("input[name='capt']").val());


         if ((phone.length == 16) && (checked == 1)) {
            $.post('/ajax/sendMailDirector.php', {
               action: "send",
               phone: phone,
               name: name,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".feedback-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".write-key-person-form__form button").click(function (e) {

         var checked = $(this).closest(".write-key-person-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".write-key-person-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".write-key-person-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var capt = $.trim($(this).closest(".write-key-person-form__form").find("input[name='capt']").val());
         var phone = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-phone']").val());
         var name = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-name']").val());
         var message = $.trim($(this).closest(".write-key-person-form__form").find("textarea[name='user-message']").val());

         var email = $.trim($(this).closest(".write-key-person-form__form").find("input[name='user-email']").val());
         var owner = $.trim($(this).closest(".write-key-person-form__form").find("input[name='owner']").val());

         if ((phone.length != 16) && (checked == 1)) {
            $(this).closest(".write-key-person-form__form").find("input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".write-key-person-form__form").find("input[name='user-phone']").removeClass('just-validate-error-field');
         }


         if (phone.length == 16) {
            $.post('/ajax/sendMailPerson.php', {
               action: "send",
               phone: phone,
               name: name,
               email: email,
               owner: owner,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".write-key-person-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $(".reviews-form__form button").click(function (e) {

         var checked = $(this).closest(".reviews-form__form").find("input[type='checkbox']:checked").length;

         if (checked == 0) {
            $(this).closest(".reviews-form__form").find("input[type='checkbox']").addClass('error');
         } else {
            $(this).closest(".reviews-form__form").find("input[type='checkbox']").removeClass('error');
         }


         var phone = $.trim($(this).closest(".reviews-form__form").find("input[name='user-phone']").val());
         var name = $.trim($(this).closest(".reviews-form__form").find("input[name='user-name']").val());
         var email = $.trim($(this).closest(".reviews-form__form").find("input[name='user-email']").val());
         var doc = $.trim($(this).closest(".reviews-form__form").find("input[name='user-doc']").val());
         var message = $.trim($(this).closest(".reviews-form__form").find("textarea[name='user-message']").val());


         if (document.getElementById('star-1').checked) {
            var rating = 1;
         }

         if (document.getElementById('star-2').checked) {
            var rating = 2;
         }

         if (document.getElementById('star-3').checked) {
            var rating = 3;
         }

         if (document.getElementById('star-4').checked) {
            var rating = 4;
         }

         if (document.getElementById('star-5').checked) {
            var rating = 5;
         }

         if (phone.length < 6) {
            $(this).closest(".reviews-form__form").find("input[name='user-phone']").addClass('just-validate-error-field');
         } else {
            $(this).closest(".reviews-form__form").find("input[name='user-phone']").removeClass('just-validate-error-field');
         }

         var capt = $.trim($(this).closest(".reviews-form__form").find("input[name='capt']").val());


         if ((phone.length > 5) && (checked == 1)) {
            $.post('/ajax/sendMailReview.php', {
               action: "send",
               phone: phone,
               name: name,
               doc: doc,
               email: email,
               rating: rating,
               message: message,
               capt: capt,
            }, function (data) {
               $('.modal-bg').addClass('active');
               $('.dialog').addClass('active');
               $(".reviews-form__form").trigger('reset');
            }, 'html');
            e.preventDefault();
         }
         return false;
      });


      $('.modal-close').click(function () {
         $('.modal').removeClass('active');
         $(".modal-bg").removeClass('active');
      });

      $(document).mouseup(function (e) {
         var div = $(".modal");
         if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            $(".modal").removeClass('active');
            $(".modal-bg").removeClass('active');
         }
      });


      $(".js-arrow-next").removeClass("swiper-button-disabled");

      $(".profili-tabs .tabs-menu > span").click(function () {
         $(this).parent(".tabs-menu").children("span").removeClass('active');

         $(this).addClass('active');
         $(this).parent(".tabs-menu").parent(".profili-tabs").children(".tab").removeClass('active');
         $(".tab#tab-" + $(this).attr("data-id")).addClass('active');
         $(this).parent(".tabs-menu").parent(".profili-tabs").children(".tab.tab-" + $(this).attr("data-id")).addClass('active');

      });


      $(".win-prices-tab__wrap .win-prices-tab__item").click(function () {
         $(".win-prices-tab__wrap .win-prices-tab__item").removeClass('active');

         $(this).addClass('active');
         $(".win-prices__content .win-prices__item").removeClass('active');


         $(".win-prices__content .win-prices__item[data-tab-index=" + $(this).attr("data-tab-index") + "]").addClass('active');

      });


   });
</script>

