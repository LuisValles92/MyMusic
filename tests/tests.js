var expresion_correo = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
var expresion_pass = /^(?=.*[A-Z].*[A-Z])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{7,14}$/;
var expresion_nick = /^[A-ZÑa-zñ0-9_-]{4,20}$/;
var expresion_nombre = /^([A-ZÑÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/;
var expresion_nombre_artistico = /^([A-Za-zÑÁÉÍÓÚ0-9-_]{0}[A-Za-zñáéíóú0-9-_]+[\s]*)+$/;

console.log("CORREO:");
console.log(expresion_correo.test("luisvalles92@hotmail.com")); //true
console.log(expresion_correo.test("xx@xx.xx")); //true
console.log(expresion_correo.test("xx@xx.xxx")); //true
console.log(expresion_correo.test("xx@xx.xxxx")); //true
console.log(expresion_correo.test("x@x.xx")); //true
console.log(expresion_correo.test("x@x.x")); //false
console.log(expresion_correo.test("xx@xx.")); //false
console.log(expresion_correo.test("xx@.xx")); //false
console.log(expresion_correo.test("@xx.xx")); //false
console.log(expresion_correo.test("xx.xx@")); //false
console.log(expresion_correo.test("xx.xx@.xx")); //false
console.log("\n\n");
console.log("PASSWORD:")
console.log(expresion_pass.test("OrtoN11")); //true
console.log(expresion_pass.test("antonio")); //false
console.log(expresion_pass.test("antonioantonio")); //false
console.log(expresion_pass.test("antonio28")); //false
console.log(expresion_pass.test("Antonio28")); //false
console.log(expresion_pass.test("AntoniO28")); //true
console.log(expresion_pass.test("Ant0Ni0")); //true
console.log(expresion_pass.test("Ant0Ni0antonio")); //true
console.log(expresion_pass.test("Ant0Ni0antonioo")); //false
console.log(expresion_pass.test("Ant0ni0")); //false
console.log(expresion_pass.test("Ant0Nio")); //false
console.log("\n\n");
console.log("NICK:");
console.log(expresion_nick.test("Eva3")); //true
console.log(expresion_nick.test("Eva")); //false
console.log(expresion_nick.test("LuisValles92")); //true
console.log(expresion_nick.test("Luis Valles92")); //false
console.log(expresion_nick.test("valladolidvalladolid")); //true
console.log(expresion_nick.test("valladolidvalladolidd")); //false
console.log(expresion_nick.test("Luis-Valles")); //true
console.log(expresion_nick.test("Luis_Valles")); //true
console.log(expresion_nick.test("Luis_Vallés")); //false
console.log(expresion_nick.test("Iñigo")); //true
console.log("\n\n");
console.log("NOMBRE:");
console.log(expresion_nombre.test("Iñigo Carmona")); //true
console.log(expresion_nombre.test("Luis Valles")); //true
console.log(expresion_nombre.test("Eva")); //true
console.log(expresion_nombre.test("Ev")); //true
console.log(expresion_nombre.test("luis")); //false
console.log(expresion_nombre.test("luis valles")); //false
console.log(expresion_nombre.test("Ramón Calderón")); //true
console.log(expresion_nombre.test("valladolidvalladolid")); //false
console.log(expresion_nombre.test("valladolidvalladolidd")); //false
console.log("\n\n");
console.log("NOMBRE ARTÍSTICO:");
console.log(expresion_nombre_artistico.test("eminem")); //true
console.log(expresion_nombre_artistico.test("Skylar grey")); //true
console.log(expresion_nombre_artistico.test("6ix9ine")); //true
console.log(expresion_nombre_artistico.test("Anuel AA")); //true
console.log(expresion_nombre_artistico.test("Bad")); //true
console.log(expresion_nombre_artistico.test("Nio García")); //true
console.log(expresion_nombre_artistico.test("-_Chayanne_-")); //true
console.log(expresion_nombre_artistico.test("-_Chayanne_-  ")); //true
console.log(expresion_nombre_artistico.test("Prueba Z")); //true