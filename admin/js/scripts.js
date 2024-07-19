// summernote script
$("#summernote").summernote({
  //   placeholder: "Hello Bootstrap 4",
  tabsize: 5,
  height: 300,
});
// end summernote script

//modal page select photo
$(document).ready(function () {
  var user_href;
  var user_href_splitted;
  var user_id;
  var image_src;
  var image_href_splitted;
  var image_name;
  var photo_id;

  //click event on modal picture
  //target the picture class
  $(".modal_thumbnails").click(function () {
    //when click on image set the button disabled=false
    $("#set_user_image").prop("disabled", false);

    //target the delete button id to take the user id that inside the href
    user_href = $("#user-id").prop("href");

    //split the href to take the id after (=)
    user_href_splitted = user_href.split("=");
    //take the id
    user_id = user_href_splitted[user_href_splitted.length - 1];

    //grap image
    image_src = $(this).prop("src");
    image_href_splitted = image_src.split("/");
    image_name = image_href_splitted[image_href_splitted.length - 1];

    //grap image id from data attribute to show the image in the modal page when select
    photo_id = $(this).attr("data");

    $.ajax({
      url: "includes/ajax_code.php",
      data: { photo_id: photo_id },
      type: "POST",
      success: function (data) {
        if (!data.error) {
          $("#modal_sidebar").html(data);
        }
      },
    });
  });

  //click event on button (apply selection) to show and update the new image in edit_user_page.php
  $("#set_user_image").click(function () {
    $.ajax({
      url: "includes/ajax_code.php",
      data: { image_name: image_name, user_id: user_id },
      type: "POST",
      success: function (data) {
        if (!data.error) {
          // location.reload();

          //change the picture in edit_user_page.php
          $(".user_image_box a img").prop("src", data);
        }
      },
    });
  });
});

// edit photo page sidebar dropdown
$(document).ready(function () {
  //target the sidebar header
  $(".info-box-header").click(function () {
    //slideToggle() to show and disappear the card and target inside class
    $(".inside").slideToggle("fast");

    //change the row side when click
    $("#toggle").toggleClass(
      "glyphicon-menu-down glyphicon , glyphicon-menu-up glyphicon"
    );
  });
});

// confirm delete function
$(document).ready(function () {
  //target the delete link
  $(".delete_link").click(function () {
    return confirm("are you sure tou want to delete this");
  });
});
