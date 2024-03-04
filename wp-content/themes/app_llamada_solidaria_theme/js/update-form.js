//Previene que se reenvíe el buscador al actualizar la pagina
history.replaceState(null, null, location.pathname);

/*
$('#search_form').on('submit', function() {
	//e.preventDefault();
	history.replaceState(null, null, location.pathname);
});
*/