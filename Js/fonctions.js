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
  $(document).ready(function () {
    changeMat(1);
  });
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

    },
  });
}


function addMat() {
  $.ajax({
    url: "../controller/ControllerAddMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addMat",
      nom: $("#Nom").val(),
      description: $("#Description").val(),
      caution: $("#Caution").val(),
      type: $("#TypeMat").val(),
    },
    success: function (response) {
      console.log(response);
    },
    error: function () {
      alert("Error !");
    }
  });
}

function addTypeMat() {
  $.ajax({
    url: "../controller/ControllerAddMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addTypeMat",
      nom: $("#Nom").val(),
      icon: $("#Icon").val(),
    },
    success: function (response) {
      location.reload();
      changeMat(1);
    },
    error: function () {
      alert("Error !");
    }
  });
}

function deleteMat() {
  id_check_s = [];
  $("input.checkbox_check").each(function () {
    if ($(this).is(':checked')) {
      id_check_s.push($(this).val());
    }
  });
  $.ajax({
    url: "../controller/ControllerAddMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "deleteMat",
      id: JSON.stringify(id_check_s),
    },
    success: function () {
      location.reload();
    },
    error: function () {
      alert("Error !");
    }
  });
}
function demandeMat() {
  id_check_s = [];
  $("input.checkbox_check").each(function () {
    if ($(this).is(':checked')) {
      id_check_s.push($(this).val());
    }
  });
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "demandeMat",
      id: JSON.stringify(id_check_s),
      date_debut: $("#Date_debut").val(),
      date_fin: $("#Date_fin").val(),
    },
    success: function () {
    },
    error: function () {
      alert("Error !");
    }
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

function pageDemande() {
  $(document).ready(function () {
    chargeMatDemande(1);
  });
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

function chargeMatDemande(type) {
  $.ajax({
    url: "../controller/ControllerTypeMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "gestionMatDemande",
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
