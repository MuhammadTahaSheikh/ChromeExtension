
  // $("#myForm").submit(function (event) {
  //   event.preventDefault(); // Prevent default form submission
  //   console.log("test");
  //   var form = $(this);
  //   var url = form.attr("action"); // URL of the PHP script that will handle the form data
  //   var data_user = {
  //     Client_id: $("#client_id").val(),
  //     //add other properties similarly
  //   };

  //   $.ajax({
  //     type: "POST",
  //     url: "http://localhost/360db/validate_clientid.php",
  //     dataType: "html",
  //     data: data_user,
  //     async: false,
  //     success: function (response) {
  //     //  global = response;
  //       console.log(response); // Log the response from the PHP script
  //     },
  //     error: function (xhr, status, error) {
  //       console.log(xhr.responseText); // Log any errors
  //     },
  //   });
  //   if (global == 1) {
  //     // $.ajax({
  //     //   type: "POST",
  //     //   url: "http://localhost/360db/gettingCleintId/Entension/podio_ext.php",
  //     //   dataType: "html",
  //     //   data: data_user,
  //     //   async: false,
  //     //   success: function (response) {
  //     //   //  $("#result").html(response);
  //     //     console.log(response); // Log the response from the PHP script
  //     //   },
  //     //   error: function (xhr, status, error) {
  //     //     console.log(xhr.responseText); // Log any errors
  //     //   },
  //     // });
  //    console.log("Yes id is found")
  //   }
  //   if (global == 0) {
  //     console.log("No id is not found");
  //   }
  // });


  $(document).ready(function() {
    $('#myForm').submit(function(e) {
      e.preventDefault(); // prevent default form submission behavior
     
      // collect form data
      var formData = $(this).serialize();
    var data_user = {
        'Client_id': $("#client_id").val(),
         //add other properties similarly
      };
      var client_id= $("#client_id").val();
      localStorage.setItem("id", client_id);
      // Retrieve
      document.getElementById("client_id").innerHTML = localStorage.getItem("id");
      
      $.ajax({
        type: 'POST',
        url: 'http://localhost/Podio_extension(integrated%20with%20podio)/podio_ext.php',
        // data: formData,
        data: data_user,
        success: function(response) {
         
          console.log(response);
         

        },
        error: function(xhr, status, error) {
          // handle error response from server
          console.log(error);
        }
      });
      
    });
  }); 
  