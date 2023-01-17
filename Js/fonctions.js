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
  console.log("aaa");
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "loadMateriel",
      type: type,
    },
    success: function (response) {
      console.log("bbb");
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
      location.reload();
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
    success: function () {
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
      id: id
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
      id: id
    },
    success: function () {
      pageNotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}
