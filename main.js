
$(document).ready(function(){

  //Asign containers to variables
  var teamContainer     = $('.team-container');
  var leagueContainer   = $('.league-container');
  var resultsContainer  = $('.result-container');
  var scoreContainer    = $('.table tbody');
  var errorContainer    = $('.error-container');

  //Get data when page is loaded
  getScoreData();
  getTeamData();

  //Ajax function that gets the sports data
  function getScoreData(){

    var sport  = $('input[name=sport]:checked').val();
    var date   = $('input[name=date]').val();
    var league = $('.league-dropdown').val();
    var team   = $('.team-dropdown').val();

    $.ajax({
      url:"fetchResults.php",
      method:"POST",
      data:{sport:sport, date:date, league:league, team:team},
      dataType:"json",

      beforeSend: function(){
        $('.loading-score').show();
        scoreContainer.html("");
        errorContainer.html("");
        resultsContainer.html("");
      },

      success: function(data){
        $('.loading-score').hide();

        if(data != "No values found"){
          var results = 0;

          $.each(data, function(index, value) {
            results ++;
            scoreContainer.append(
              "<tr><td>" + value.sport        + "</td>" +
              "<td>"     + value.date         + "</td>" +
              "<td>"     + value.team1        + "</td>" +
              "<td>"     + value.team1_score  + "</td>" +
              "<td>"     + value.team2        + "</td>" +
              "<td>"     + value.team2_score  + "</td>" +
              "<td>"     + value.league       + "</td>" +
              "<td>"     + value.city         + "</td>"+
              "<td><a class='live-link' target='_blank' href='" + value.live + "'>Live Stream</a>" +
              "<div class='box'><iframe width='300' height='200' src='" + value.live + "' frameborder='0'></iframe></div></td></tr>"
            );
          });

          resultsContainer.html("<h4>Your filters found a total of " + results + " results.</h4>");

        }else{errorContainer.append("<div class='error alert alert-info'>No values found. Try reseting your filters." +
        "<button class='reset btn btn-primary'>Reset Filters</button></div>");}
      }
    });
  }


  //Ajax function that gets the teams and the leagues
  function getTeamData(){

    var sport  = $('input[name=sport]:checked').val();

    $.ajax({
      url:"fetchTeams.php",
      method:"POST",
      data:{sport:sport},
      dataType:"json",
      beforeSend: function(){
        $('.loading-team').show();
      },
      success: function(data){
        $('.loading-team').hide();
        teamContainer.html(data[0]);
        leagueContainer.html(data[1]);
        getScoreData();
      }
    });
  }


  //Initiate the datepicker
  $(function(){
    $("#datepicker").datepicker({
      minDate: -20,
      maxDate: 0,
      dateFormat: 'd.m.yy',
    });
  });


  //Get new data when the sport is changed
  $(document).on('change', 'input[name=sport]', function() {
    getTeamData();
  });


  //Get new data when the date is changed
  $(document).on('change', 'input[name=date]', function() {
    getScoreData();
  });


  //Refresh date when the date is removed
  $(document).on('click', '#clear-date', function() {
    $('input[name=date]').val("Date");
    getScoreData();
  });


  //Get new data when the team is changed
  $(document).on('change', '.team-dropdown', function() {
    getScoreData();
  });


  //Get new data when the league is changed
  $(document).on('change', '.league-dropdown', function() {
    getScoreData();
  });


  //Function for resetting the filters
  $(document).on('click', '.reset', function() {
    $('input[name=sport]').prop('checked', function () {
        return this.getAttribute('checked') == 'checked';
    });

    $('input[name=date]').val('Date');
    $('.league-dropdown').val('League');
    $('.team-dropdown').val('Team');

    getScoreData();
  });


});
