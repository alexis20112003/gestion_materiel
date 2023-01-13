new dateDropper({
  selector: 'input[type="text"]',
  format: "y-mm-dd",
  expandable: true,
  range: true,
  disabledWeekDays: "0,6",
  lang: "fr",
  startFromMonday: true,
  onRangeSet: function (range) {
    var start = range.a;
    var end = range.b;
    var date_debut = start.y + "-" + start.m + "-" + start.d;
    var date_fin = end.y + "-" + end.m + "-" + end.d;

    var field =
      start.d +
      "-" +
      start.m +
      "-" +
      start.y +
      "/" +
      end.d +
      "-" +
      end.m +
      "-" +
      end.y;

    $("#dropper").val(field);
    console.log($("#dropper").attr("data-dd-opt-range-start"));
    // loadMateriel()
    console.log(date_debut + " to " + date_fin);
  },
});
