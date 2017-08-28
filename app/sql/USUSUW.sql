IF OBJECT_ID('USUSUW','U') IS NOT NULL DROP TABLE USUSUW
GO
CREATE TABLE USUSUW(
	USUARIO VARCHAR(100) NOT NULL,
	EMAIL VARCHAR(50) NOT NULL,
	ACTIVO BIT DEFAULT 0, 
	FECHAREGISTRO DATETIME DEFAULT CURRENT_TIMESTAMP,
	FECHAACTIVO DATETIME DEFAULT NULL,
	TIPODOCUMENTO VARCHAR(10) DEFAULT NULL,
	IDAFILIADO VARCHAR(20) DEFAULT NULL
	)
GO
ALTER TABLE USUSUW ADD CONSTRAINT USUSUWUSUARIO PRIMARY KEY (USUARIO)
GO
ALTER TABLE USUSUW ADD CONSTRAINT USUSUWEMAIL UNIQUE(EMAIL)
GO
ALTER TABLE USUSUW ADD CONSTRAINT USUSUWTIPODOCUMENTOIDAFILIADO UNIQUE(TIPODOCUMENTO,IDAFILIADO)
