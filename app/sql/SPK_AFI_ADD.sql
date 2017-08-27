IF OBJECT_ID('SPK_AFI_ADD','P') IS NOT NULL DROP PROCEDURE SPK_AFI_ADD
GO
CREATE PROCEDURE SPK_AFI_ADD
	@IDAFILIADO varchar(20),
	@PAPELLIDO varchar(30),
	@SAPELLIDO varchar(30),
	@PNOMBRE varchar(30),
	@SNOMBRE varchar(30),
	@TIPO_DOC varchar(3),
	@DOCIDAFILIADO varchar(20),
	@IDALTERNA varchar(20),
	@IDAFILIADOPPAL varchar(20),
	@GRUPO_SANG varchar(5),
	@ESTADO_CIVIL varchar(15),
	@GRUPOETNICO varchar(1),
	@SEXO varchar(9),
	@IDPARENTESCO varchar(1),
	@LOCALIDAD varchar(50),
	@DIRECCION varchar(100),
	@TELEFONORES varchar(15),
	@CIUDAD varchar(5),
	@ZONA varchar(12),
	@CODENTIDADANTERIOR varchar(20),
	@ESTADO varchar(12),
	@FECHAULTESTADO datetime,
	@IDSEDE varchar(5),
	@IDPROVEEDOR varchar(20),
	@FNACIMIENTO datetime,
	@FECHAAFILSGSSS datetime,
	@ACT_ECONO varchar(4),
	@IDESCOLARIDAD varchar(3),
	@INDCOTIZANTE smallint,
	@ULTIMOANOAPROBADO varchar(2),
	@INCAPACIDADLABORAL varchar(2),
	@TIPODISCAPACIDAD varchar(1),
	@TIPOAFILIADO varchar(1),
	@GRUPOATESPECIAL varchar(1),
	@CABEZADEFAMILIA varchar(2),
	@ASOCIADO varchar(2),
	@TIENEOBS smallint,
	@CAMPOUSUARIO1 varchar(20),
	@FECHAUVISITA datetime,
	@CONSANGUINIDAD varchar(1),
	@IDADMINISTRADORA varchar(20),
	@IDCAUSAL varchar(5),
	@FECHACAUSAL datetime,
	@CLASIFPC varchar(5),
	@NIVELSOCIOEC varchar(2),
	@IDPLAN varchar(6),
	@FECHAAFILIACION datetime,
	@NUMCARNET varchar(20),
	@CIUDADDOC varchar(5),
	@IDEMPLEADOR varchar(20),
	@SEMANASCOT smallint,
	@CARNETIZADO smallint,
	@FECHACARNET datetime,
	@CONSCERTIFICADO varchar(16),
	@CIUDADNAC varchar(5),
	@IDOCUPACION varchar(5),
	@NACIONALIDAD varchar(40),
	@CELULAR varchar(20),
	@DIRECCIONLAB varchar(100),
	@TELEFONOLAB varchar(20),
	@CNSAFIAA varchar(16),
	@SISBENNUMFICHA varchar(20),
	@SISBENFECHAFICHA datetime,
	@SISBENPUNTAJE int,
	@SISBENNUCLEOFAM varchar(20),
	@SISBENGRUPOB varchar(1),
	@IDCONTRATO varchar(20),
	@IDBARRIO varchar(20),
	@CLASEAFILIACIONARS varchar(2),
	@FORMULARIO varchar(20),
	@EMAIL varchar(99),
	@NORADICACION varchar(20),
	@FECHARADICACION datetime,
	@IDTIPOAFILIACION varchar(20),
	@IDCLASEAFILIACION varchar(20),
	@V_FORMULARIO varchar(20),
	@SISBENNIVEL varchar(1),
	@CNSXCPA varchar(20),
	@FESTADO datetime,
	@OKBD smallint,
	@USUARIOBD varchar(12),
	@NACIMIENTO smallint,
	@ITFC smallint,
	@CNSITFC varchar(20),
	@TIPOSUBSIDIO varchar(1),
	@COBERTURA_SALUD varchar(50),
	@TIPOAFILIADO2 varchar(1),
	@IDAFI_TITULAR varchar(20),
	@ES_NN smallint,
	@IDESPECIAL varchar(20),
	@MTRIAGE smallint,
	@FTRIAGE datetime,
	@GRUPOPOB varchar(20),
	@IDSEDETRIAGE smallint,
	@F_ACTUALIZA datetime,
	@PRIORIDAD SMALLINT = NULL
