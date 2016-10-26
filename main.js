
$(document).ready(function(){

  // Asign containers to variables
  var teamContainer     = $('.team-container--dropdown');
  var leagueContainer   = $('.league-container--dropdown');
  var resultsContainer  = $('.result-container .result');
  var scoreContainer    = $('.table tbody');
  var errorContainer    = $('.error-container');
  var loadingContainer  = $('.loading');
  var globalData = "";

  // Emppty all the containers
  scoreContainer.empty();
  errorContainer.empty();
  resultsContainer.empty();

  // Check the default radio button
  $("#fotboll").prop("checked", true);

  // Get data when page is loaded
  getTeamData();

  // Ajax function that gets the sports data
  function getScoreData(color){
    loadingContainer.show();

    var sport  = $('input[name=sport]:checked').val();
    var date   = $('input[name=date]').val();
    var league = $('.league-container--dropdown').val();
    var team   = $('.team-container--dropdown').val();

    $.ajax({
      url:"fetchResults.php",
      method:"POST",
      data:{sport:sport, date:date, league:league, team:team},
      dataType:"json",

      beforeSend: function(){
        scoreContainer.empty();
        errorContainer.empty();
        resultsContainer.empty();
        $('table').find('th').removeAttr('id');
        $('.default-sort').attr('id', 'sort-asc');
      },

      success: function(data){
        globalData = "";
        globalData = data;

        if(data != "No values found"){
          var results = 0;

          $.each(data, function(index, value) {
            results ++;
            scoreContainer.append(
              "<tr><td>" + value.date     + "</td>" +
              "<td>" + value.team1        + "</td>" +
              "<td>" + value.team1_score  + "</td>" +
              "<td>" + value.team2        + "</td>" +
              "<td>" + value.team2_score  + "</td>" +
              "<td>" + value.league       + "</td>" +
              "<td>" + value.city         + "</td></tr>"
              //"<td><a class='live-link' target='_blank' href='" + value.live + "'>Live Stream</a>" +
              //"<div class='box'><iframe width='300' height='200' src='" + value.live + "' frameborder='0'></iframe></div></td></tr>"
            );
          });

          resultsContainer.html(results);

        }else{errorContainer.append(
          "<div class='error'><h3>No values found. Try resetting your filters.</h3>" +
          "<button class='reset'>Reset Filters</button></div>"
        );}
       changeColor(color);
       loadingContainer.delay(300).fadeOut();
      }
    });
  }


  //Ajax function that gets the teams and the leagues
  function getTeamData(color){
    var sport  = $('input[name=sport]:checked').val();

    $.ajax({
      url:"fetchTeams.php",
      method:"POST",
      data:{sport:sport},
      dataType:"json",
      success: function(data){
        $('.team-container select option[value!="Team"]').remove();
        $('.league-container select option[value!="League"]').remove();
        teamContainer.append(data[0]);
        leagueContainer.append(data[1]);
        getScoreData(color);
      }
    });
  }


  // Initiate the datepicker
  $(function(){
    $("#datepicker").datepicker({
      minDate: -20,
      maxDate: 0,
      dateFormat: 'd.m.yy',
    });
  });


  // Function for setting the correct color
  function changeColor(color) {
    setTimeout(function(){
      $('.table-header').css("background", color);
    },300);
  }


  // Function for sorting items in ASC
  function sortAsc(a, b){
    var key = getSortFilter();
    if (a[key] < b[key])
      return -1;
    if (a[key] > b[key])
      return 1;
    return 0;
  }


  // Function for sorting items in DESC
  function sortDesc(a, b){
    var key = getSortFilter();
    if (a[key] < b[key])
      return 1;
    if (a[key] > b[key])
      return -1;
    return 0;
  }

  // Function for correctly sorting by date
  function sortDateDesc(a, b){
    var Aa = a.date.split(".");
    var Bb = b.date.split(".");

    a = new Date(Aa[2], Aa[1] - 1, Aa[0]);
    b = new Date(Bb[2], Bb[1] - 1, Bb[0]);

    if (a < b)
      return 1;
    if (a > b)
      return -1;
    return 0;
  }

  // Function for correctly sorting by date
  function sortDateAsc(a, b){
    var Aa = a.date.split(".");
    var Bb = b.date.split(".");

    a = new Date(Aa[2], Aa[1] - 1, Aa[0]);
    b = new Date(Bb[2], Bb[1] - 1, Bb[0]);

    if (a < b)
      return -1;
    if (a > b)
      return 1;
    return 0;
  }

  // Get the current sorting filter
  function getSortFilter(){
    return $('#sort-desc, #sort-asc').data('filter');
  }


  // Send the data needed for sorting to the sorting
  // function and output the results
  $(document).on('click', 'th', function() {
    var id = $(this).attr('id');
    var sorted = "";
    $('table').find('th').removeAttr('id');


    if($(this).hasClass('default-sort')){
      if(id == 'sort-asc'){
        $(this).attr('id', 'sort-desc');
        sorted = globalData.sort(sortDateAsc);
      }else{
        $(this).attr('id', 'sort-asc');
        sorted = globalData.sort(sortDateDesc);
      }
    }else{
    if(id == 'sort-asc'){
      $(this).attr('id', 'sort-desc');
      sorted = globalData.sort(sortDesc);
    }else{
      $(this).attr('id', 'sort-asc');
      sorted = globalData.sort(sortAsc);
    }
  }

    scoreContainer.html("");
    $.each(sorted, function(index, value) {
      scoreContainer.append(
        "<tr><td>" + value.date     + "</td>" +
        "<td>" + value.team1        + "</td>" +
        "<td>" + value.team1_score  + "</td>" +
        "<td>" + value.team2        + "</td>" +
        "<td>" + value.team2_score  + "</td>" +
        "<td>" + value.league       + "</td>" +
        "<td>" + value.city         + "</td></tr>"
        //"<td><a class='live-link' target='_blank' href='" + value.live + "'>Live Stream</a>" +
        //"<div class='box'><iframe width='300' height='200' src='" + value.live + "' frameborder='0'></iframe></div></td></tr>"
      );
    });
  });


  //Get new data when the sport is changed
  // Get the paramater for changing the color
  $(document).on('change', 'input[name=sport]', function() {
    var color = $(this).data('color');
    getTeamData(color);
  });


  // Get new data when the date is changed
  $(document).on('change', 'input[name=date]', function() {
    getScoreData();
  });


  // Refresh date when the date is removed
  $(document).on('click', '#clear-date', function() {
    $('input[name=date]').val("Date");
    getScoreData();
  });


  // Get new data when the team is changed
  $(document).on('change', '.team-container--dropdown', function() {
    getScoreData();
  });


  // Get new data when the league is changed
  $(document).on('change', '.league-container--dropdown', function() {
    getScoreData();
  });


  // Function for resetting the filters
  $(document).on('click', '.reset', function() {
    $("#fotboll").prop("checked", true);
    $('input[name=date]').val('Date');
    $('.league-container--dropdown').val('League');
    $('.team-container--dropdown').val('Team');
    getTeamData("#81e0a9");
  });



});
