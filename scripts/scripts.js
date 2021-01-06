function fillSelectCountry() {
    if (document.body.contains(document.getElementById("pais"))) {
        var vector_paises = ["Seleccionar", "Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda", "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica", "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia", "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Catar", "Chad", "Chile", "China", "Chipre", "Ciudad del Vaticano", "Colombia", "Comoras", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guyana", "Guinea", "Guinea ecuatorial", "Guinea-Bisáu", "Haití", "Honduras", "Hungría", "India", "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall", "Islas Salomón", "Israel", "Italia", "Jamaica", "Japón", "Jordania", "Kazajistán", "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Marruecos", "Mauricio", "Mauritania", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru", "Nepal", "Nicaragua", "Níger", "Nigeria", "Noruega", "Nueva Zelanda", "Omán", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa Nueva Guinea", "Paraguay", "Perú", "Polonia", "Portugal", "Puerto Rico", "Reino Unido", "República Centroafricana", "República Checa", "República de Macedonia", "República del Congo", "República Democrática del Congo", "República Dominicana", "República Sudafricana", "Ruanda", "Rumanía", "Rusia", "Samoa", "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam", "Tailandia", "Tanzania", "Tayikistán", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Zambia", "Zimbabue"];
        vector_paises.forEach(x => {
            var nodo_option = document.createElement("option");
            nodo_option.textContent = x;
            nodo_option.value = x;
            document.getElementById("pais").options.add(nodo_option);
        });
    }
}