WITH ENCRYPTION
AS
BEGIN
	SET  @FECHAAFILIACION = GETDATE()
	
	INSERT INTO [dbo].[AFI]
           ([IDAFILIADO]
           ,[PAPELLIDO]
           ,[SAPELLIDO]
           ,[PNOMBRE]
           ,[SNOMBRE]
           ,[TIPO_DOC]
           ,[DOCIDAFILIADO]
           ,[IDALTERNA]
           ,[IDAFILIADOPPAL]
           ,[GRUPO_SANG]
           ,[ESTADO_CIVIL]
           ,[GRUPOETNICO]
           ,[SEXO]
           ,[IDPARENTESCO]
           ,[LOCALIDAD]
           ,[DIRECCION]
           ,[TELEFONORES]
           ,[CIUDAD]
           ,[ZONA]
           ,[CODENTIDADANTERIOR]
           ,[ESTADO]
           ,[FECHAULTESTADO]
           ,[IDSEDE]
           ,[IDPROVEEDOR]
           ,[FNACIMIENTO]
           ,[FECHAAFILSGSSS]
           ,[ACT_ECONO]
           ,[IDESCOLARIDAD]
           ,[INDCOTIZANTE]
           ,[ULTIMOANOAPROBADO]
           ,[INCAPACIDADLABORAL]
           ,[TIPODISCAPACIDAD]
           ,[TIPOAFILIADO]
           ,[GRUPOATESPECIAL]
           ,[CABEZADEFAMILIA]
           ,[ASOCIADO]
           ,[TIENEOBS]
           ,[CAMPOUSUARIO1]
           ,[FECHAUVISITA]
           ,[CONSANGUINIDAD]
           ,[IDADMINISTRADORA]
           ,[IDCAUSAL]
           ,[FECHACAUSAL]
           ,[CLASIFPC]
           ,[NIVELSOCIOEC]
           ,[IDPLAN]
           ,[FECHAAFILIACION]
           ,[NUMCARNET]
           ,[CIUDADDOC]
           ,[IDEMPLEADOR]
           ,[SEMANASCOT]
           ,[CARNETIZADO]
           ,[FECHACARNET]
           ,[CONSCERTIFICADO]
           ,[CIUDADNAC]
           ,[IDOCUPACION]
           ,[NACIONALIDAD]
           ,[CELULAR]
           ,[DIRECCIONLAB]
           ,[TELEFONOLAB]
           ,[CNSAFIAA]
           ,[SISBENNUMFICHA]
           ,[SISBENFECHAFICHA]
           ,[SISBENPUNTAJE]
           ,[SISBENNUCLEOFAM]
           ,[SISBENGRUPOB]
           ,[IDCONTRATO]
           ,[IDBARRIO]
           ,[CLASEAFILIACIONARS]
           ,[FORMULARIO]
           ,[EMAIL]
           ,[NORADICACION]
           ,[FECHARADICACION]
           ,[IDTIPOAFILIACION]
           ,[IDCLASEAFILIACION]
           ,[V_FORMULARIO]
           ,[SISBENNIVEL]
           ,[CNSXCPA]
           ,[FESTADO]
           ,[OKBD]
           ,[USUARIOBD]
           ,[NACIMIENTO]
           ,[ITFC]
           ,[CNSITFC]
           ,[TIPOSUBSIDIO]
           ,[COBERTURA_SALUD]
           ,[TIPOAFILIADO2]
           ,[IDAFI_TITULAR]
           ,[ES_NN]
           ,[IDESPECIAL]
           ,[MTRIAGE]
           ,[FTRIAGE]
           ,[GRUPOPOB]
           ,[IDSEDETRIAGE]
           ,[F_ACTUALIZA]
           ,[PRIORIDAD])
     VALUES
           (@IDAFILIADO
           ,@PAPELLIDO
           ,@SAPELLIDO
           ,@PNOMBRE
           ,@SNOMBRE
           ,@TIPO_DOC
           ,@DOCIDAFILIADO
           ,@IDALTERNA
           ,@IDAFILIADOPPAL
           ,@GRUPO_SANG
           ,@ESTADO_CIVIL
           ,@GRUPOETNICO
           ,@SEXO
           ,@IDPARENTESCO
           ,@LOCALIDAD
           ,@DIRECCION
           ,@TELEFONORES
           ,@CIUDAD
           ,@ZONA
           ,@CODENTIDADANTERIOR
           ,@ESTADO
           ,@FECHAULTESTADO
           ,@IDSEDE
           ,@IDPROVEEDOR
           ,@FNACIMIENTO
           ,@FECHAAFILSGSSS
           ,@ACT_ECONO
           ,@IDESCOLARIDAD
           ,@INDCOTIZANTE
           ,@ULTIMOANOAPROBADO
           ,@INCAPACIDADLABORAL
           ,@TIPODISCAPACIDAD
           ,@TIPOAFILIADO
           ,@GRUPOATESPECIAL
           ,@CABEZADEFAMILIA
           ,@ASOCIADO
           ,@TIENEOBS
           ,@CAMPOUSUARIO1
           ,@FECHAUVISITA
           ,@CONSANGUINIDAD
           ,@IDADMINISTRADORA
           ,@IDCAUSAL
           ,@FECHACAUSAL
           ,@CLASIFPC
           ,@NIVELSOCIOEC
           ,@IDPLAN
           ,@FECHAAFILIACION
           ,@NUMCARNET
           ,@CIUDADDOC
           ,@IDEMPLEADOR
           ,@SEMANASCOT
           ,@CARNETIZADO
           ,@FECHACARNET
           ,@CONSCERTIFICADO
           ,@CIUDADNAC
           ,@IDOCUPACION
           ,@NACIONALIDAD
           ,@CELULAR
           ,@DIRECCIONLAB
           ,@TELEFONOLAB
           ,@CNSAFIAA
           ,@SISBENNUMFICHA
           ,@SISBENFECHAFICHA
           ,@SISBENPUNTAJE
           ,@SISBENNUCLEOFAM
           ,@SISBENGRUPOB
           ,@IDCONTRATO
           ,@IDBARRIO
           ,@CLASEAFILIACIONARS
           ,@FORMULARIO
           ,@EMAIL
           ,@NORADICACION
           ,@FECHARADICACION
           ,@IDTIPOAFILIACION
           ,@IDCLASEAFILIACION
           ,@V_FORMULARIO
           ,@SISBENNIVEL
           ,@CNSXCPA
           ,@FESTADO
           ,@OKBD
           ,@USUARIOBD
           ,@NACIMIENTO
           ,@ITFC
           ,@CNSITFC
           ,@TIPOSUBSIDIO
           ,@COBERTURA_SALUD
           ,@TIPOAFILIADO2
           ,@IDAFI_TITULAR
           ,@ES_NN
           ,@IDESPECIAL
           ,@MTRIAGE
           ,@FTRIAGE
           ,@GRUPOPOB
           ,@IDSEDETRIAGE
           ,@F_ACTUALIZA
           ,@PRIORIDAD)
	


END
GO
