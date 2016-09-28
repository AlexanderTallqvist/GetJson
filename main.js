
$(document).ready(function(){

  //Asign containers to variables
  var teamContainer     = $('.team-container');
  var leagueContainer   = $('.league-container');
  var resultsContainer  = $('.result-container');
  var scoreContainer    = $('.score-container');

  //Ajax function that gets the data
  function getJsonData(sport, date){
    $.ajax({
      url:"fetch.php",
      method:"POST",
      data:{sport:sport, date:date},
      dataType:"json",
      beforeSend: function(){
        $('.loading').show();
      },
      success: function(data){
        resultsContainer.html(data[0]);
        scoreContainer.html(data[1]);
        teamContainer.html(data[2]);
        leagueContainer.html(data[3]);
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

  //Refresh date when date is removed
  $('#clear-date').click(function(){
    $('input[name=date]').val("");
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
  });

  //Get new data when sport is changed
  $('input[name=sport]').change(function(){
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
  });

  //Get new data when date is changed
  $('input[name=date]').change(function(){
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    getJsonData(sport, date);
  });

});
