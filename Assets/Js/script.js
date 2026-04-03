document.getElementById('btn-ubicacion').addEventListener('click', function() {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitud').value = position.coords.latitude;
                document.getElementById('longitud').value = position.coords.longitude;
                document.getElementById('estado-ubicacion').innerHTML = 'Ubicación obtenida: ' + 
                    position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6);
            },
            function(error) {
                let mensaje = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED: mensaje = 'Permiso denegado para obtener ubicación.'; break;
                    case error.POSITION_UNAVAILABLE: mensaje = 'Información de ubicación no disponible.'; break;
                    case error.TIMEOUT: mensaje = 'Tiempo de espera agotado.'; break;
                    default: mensaje = 'Error desconocido.';
                }
                document.getElementById('estado-ubicacion').innerHTML = mensaje;
            }
        );
    } else {
        document.getElementById('estado-ubicacion').innerHTML = 'Geolocalización no soportada por el navegador.';
    }
});