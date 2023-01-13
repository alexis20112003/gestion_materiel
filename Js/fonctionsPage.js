function pageGestionMateriel() {
  loadMateriel(1);
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionMateriel",
    },
    success: function (response) {
      loadMateriel(1);
      $("#page").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}
