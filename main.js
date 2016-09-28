
$(document).ready(function(){

  //Asign containers to variables
  var myContainer = $('.data-container');
  var teamContainer = $('.teams-container');

  //Ajax function that gets the data
  function getJsonData(sport, date){
    $.ajax({
      url:"fetch.php",
      method:"POST",
      data:{sport:sport, date:date},
      dataType:"text",
      beforeSend: function(){
        $('.loading').show();
      },
      success: function(data){
        myContainer.html(data);
        $('.loading').hide();
      }
    });
  }

  //Ajax function that gets all the teams and populates the dropdown
  function getTeams(){
    $.ajax({
      url:"teams.php",
      method:"POST",
      dataType:"text",
      success: function(data){
        teamContainer.html(data);
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
  getTeams();

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
    myContainer.empty();
    getJsonData(sport, date);
  });

  //Get new data when date is changed
  $('input[name=date]').change(function(){
    var sport = $('input[name=sport]:checked').val();
    var date  = $('input[name=date]').val();
    myContainer.empty();
    getJsonData(sport, date);
  });

});
