// Bouton sélectionnant toutes les catégories de film
$('#select-all').click(function(event) {
    event.preventDefault();
    // if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;
        });
    // }
});

// Bouton servant a afficher la recherche par filtres
$('#filtres').click(function(e) {
  e.preventDefault();
  if ( $( "#div_form:first" ).is( ":hidden" ) ) {
   $( "#div_form" ).slideDown( "slow" );
   } else {
   $( "#div_form" ).slideUp();
 }
});
