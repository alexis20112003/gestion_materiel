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

function pageGestionMat() {
  changeMat(1);
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionMat",
    },
    success: function (response) {
      changeMat(1);
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
      $(".modal-content").html(response);
      $("#modal").modal("show");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageModifMat(id) {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageModifMat",
      id: id,
    },
    success: function (response) {
      $(".modal-content").html(response);
      $("#modal").modal("show");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageAddTypeMat() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageAddTypeMat",
    },
    success: function (response) {
      $(".modal-content").html(response);
      $("#modal").modal("show");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageAfficherMat(id) {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageAfficherMat",
      id: id,
    },
    success: function (response) {
      $(".modal-content").html(response);
      $("#modal").modal("show");
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
      nom: $("#NomMat").val(),
      description: $("#Description").val(),
      caution: $("#Caution").val(),
      type: $("#TypeMat").val(),
    },
    success: function (response) {
      console.log(response);
      changeMat(1);
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function modifMat() {
  console.log("aaa");
  $.ajax({
    url: "../controller/ControllerAddMat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modifMat",
      id: $("#id").val(),
      nom: $("#Nom").val(),
      description: $("#Description").val(),
      caution: $("#Caution").val(),
      enable: $("#Enable").val(),
      type: $("#TypeMat").val(),
    },
    success: function (response) {
      console.log(response);
      changeMat(1);
      $("#modal").modal("hide");
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
      changeMat(1);
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function deleteMat() {
  id_check_s = [];
  $("input.checkbox_check").each(function () {
    if ($(this).is(":checked")) {
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
    },
  });
}
function demandeMat() {
  id_check_s = [];
  $("input.checkbox_check").each(function () {
    if ($(this).is(":checked")) {
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
      date_debut: $("#dropper").attr("data-dd-opt-range-start"),
      date_fin: $("#dropper").attr("data-dd-opt-range-end"),
    },
    success: function () {
      pageDemande();
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

function pageMatDemande(date_debut, date_fin) {
  chargeMatDemande(1);
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageMatDemande",
      date_debut: date_debut,
      date_fin: date_fin,
    },
    success: function (response) {
      $("#result_demande").html(response);
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
      date_debut: $("#dropper").attr("data-dd-opt-range-start"),
      date_fin: $("#dropper").attr("data-dd-opt-range-end"),
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

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
