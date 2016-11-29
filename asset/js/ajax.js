// AJAX.js
$('#inscription').submit(function(e) {
  e.preventDefault();
  console.log('dede');
  var form = $('#inscription');

  $('#error_pseudo').empty();
  $('#error_email').empty();
  $('#error_password').empty();
  $('#error_repeatpassword').empty();

  $.ajax({
    type: "POST",
    url: form.attr('action'),
    data:form.serialize(),
    //dataType:"json",
    success: function(response){
      console.log(response);
      console.log('dede2');
      if(response.success === true) {

        $('#inscriptiondone').html('<h3 style="text-align: center;">Bravo, vous êtes bien inscrit</h3>');

      //   //redirection vers page de connexion
        $('#inscription').fadeOut(2000, function(){
          document.location.href="connexion.php";
        });
      }else {
        if(response.error.pseudo != null) {
          $('#error_pseudo').append(response.error.pseudo);
        }
        if(response.error.email != null) {
          $('#error_email').append(response.error.email);
        }
        if(response.error.password != null){
          $('#error_password').append(response.error.password);
        }
        if(response.error.repeatpassword != null){
          $('#error_repeatpassword').append(response.error.repeatpassword);
        }
      }
    }
  });
});

$('#connexion').submit(function(e) {
  e.preventDefault();
  console.log("dede");
  var form = $('#connexion');

  $('#error_pseudo').empty();
  $('#error_password').empty();

  $.ajax({
    type: "POST",
    url: form.attr('action'),
    data:form.serialize(),
    dataType:"json",
    success: function(response){
      // console.log(response);
      if(response.success === true) {
      //  redirection vers page d'accueil
        $('#connexion').fadeOut(1000, function(){
          document.location.href="index.php";
        });
      }else {
        if(response.error.pseudo != null) {
          $('#error_pseudo').append(response.error.pseudo);
        }
        if(response.error.password != null){
          $('#error_password').append(response.error.password);
        }
      }
    }
  });
});

// Franck note
$('#movie_note').submit(function(e) {
  e.preventDefault();
  var form = $('#movie_note');
  $('#error_note').empty();
  $.ajax({
    type: "POST",
    url: "note_ajax.php",
    data:form.serialize(),
    success: function(response){


      if(response.success === true) {
        console.log(response);
        $('#movie_note').fadeOut(1000);
        $('#aVoir').fadeOut(1000);

        setTimeout(function(){  $('#show_note').fadeIn(2000); }, 2000);
      } else {
        if(response.error.note != null) {
          $('#error_note').append(response.error.note);
        }
      }
    },
    error: function(){
      console.error('Erreur');
    }
  });
});
