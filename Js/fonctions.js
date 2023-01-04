function connect() {
  $.ajax({
    url: "../controller/connect.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "connect",
      mail: $("#EmailConnexion").val(),
      password: $("#PasswordConnexion").val(),
    },
    success: function (response) {
      if (response["status"] === "connected" && response["session"]) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
        window.location.href = "Main.php";
      }
      if (response["status"] != "connected" || !response["session"]) {
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

function changeMat(type) {
  $.ajax({
    url: "../controller/ControllerTypeMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "gestionMat",
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

function pageGestionMat() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionMat",
    },
    success: function (response) {
      $("#page").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageGestionProfile() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionProfile",
    },
    success: function (response) {
      $("#page").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function deconnexion() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "deconnexion",
    },
    success: function (response) {
      if (!response["session"]) {
        window.location.href = "Accueil.php";
      }
    },
    error: function () {
      alert("Error !");
    },
  });
}
