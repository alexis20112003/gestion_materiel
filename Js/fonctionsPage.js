function connexion() {
  $.ajax({
    url: "../controller/ControllerConnect.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "connexion",
      mail: $("#EmailConnexion").val(),
      password: $("#PasswordConnexion").val(),
    },
    success: function (response) {
      if (response["status"] === "connected" && response["session"]) {
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

function deconnexion() {
  $.ajax({
    url: "../controller/ControllerConnect.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "deconnexion",
    },
    success: function (response) {
      window.location.href =
        "http://localhost/gestion_materiel/templates/Accueil.php";
      location.reload();
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
      loadUser(4);
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
      // const date = new Date();

      // let day = date.getDate();
      // let month = date.getMonth() + 1;
      // let year = date.getFullYear();

      // // This arrangement can be altered based on how we want the date's format to appear.
      // let currentDate = `${year}-${month}-${day}`;
      // new dateDropper({
      //   selector: 'input[type="text"]',
      //   format: "y-mm-dd",
      //   expandable: true,
      //   range: true,
      //   disabledWeekDays: '0,6',
      //   minDate: currentDate,
      //   lang: 'fr',
      //   startFromMonday: true,
      //   onRangeSet: function (range) {
      //     var start = range.a;
      //     var end = range.b;
      //     var date_debut = (start.y + '-' + start.mm + '-' + start.dd);
      //     var date_fin = (end.y + '-' + end.mm + '-' + end.dd);

      //     var field = (start.dd + '-' + start.mm + '-' + start.y + " // " + end.dd + '-' + end.mm + '-' + end.y);

      //     $("#dropper").val(field);
      //     // console.log($("#dropper").attr("data-dd-opt-range-start") + ' // ' + $("#dropper").attr("data-dd-opt-range-end"));
      //     ongletsMaterielDemande(date_debut, date_fin);
      //   }
      // });
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageGestionMateriel() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageGestionMateriel",
    },
    success: function (response) {
      $("#page").html(response);
      loadMateriel(1);
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageNotificationDemande() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageNotificationDemande",
    },
    success: function (response) {
      $("#page").html(response);
      NotificationDemande();
    },
    error: function () {
      alert("Error !");
    },
  });
}

function pageSuiviMateriel() {
  $.ajax({
    url: "../controller/ControllerRoute.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "pageSuiviMateriel",
    },
    success: function (response) {
      $("#page").html(response);
      loadAllUser();
    },
    error: function () {
      alert("Error !");
    },
  });
}
