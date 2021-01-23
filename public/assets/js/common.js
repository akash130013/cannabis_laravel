  $(function() {
      $("#hamburger").on("click", function() {
          $(this).toggleClass("active");
          $('body').toggleClass("open-menu");
      });
  });

  $(function() {
      $(".dropmessage").hide();
      $(".info").on("click", function(event) {
          $(".dropmessage").show();
          event.stopPropagation();
      });
      $('body').on('click', function() {
          $(".dropmessage").hide();
      })
  });
  //   Change Input - password type Start
  function password(evt, evt1) {
      const checkbox = document.getElementById(evt);
      checkbox.addEventListener('change', (event) => {
          if (event.target.checked) {
              document.getElementById(evt1).setAttribute('type', "text");

          } else {
              document.getElementById(evt1).setAttribute('type', "password");
          }
      })
  }
  //   Change Input - password type Ends

  //   Switch Toggle State Start
  var switchStatus = false;
  $(".switchToggle input").on('change', function() {
      let parentSibling = $(this).parent().parent().parent();
      if ($(this).is(':checked')) {
          switchStatus = $(this).is(':checked');
          document.getElementById('toggleLabel').innerHTML = "Open";
          parentSibling.nextAll().children('input').addClass('active')
          console.log();

          //   $(this).parent().parent().parent().nextSiblings().Children('.timepicker')
          //   $(this).parent().parent().parent().siblings().Children('.timepicker').addClass('active');

      } else {
          switchStatus = $(this).is(':checked');
          document.getElementById('toggleLabel').innerHTML = "Closed";
          parentSibling.nextAll().children('input').removeClass('active')
              //   $(this).parent().parent().parent().siblings().Children('.timepicker').removeClass('active');
      }
  });
  //   Switch Toggle State Ends