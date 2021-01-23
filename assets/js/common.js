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