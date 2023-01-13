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