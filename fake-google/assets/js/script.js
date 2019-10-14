$(document).ready(function() {
  $(".result").on("click", function () {
    console.log("I was clicked");

    var id = $(this).attr("data-linkId");
    var url = $(this).attr("href");
    // console.log(url);
    // console.log(id);

    increaseLinkClicks(id, url);

    // prevent default behavior - going to another page
    return false;
  })
});

function increaseLinkClicks(linkId, url) {
  // ajax, passing the link id, and redirect user after ajax call is done
  $.post("ajax/updateLinkCount.php", {linkId: linkId}).done(function(result) {
    if(result != "") {
      alert(result);
      return;
    }

    window.location.href = url;
  });
}