function validationUser() {
    var mensaje = "Error en los siguientes campos:\n\n";

    var correo = document.getElementById("correo");
    var pass = document.getElementById("pass");
    var nick = document.getElementById("nick");
    var nombre = document.getElementById("nombre");
    var pais = document.getElementById("pais");
    var imagen = document.getElementById("imagen");

    var expresion_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    var expresion_pass = /^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{7,14}$/;
    var expresion_nick = /^[A-ZÑa-zñ0-9_-]{4,20}$/;
    var expresion_nombre = /^([A-ZÑÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;

    if (!(expresion_correo.test(correo.value))) {
        mensaje += "-> CORREO ELECTRÓNICO\n";
        correo.style.border = "2px solid red";
    } else
        correo.style.border = "2px solid #26a59a";

    if (!(expresion_pass.test(pass.value))) {
        mensaje += "-> PASSWORD\n";
        pass.style.border = "2px solid red";
    } else
        pass.style.border = "2px solid #26a59a";

    if (!(expresion_nick.test(nick.value))) {
        mensaje += "-> NICK\n";
        nick.style.border = "2px solid red";
    } else
        nick.style.border = "2px solid #26a59a";

    if (!(expresion_nombre.test(nombre.value))) {
        mensaje += "-> NOMBRE\n";
        nombre.style.border = "2px solid red";
    } else
        nombre.style.border = "2px solid #26a59a";

    if (pais.value == "Seleccionar") {
        mensaje += "-> PAÍS: Seleccione un país\n";
        pais.style.border = "2px solid red";
    } else
        pais.style.border = "2px solid #26a59a";

    if (imagen.value == "") {
        mensaje += "-> IMAGEN: Seleccione una imagen";
        imagen.style.border = "2px solid red";
    } else
        imagen.style.border = "2px solid #26a59a";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;
}

function validationArtist() {
    var mensaje = "Error en los siguientes campos:\n\n";

    var correo = document.getElementById("correo");
    var pass = document.getElementById("pass");
    var nombre_artistico = document.getElementById("nombre_artistico");
    var nombre = document.getElementById("nombre");
    var pais = document.getElementById("pais");
    var biografia = document.getElementById("biografia");
    var imagen = document.getElementById("imagen");

    var expresion_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    var expresion_pass = /^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{7,14}$/;
    var expresion_nombre_artistico = /^([A-Za-zÑÁÉÍÓÚ0-9-_]{0}[A-Za-zñáéíóú0-9-_]+[\s]*)+$/;
    var expresion_nombre = /^([A-ZÑÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;

    if (!(expresion_correo.test(correo.value))) {
        mensaje += "-> CORREO ELECTRÓNICO\n";
        correo.style.border = "2px solid red";
    } else
        correo.style.border = "2px solid #673bb7";

    if (!(expresion_pass.test(pass.value))) {
        mensaje += "-> PASSWORD\n";
        pass.style.border = "2px solid red";
    } else
        pass.style.border = "2px solid #673bb7";

    if (!(expresion_nombre_artistico.test(nombre_artistico.value))) {
        mensaje += "-> NOMBRE ARTÍSTICO\n";
        nombre_artistico.style.border = "2px solid red";
    } else
        nombre_artistico.style.border = "2px solid #673bb7";

    if (!(expresion_nombre.test(nombre.value))) {
        mensaje += "-> NOMBRE\n";
        nombre.style.border = "2px solid red";
    } else
        nombre.style.border = "2px solid #673bb7";

    if (pais.value == "Seleccionar") {
        mensaje += "-> PAÍS: Seleccione un país\n";
        pais.style.border = "2px solid red";
    } else
        pais.style.border = "2px solid #673bb7";

    if (biografia.value.length > 600) {
        mensaje += "-> BIOGRAFÍA: Supera los 600 caracteres\n";
        biografia.style.border = "2px solid red";
    } else
        biografia.style.border = "2px solid #673bb7";

    if (imagen.value == "") {
        mensaje += "-> IMAGEN: Seleccione una imagen";
        imagen.style.border = "2px solid red";
    } else
        imagen.style.border = "2px solid #673bb7";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;
}

function marcarActivo(element) {
    var htmlcollection_input = document.getElementsByTagName("input");
    for (let i = 0; i < htmlcollection_input.length; i++) {
        if (htmlcollection_input.item(i).isSameNode(element)) {
            htmlcollection_input.item(i).classList.add("button_activo");
        } else {
            htmlcollection_input.item(i).classList.remove("button_activo");
        }
    }
}

function mostrarPerfilSaldo(element) {
    marcarActivo(element);
    document.getElementById("fs_perfil").style.display = "block";
    document.getElementById("fs_saldo").style.display = "block";
    document.getElementById("fs_modificar").style.display = "none";
    document.getElementById("fs_modificarEstado").style.display = "none";
    document.getElementById("fs_eliminar").style.display = "none";
    document.getElementById("fs_insertar_temas").style.display = "none";
    document.getElementById("botoninsertartemas").style.display = "none";
    document.getElementById("botonmostrartemas").style.display = "none";
}

function mostrarMod(element) {
    marcarActivo(element);
    document.getElementById("fs_modificar").style.display = "block";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_modificarEstado").style.display = "none";
    document.getElementById("fs_eliminar").style.display = "none";
    document.getElementById("fs_insertar_temas").style.display = "none";
    document.getElementById("botoninsertartemas").style.display = "none";
    document.getElementById("botonmostrartemas").style.display = "none";
}

function mostrarEli(element) {
    marcarActivo(element);
    document.getElementById("fs_modificarEstado").style.display = "block";
    document.getElementById("fs_eliminar").style.display = "block";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_modificar").style.display = "none";
    document.getElementById("fs_insertar_temas").style.display = "none";
    document.getElementById("botoninsertartemas").style.display = "none";
    document.getElementById("botonmostrartemas").style.display = "none";
}

function mostrarTem(element) {
    marcarActivo(element);
    document.getElementById("botoninsertartemas").style.display = "block";
    document.getElementById("botonmostrartemas").style.display = "block";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_modificar").style.display = "none";
    document.getElementById("fs_modificarEstado").style.display = "none";
    document.getElementById("fs_eliminar").style.display = "none";
}

function deshabilitarDivsArtista() {
    if (document.body.contains(document.getElementById("retirar_saldo")) && document.body.contains(document.getElementById("fs_modificar")) && document.body.contains(document.getElementById("fs_modificarEstado")) && document.body.contains(document.getElementById("fs_eliminar")) && document.body.contains(document.getElementById("fs_insertar_temas")) && document.body.contains(document.getElementById("botoninsertartemas")) && document.body.contains(document.getElementById("botonmostrartemas"))) {
        document.getElementById("retirar_saldo").disabled = true;
        document.getElementById("retirar_saldo").style.backgroundColor = "gray";
        document.getElementById("fs_modificar").style.display = "none";
        document.getElementById("fs_modificarEstado").style.display = "none";
        document.getElementById("fs_eliminar").style.display = "none";
        document.getElementById("fs_insertar_temas").style.display = "none";
        document.getElementById("botoninsertartemas").style.display = "none";
        document.getElementById("botonmostrartemas").style.display = "none";
    }
}

function mostrarInsertarTem() {
    if (document.getElementById("fs_insertar_temas").style.display == "none")
        document.getElementById("fs_insertar_temas").style.display = "block";
    else document.getElementById("fs_insertar_temas").style.display = "none";
}

function mostrarEuroSaldo() {
    document.getElementById("euro_saldo").textContent = document.getElementById("rango_saldo").value + "€";
    if (document.getElementById("euro_saldo").textContent == "0€") {
        document.getElementById("retirar_saldo").disabled = true;
        document.getElementById("retirar_saldo").style.backgroundColor = "gray";
    } else {
        document.getElementById("retirar_saldo").disabled = false;
        document.getElementById("retirar_saldo").style.backgroundColor = "#673bb7";
    }
}

function validationArtistNoImage() {
    var mensaje = "Error en los siguientes campos:\n\n";

    var correo = document.getElementById("correo");
    var pass = document.getElementById("pass");
    var nombre_artistico = document.getElementById("nombre_artistico");
    var nombre = document.getElementById("nombre");
    var pais = document.getElementById("pais");
    var biografia = document.getElementById("biografia");

    var expresion_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    var expresion_pass = /^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{7,14}$/;
    var expresion_nombre_artistico = /^([A-Za-zÑÁÉÍÓÚ0-9-_]{0}[A-Za-zñáéíóú0-9-_]+[\s]*)+$/;
    var expresion_nombre = /^([A-ZÑÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;

    if (!(expresion_correo.test(correo.value))) {
        mensaje += "-> CORREO ELECTRÓNICO\n";
        correo.style.border = "2px solid red";
    } else
        correo.style.border = "2px solid #673bb7";

    if (!(expresion_pass.test(pass.value))) {
        mensaje += "-> PASSWORD\n";
        pass.style.border = "2px solid red";
    } else
        pass.style.border = "2px solid #673bb7";

    if (!(expresion_nombre_artistico.test(nombre_artistico.value))) {
        mensaje += "-> NOMBRE ARTÍSTICO\n";
        nombre_artistico.style.border = "2px solid red";
    } else
        nombre_artistico.style.border = "2px solid #673bb7";

    if (!(expresion_nombre.test(nombre.value))) {
        mensaje += "-> NOMBRE\n";
        nombre.style.border = "2px solid red";
    } else
        nombre.style.border = "2px solid #673bb7";

    if (pais.value == "Seleccionar") {
        mensaje += "-> PAÍS: Seleccione un país\n";
        pais.style.border = "2px solid red";
    } else
        pais.style.border = "2px solid #673bb7";

    if (biografia.value.length > 600) {
        mensaje += "-> BIOGRAFÍA: Supera los 600 caracteres";
        biografia.style.border = "2px solid red";
    } else
        biografia.style.border = "2px solid #673bb7";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;
}

function validationUserNoImage() {
    var mensaje = "Error en los siguientes campos:\n\n";

    var correo = document.getElementById("correo");
    var pass = document.getElementById("pass");
    var nick = document.getElementById("nick");
    var nombre = document.getElementById("nombre");
    var pais = document.getElementById("pais");

    var expresion_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    var expresion_pass = /^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{7,14}$/;
    var expresion_nick = /^[A-ZÑa-zñ0-9_-]{4,20}$/;
    var expresion_nombre = /^([A-ZÑÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;

    if (!(expresion_correo.test(correo.value))) {
        mensaje += "-> CORREO ELECTRÓNICO\n";
        correo.style.border = "2px solid red";
    } else
        correo.style.border = "2px solid #26a59a";

    if (!(expresion_pass.test(pass.value))) {
        mensaje += "-> PASSWORD\n";
        pass.style.border = "2px solid red";
    } else
        pass.style.border = "2px solid #26a59a";

    if (!(expresion_nick.test(nick.value))) {
        mensaje += "-> NICK\n";
        nick.style.border = "2px solid red";
    } else
        nick.style.border = "2px solid #26a59a";

    if (!(expresion_nombre.test(nombre.value))) {
        mensaje += "-> NOMBRE\n";
        nombre.style.border = "2px solid red";
    } else
        nombre.style.border = "2px solid #26a59a";

    if (pais.value == "Seleccionar") {
        mensaje += "-> PAÍS: Seleccione un país\n";
        pais.style.border = "2px solid red";
    } else
        pais.style.border = "2px solid #26a59a";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;
}

function validationTheme() {
    var mensaje = "Error en los siguientes campos:\n\n";

    document.getElementById("nombre_tema").style.border = "2px solid #673bb7";
    document.getElementById("precio_tema").style.border = "2px solid #673bb7";

    var tema_completo = document.getElementById("completo_tema");
    var tema_teaser = document.getElementById("teaser_tema");
    var tema_categoria = document.getElementById("categoria_tema");
    var tema_nota = document.getElementById("nota_tema");
    var tema_imagen = document.getElementById("imagen_tema");

    if (tema_completo.value == "") {
        mensaje += "-> MP3 - COMPLETO: Seleccione un archivo MP3\n";
        tema_completo.style.border = "2px solid red";
    } else
        tema_completo.style.border = "2px solid #673bb7";

    if (tema_teaser.value == "") {
        mensaje += "-> MP3 - TEASER: Seleccione un archivo MP3\n";
        tema_teaser.style.border = "2px solid red";
    } else
        tema_teaser.style.border = "2px solid #673bb7";

    if (tema_categoria.value == "Seleccionar") {
        mensaje += "-> CATEGORÍA: Seleccione una categoría\n";
        tema_categoria.style.border = "2px solid red";
    } else
        tema_categoria.style.border = "2px solid #673bb7";

    if (tema_nota.value.length > 600) {
        mensaje += "-> NOTA: Supera los 600 caracteres\n";
        tema_nota.style.border = "2px solid red";
    } else
        tema_nota.style.border = "2px solid #673bb7";

    if (tema_imagen.value == "") {
        mensaje += "-> IMAGEN: Seleccione una imagen";
        tema_imagen.style.border = "2px solid red";
    } else
        tema_imagen.style.border = "2px solid #673bb7";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;
}

function fillSelectCategory() {
    if (document.body.contains(document.getElementById("categoria_tema"))) {
        var vector_categoria = ["Reggaeton", "Blues", "Classic Rock", "Country", "Dance", "Disco", "Funk", "Grunge",
            "Hip-Hop", "Jazz", "Metal", "New Age", "Oldies", "Other", "Pop", "R&B",
            "Rap", "Reggae", "Rock", "Techno", "Industrial", "Alternative", "Ska",
            "Death Metal", "Pranks", "Soundtrack", "Euro-Techno", "Ambient",
            "Trip-Hop", "Vocal", "Jazz+Funk", "Fusion", "Trance", "Classical",
            "Instrumental", "Acid", "House", "Game", "Sound Clip", "Gospel",
            "Noise", "AlternRock", "Bass", "Soul", "Punk", "Space", "Meditative",
            "Instrumental Pop", "Instrumental Rock", "Ethnic", "Gothic",
            "Darkwave", "Techno-Industrial", "Electronic", "Pop-Folk",
            "Eurodance", "Dream", "Southern Rock", "Comedy", "Cult", "Gangsta",
            "Top 40", "Christian Rap", "Pop/Funk", "Jungle", "Native American",
            "Cabaret", "New Wave", "Psychadelic", "Rave", "Showtunes", "Trailer",
            "Lo-Fi", "Tribal", "Acid Punk", "Acid Jazz", "Polka", "Retro",
            "Musical", "Rock & Roll", "Hard Rock", "Folk", "Folk-Rock",
            "National Folk", "Swing", "Fast Fusion", "Bebob", "Latin", "Revival",
            "Celtic", "Bluegrass", "Avantgarde", "Gothic Rock", "Progressive Rock",
            "Psychedelic Rock", "Symphonic Rock", "Slow Rock", "Big Band",
            "Chorus", "Easy Listening", "Acoustic", "Humour", "Speech", "Chanson",
            "Opera", "Chamber Music", "Sonata", "Symphony", "Booty Bass", "Primus",
            "Porn Groove", "Satire", "Trap", "Slow Jam", "Club", "Tango", "Samba",
            "Folklore", "Ballad", "Power Ballad", "Rhythmic Soul", "Freestyle",
            "Duet", "Punk Rock", "Drum Solo", "Acapella", "Euro-House", "Dance Hall"
        ];
        vector_categoria.sort();
        vector_categoria.splice(0, 0, "Seleccionar");
        vector_categoria.forEach(x => {
            var nodo_option = document.createElement("option");
            nodo_option.textContent = x;
            nodo_option.value = x;
            document.getElementById("categoria_tema").options.add(nodo_option);
        });
    }
}

function mostrarTabla() {
    // location.href = "mymusic.php";
    window.open('mymusic.php', '_blank');
}

function mostrarUsuarios() {
    location.href = 'usuarios.php';
}

function mostrarArtistas() {
    location.href = 'artistas.php';
}

function validationThemeMod() {
    var mensaje = "Error en los siguientes campos:\n\n";

    document.getElementById("nombre_tema").style.border = "2px solid #673bb7";
    document.getElementById("precio_tema").style.border = "2px solid #673bb7";

    var tema_categoria = document.getElementById("categoria_tema");
    var tema_nota = document.getElementById("nota_tema");

    if (tema_categoria.value == "Seleccionar") {
        mensaje += "-> CATEGORÍA: Seleccione una categoría\n";
        tema_categoria.style.border = "2px solid red";
    } else
        tema_categoria.style.border = "2px solid #673bb7";

    if (tema_nota.value.length > 600) {
        mensaje += "-> NOTA: Supera los 600 caracteres\n";
        tema_nota.style.border = "2px solid red";
    } else
        tema_nota.style.border = "2px solid #673bb7";

    document.getElementById("imagen_tema").style.border = "2px solid #673bb7";

    if (mensaje != "Error en los siguientes campos:\n\n") {
        alert(mensaje);
        return false;
    } else
        return true;

}

function mostrarHome() {
    // window.open('.', '_blank');
    location.href = '.';
}

function mostrarCloud() {
    window.open('../../..', '_blank');
}

function mostrarPerfilSaldoUser(element) {
    marcarActivo(element);
    document.getElementById("fs_perfil").style.display = "block";
    document.getElementById("fs_saldo").style.display = "block";
    document.getElementById("fs_modificar").style.display = "none";
    document.getElementById("fs_eliminar").style.display = "none";
    document.getElementById("botonmostrartemasuser").style.display = "none";
    document.getElementById("botonmostrarlicencias").style.display = "none";
    document.getElementById("botonmostrarartist").style.display = "none";
}

function mostrarEuroSaldoUser() {
    document.getElementById("euro_saldo").textContent = document.getElementById("rango_saldo").value + "€";
    if (document.getElementById("euro_saldo").textContent == "0€") {
        document.getElementById("ingresar_saldo").disabled = true;
        document.getElementById("ingresar_saldo").style.backgroundColor = "gray";
    } else {
        document.getElementById("ingresar_saldo").disabled = false;
        document.getElementById("ingresar_saldo").style.backgroundColor = "#26a59a";
    }
}

function deshabilitarDivsUser() {
    if (document.body.contains(document.getElementById("ingresar_saldo")) && document.body.contains(document.getElementById("fs_modificar")) && document.body.contains(document.getElementById("fs_eliminar")) && document.body.contains(document.getElementById("botonmostrartemasuser")) && document.body.contains(document.getElementById("botonmostrarlicencias")) && document.body.contains(document.getElementById("botonmostrarartist"))) {
        document.getElementById("ingresar_saldo").disabled = true;
        document.getElementById("ingresar_saldo").style.backgroundColor = "gray";
        document.getElementById("fs_modificar").style.display = "none";
        document.getElementById("fs_eliminar").style.display = "none";
        document.getElementById("botonmostrartemasuser").style.display = "none";
        document.getElementById("botonmostrarlicencias").style.display = "none";
        document.getElementById("botonmostrarartist").style.display = "none";
    }
}

function mostrarModUser(element) {
    marcarActivo(element);
    document.getElementById("fs_modificar").style.display = "block";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_eliminar").style.display = "none";
    document.getElementById("botonmostrartemasuser").style.display = "none";
    document.getElementById("botonmostrarlicencias").style.display = "none";
    document.getElementById("botonmostrarartist").style.display = "none";
}

function mostrarEliUser(element) {
    marcarActivo(element);
    document.getElementById("fs_eliminar").style.display = "block";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_modificar").style.display = "none";
    document.getElementById("botonmostrartemasuser").style.display = "none";
    document.getElementById("botonmostrarlicencias").style.display = "none";
    document.getElementById("botonmostrarartist").style.display = "none";
}

function mostrarLic(element) {
    marcarActivo(element);
    document.getElementById("botonmostrartemasuser").style.display = "block";
    document.getElementById("botonmostrarlicencias").style.display = "block";
    document.getElementById("botonmostrarartist").style.display = "block";
    document.getElementById("fs_eliminar").style.display = "none";
    document.getElementById("fs_perfil").style.display = "none";
    document.getElementById("fs_saldo").style.display = "none";
    document.getElementById("fs_modificar").style.display = "none";
}

function mostrarTemasUser() {
    window.open('mymusic.php', '_blank');
}

function mostrarLicenciasUser() {
    window.open('mylicenses.php', '_blank');
}

function mostrarArtistasUser() {
    window.open('myartists.php', '_blank');
}

fillSelectCountry();
fillSelectCategory();
deshabilitarDivsArtista();
deshabilitarDivsUser();