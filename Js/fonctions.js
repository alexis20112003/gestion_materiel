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
function onclicMat() {
  type = $(this).attr("name");
  $.ajax({
    url: "../controller/gestion_mat.php",
    dataType: "json",
    type: "POST",
    data: {
      request: "gestionMat",
    },
    success: function (response) {
      $("#myTabContent").html(response);
    },
    error: function () {
      alert("Error !");
    },
  });
}
