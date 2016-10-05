
$(document).ready(function(){

  //Get data when page is loaded
  getScoreData();
  getTeamData();


  //Asign containers to variables
  var teamContainer     = $('.team-container');
  var leagueContainer   = $('.league-container');
  var resultsContainer  = $('.result-container');
  var scoreContainer    = $('.score-container');


  //Ajax function that gets the sports data
  function getScoreData(){

    var sport  = $('input[name=sport]:checked').val();
    var date   = $('input[name=date]').val();
    var league = $('.league-dropdown').val();
    var team   = $('.team-dropdown').val();

    $.ajax({
      url:"fetchResults.php",
      method:"POST",
      data:{sport:sport, date:date, team:team, league:league},
      dataType:"json",
      beforeSend: function(){
        $('.loading-score').show();
      },
      success: function(data){
        $('.loading-score').hide();
        resultsContainer.html(data[0]);
        scoreContainer.html(data[1]);
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

  //Function for embeded Iframes
  $(document).on('mouseleave', '.box', function() {
    alert("Test");
  });


});
