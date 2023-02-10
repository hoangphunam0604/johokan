jQuery(function ($) {
  var yearChartElm = $("#year-chart");
  var weekChartElm = $("#week-chart");
  var monthChartElm = $("#month-chart");

  var yearChar;
  var weekChar;
  var monthChar;

  $("#role").change(function () {
    $("#sup-admin-users").toggle($(this).val() === 'sub-admin');
  })
  $("#get-data").click(function () {
    fectAllChart();
  })
  $("#year").change(function () {
    runStatisticYear();
  })
  $("#month").change(function () {
    runStatisticMonth();
  })


  fectAllChart();

  function fectAllChart() {
    runStatisticYear();
    runStatisticWeek();
    runStatisticMonth();
  }

  function runStatisticYear() {
    const year = $("#year").val();
    let data = {
      year: year
    }
    const role = $("#role").val();
    const user_id = $("#user_id").val();
    if (role == 'sub-admin' && user_id != '') {
      data = {
        ...data,
        user_id: user_id,
      }
    }
    const loading = $(`<div class="loading"><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>`)
    yearChartElm.after(loading)


    $.ajax({
      url: ajaxurl,
      data: { action: "get_statistics_by_year", ...data },
      type: "GET",
      success: function (response) {
        if (typeof yearChar !== 'undefined')
          yearChar.destroy();
        $("#total-year").text(response.total);
        yearChar = new Chart(yearChartElm, response.chart);
        loading.remove();
        yearChartElm.closest('.chart-wrap').css({ height: yearChartElm.height() });
      }
    })
  }


  function runStatisticWeek() {
    const year = $("#year").val();
    let data = {
    }
    const role = $("#role").val();
    const user_id = $("#user_id").val();
    if (role == 'sub-admin' && user_id != '') {
      data = {
        user_id: user_id,
      }
    }
    const loading = $(`<div class="loading"><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>`)
    weekChartElm.after(loading)


    $.ajax({
      url: ajaxurl,
      data: { action: "get_statistics_by_week", ...data },
      type: "GET",
      success: function (response) {
        if (typeof weekChar !== 'undefined')
          weekChar.destroy();
        $("#total-week").text(response.total);
        weekChar = new Chart(weekChartElm, response.chart);
        loading.remove();
        weekChartElm.closest('.chart-wrap').css({ height: weekChartElm.height() });
      }
    })
  }
  function runStatisticMonth() {
    const month = $("#month").val();
    let data = {
      month: month
    }
    const role = $("#role").val();
    const user_id = $("#user_id").val();
    if (role == 'sub-admin' && user_id != '') {
      data = {
        ...data,
        user_id: user_id,
      }
    }
    const loading = $(`<div class="loading"><div class="lds-grid"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>`)
    monthChartElm.after(loading)

    $.ajax({
      url: ajaxurl,
      data: { action: "get_statistics_by_month", ...data },
      type: "GET",
      success: function (response) {
        if (typeof monthChar !== 'undefined')
          monthChar.destroy();
        $("#total-month").text(response.total);
        monthChar = new Chart(monthChartElm, response.chart);
        loading.remove();
        monthChartElm.closest('.chart-wrap').css({ height: monthChartElm.height() });
      }
    })
  }
})
