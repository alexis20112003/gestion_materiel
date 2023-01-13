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
      alert("Error !");
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
