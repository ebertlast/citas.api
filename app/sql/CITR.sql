IF OBJECT_ID('CITR','U') IS NOT NULL DROP TABLE CITR
GO
CREATE TABLE dbo.CITR(
	CNSRESERVA VARCHAR(100) NOT NULL DEFAULT REPLACE(LEFT(NEWID(),20),'-',''),
	CONSECUTIVO VARCHAR(13) NOT NULL,
	FECHASOL DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	FECHA DATETIME NULL,
	TIPO_DOC VARCHAR(20) NOT NULL,
	IDAFILIADO VARCHAR(20) NOT NULL,
	IDSERVICIO VARCHAR(20) NULL,
	IDCONTRATANTE VARCHAR(20) NULL,
	IDMEDICO VARCHAR(12) NULL,
	IDPLAN VARCHAR(6) NULL,
	TELEFONOAVISO VARCHAR(30) NULL,
	IDEMEDICA VARCHAR(4) NULL,
	IDPLAN_AFI VARCHAR(6) NULL,
	IDTERCERO_AFI VARCHAR(20) NULL
	)
GO
ALTER TABLE CITR ADD CONSTRAINT CITRCNSRESERVA PRIMARY KEY CLUSTERED (CNSRESERVA ASC)