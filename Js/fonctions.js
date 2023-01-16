function update_user() {
  $.ajax({
    url: "../controller/connect.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "update_user",
      nom: $("#NomUpdate").val(),
      prenom: $("#PrenomUpdate").val(),
      mail: $("#EmailConnexion").val(),
      passwordConfirme: $("#PasswordConfirme").val(),
      password: $("#PasswordUpdate").val(),
    },
    success: function (response) {
      if (response["statut"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      if (response["statut"] == 0) {
        iziToast.error({
          title: "Caution",
          message: response["msg"],
        });
      }
    },
    error: function () {
      alert("Error !");
    },
  });
}
function loadUser(type) {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "loadUser",
      type: type,
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function addUser() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addUser",
      nom: $("#Nom").val(),
      prenom: $("#Prenom").val(),
      email: $("#Email").val(),
      promo: $("#Promo").val(),
      statut: $("#Statut").val(),
      site: $("#Site").val(),
    },
    success: function (response) {
      $("#modal").modal("hide");
      loadUser(4);
      console.log(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}
