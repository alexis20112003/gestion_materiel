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
      type: type
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    }
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
    }
  });
}

function pageAddMat() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageAddMat",
    },
    success: function (response) {
      $("#page").html(response);
    },
    error: function () {
      alert("Error !");
    }
  });
}

function addMat() {
  $.ajax({
    url: "../controller/ControllerAddMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addMat",
    },
    success: function (response) {
    },
    error: function () {
      alert("Error !");
    }
  });
}


