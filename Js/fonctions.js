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

function loadMateriel(type) {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "gestionMateriel",
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
function changeUser(type) {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "gestionCompte",
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

function pageGestionCompte() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionCompte",
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

function addMateriel() {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addMateriel",
      nom: $("#Nom").val(),
      description: $("#Description").val(),
      caution: $("#Caution").val(),
      type: $("#typeMateriel").val(),
    },
    success: function (response) {
      console.log(response);
      loadMateriel(1);
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateMateriel() {
  console.log("aaa");
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateMateriel",
      id: $("#id").val(),
      nom: $("#Nom").val(),
      description: $("#Description").val(),
      caution: $("#Caution").val(),
      enable: $("#Enable").val(),
      type: $("#typeMateriel").val(),
    },
    success: function (response) {
      console.log(response);
      loadMateriel(1);
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
      console.log(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function addTypeMateriel() {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addTypeMateriel",
      nom: $("#Nom").val(),
      icon: $("#Icon").val(),
    },
    success: function (response) {
      loadMateriel(1);
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function deleteMateriel() {
  id_check_s = [];
  $("input.checkbox_check").each(function () {
    if ($(this).is(":checked")) {
      id_check_s.push($(this).val());
    }
  });
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "deleteMateriel",
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
      request: "insertDemandeMateriel",
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

function addUserModal() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "addUserModal",
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

function updateUserModal(id) {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateUserModal",
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

function ongletsMaterielDemande(date_debut, date_fin) {
  chargeMaterielDemande(1);
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "ongletsMaterielDemande",
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

function chargeMaterielDemande(type) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "materielDemande",
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

