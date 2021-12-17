CREATE TABLE usuarios (
	idusuario tinyint PRIMARY KEY  AUTO_INCREMENT,
	correo varchar(50) NOT NULL UNIQUE,
	clave varchar(255) NOT NULL
);
CREATE TABLE minijuegos (
	idminijuego tinyint PRIMARY KEY  AUTO_INCREMENT,
	nombre varchar(50) NOT NULL,
	preferencia varchar(200)  NULL
);
CREATE TABLE preferencias (
	idminijuego tinyint NOT NULL,
	idusuario tinyint NOT NULL,
	preferencia varchar(200) NOT NULL,
	PRIMARY KEY (idusuario, idminijuego, preferencia),
	CONSTRAINT FK_iduser FOREIGN KEY (idusuario) REFERENCES usuarios(idusuario),
	CONSTRAINT FK_idgame FOREIGN KEY (idminijuego) REFERENCES minijuegos(idminijuego)
);
