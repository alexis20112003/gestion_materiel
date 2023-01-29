function modalAddUser() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalAddUser",
    },
    success: function (response) {
      $(".modal-content").html(response);
      $("#modal").modal("show");
    },
    error: function () {
      alert("Error 2");
    },
  });
}

function modalUpdateUser(id) {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalUpdateUser",
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
function modalAddMateriel() {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalAddMateriel",
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

function modalUpdateMateriel(id) {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalUpdateMateriel",
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

function modalAddTypeMateriel() {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalAddTypeMateriel",
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

function modalDetailMateriel(id) {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalDetailMateriel",
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

function modalSuiviMateriel(id) {
  $.ajax({
    url: "../controller/ControllerMateriel.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalSuiviMateriel",
      id: id,
    },
    success: function (response) {
      $(".modal-content").html(response);
      $("#modal").modal("show");
      console.log("aaa");
    },
    error: function () {
      alert("Error !");
    },
  });
}

function modalSuiviUser(id) {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalSuiviUser",
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

function modalUpdateImageProfile() {
  $.ajax({
    url: "../controller/ControllerCompte.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "modalUpdateImageProfile",
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
