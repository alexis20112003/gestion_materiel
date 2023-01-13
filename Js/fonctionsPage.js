function pageDemande() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageDemande",
    },
    success: function (response) {
      $("#page").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

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
