
  $("#myForm").submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    var form = $(this);
    var url = form.attr("action"); // URL of the PHP script that will handle the form data
    var data_user = {
      Client_id: $("#client_id").val(),
      //add other properties similarly
    };

    $.ajax({
      type: "POST",
      url: "validate_clientid.php",
      dataType: "html",
      data: data_user,
      async: false,
      success: function (response) {
        global = response;
        console.log(response); // Log the response from the PHP script
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText); // Log any errors
      },
    });
    if (global == 1) {
      // $.ajax({
      //   type: "POST",
      //   url: "http://localhost/360db/gettingCleintId/Entension/podio_ext.php",
      //   dataType: "html",
      //   data: data_user,
      //   async: false,
      //   success: function (response) {
      //   //  $("#result").html(response);
      //     console.log(response); // Log the response from the PHP script
      //   },
      //   error: function (xhr, status, error) {
      //     console.log(xhr.responseText); // Log any errors
      //   },
      // });
     console.log("Yes id is found")
    }
    if (global == 0) {
      console.log("No id is not found");
    }
  });

