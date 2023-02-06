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
      alert("Error 3");
    },
  });
}

function loadAllUser() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "loadAllUser",
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function loadDisabledUser() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "loadDisabledUser",
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
  statut = $("#Statut").val();
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
      if (response["reussite"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      $("#modal").modal("hide");
      loadUser(statut);
    },
    error: function () {
      alert("Error 1");
    },
  });
}

function updateUser(userId) {
  type = $("#typeUser").val();
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateUser",
      userId: userId,
      nom: $("#Nom").val(),
      prenom: $("#Prenom").val(),
      email: $("#Email").val(),
      enable: $("#enableUser").val(),
    },
    success: function (response) {
      if (response["statut"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      $("#modal").modal("hide");
      if ($("#ongletInactif").hasClass("active")) {
        loadDisabledUser();
      } else {
        loadUser(type);
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
      request: "loadMateriel",
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
function loadAllMateriel() {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "loadAllMateriel",
    },
    success: function (response) {
      $("#myTabContent").html(response);
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
      id_site: $("#id_site").val(),
    },
    success: function (response) {
      console.log(response);
      pageGestionMateriel();
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateMateriel() {
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
      pageGestionMateriel();
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
      pageGestionMateriel();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function chargeMaterielDemande(type, date_debut, date_fin) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "materielDemande",
      type: type,
      date_debut: date_debut,
      date_fin: date_fin,
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function ongletsMaterielDemande(date_debut, date_fin) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "ongletsMaterielDemande",
      date_debut: date_debut,
      date_fin: date_fin,
    },
    success: function (response) {
      $("#result_demande").html(response);
      let field = date_debut + ' // ' + date_fin;
      $("#dropper").val(field);
      chargeMaterielDemande(1, date_debut, date_fin);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function insertDemandeMateriel(date_debut, date_fin) {
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
      date_debut: date_debut,
      date_fin: date_fin,
    },
    success: function (response) {
      console.log(response);
      location.reload();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function refuseDemandeMateriel(id) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "refuseDemandeMateriel",
      id: id,
    },
    success: function () {
      pageNotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function acceptDemandeMateriel(id) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "acceptDemandeMateriel",
      id: id,
    },
    success: function () {
      pageNotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateDemandeGive(id) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateDemandeGive",
      id: id,
    },
    success: function () {
      pageNotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateDemandeRecover(id) {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateDemandeRecover",
      id: id,
    },
    success: function () {
      pageNotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function NotificationDemande() {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "NotificationDemande",
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function NotificationGive() {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "NotificationGive",
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function NotificationRecover() {
  $.ajax({
    url: "../controller/ControllerDemande.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "NotificationRecover",
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateImageProfile() {
  var my_files = $("#new_file").get(0).files;

  let formData = new FormData();

  let element = "new_file";

  formData.append(element, my_files[0]);

  $.ajax({
    url: "../controller/ControllerProfile.php",
    data: formData,
    type: "POST",
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response["reussite"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      $("#modal").modal("hide");
      location.reload();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function updateImageBanniere() {
  var my_files = $("#new_file").get(0).files;

  let formData = new FormData();

  let element = "new_file";

  formData.append(element, my_files[0]);

  $.ajax({
    url: "../controller/ControllerBanniere.php",
    data: formData,
    type: "POST",
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response["reussite"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      $("#modal").modal("hide");
      location.reload();
    },
    error: function () {
      alert("Error !");
    },
  });
}
function updateProfile() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "updateProfile",
      nom: $("#Nom").val(),
      prenom: $("#Prenom").val(),
      email: $("#Email").val(),
      oldPassword: $("#PasswordConfirme").val(),
      newPassword: $("#PasswordUpdate").val(),
    },
    success: function (response) {
      if (response["statut"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
      $("#modal").modal("hide");
    },
    error: function () {
      alert("Error !");
    },
  });
}
function sendNewPassword() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "sendNewPassword",
      email: $("#Email").val(),
    },
    success: function (response) {
      $("#modal").modal("hide");
      if (response["statut"] == 1) {
        iziToast.success({
          title: "Valide",
          message: response["msg"],
        });
      }
    },
    error: function () {
      alert("Error !");
    },
  });
}
