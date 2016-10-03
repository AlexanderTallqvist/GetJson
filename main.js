
$(document).ready(function(){

  //Asign containers to variables
  var teamContainer     = $('.team-container');
  var leagueContainer   = $('.league-container');
  var resultsContainer  = $('.result-container');
  var scoreContainer    = $('.score-container');

  //Ajax function that gets the sports data
  function getJsonData(sport, date){
    $.ajax({
      url:"fetchResults.php",
      method:"POST",
      data:{sport:sport, date:date},
      dataType:"json",
      beforeSend: function(){
        $('.loading').show();
      },
      success: function(data){
        resultsContainer.html(data[0]);
        scoreContainer.html(data[1]);
        $('.loading').hide();
      }
    });
  }


  //Ajax function that gets the teams and the leagues
  function getTeamData(sport){
    $.ajax({
      url:"fetchTeams.php",
      method:"POST",
      data:{sport:sport},
      dataType:"json",
      beforeSend: function(){
        $('.loading').show();
      },
      success: function(data){
        teamContainer.html(data[0]);
        leagueContainer.html(data[1]);
        $('.loading').hide();
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

  //Get data when page is loaded
  var initSport = $('input[name=sport]:checked').val();
  var initDate = $('input[name=date]').val();
  getJsonData(initSport, initDate);
  getTeamData(initSport);

  //Refresh date when date is removed
  $('#clear-date').click(function(){
    $('input[name=date]').val("");
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
  });

  //Send the new value from the teams dropdown to getTeamData();
  $(document).on('change', '.team-dropdown', function(e) {
    var sport  = $('input[name=sport]:checked').val();
    var date   = $('input[name=date]').val();
    var league = $('.league-dropdown').val();
    var team   = $(this).val();

    alert(sport + date + league + team);
  });

  //Send the new value from the teams dropdown to getTeamData();
  $(document).on('change', '.league-dropdown', function(e) {
    var sport  = $('input[name=sport]:checked').val();
    var date   = $('input[name=date]').val();
    var team   = $('.team-dropdown').val();
    var league = $(this).val();

    alert(sport + " "  + date + league + team);
  });

  //Get new data when sport is changed
  $('input[name=sport]').change(function(){
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
    getTeamData(sport);
  });

  //Get new data when date is changed
  $('input[name=date]').change(function(){
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
  });

});
