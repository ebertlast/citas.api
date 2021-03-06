
IF OBJECT_ID('SPK_MES','P') IS NOT NULL DROP PROCEDURE SPK_MES
GO
CREATE PROCEDURE SPK_MES
	@IDEMEDICA VARCHAR(10) = '',
	@ESTADO VARCHAR(1) = NULL --A, I
WITH ENCRYPTION
AS
BEGIN
	SELECT [IDEMEDICA]
		  ,dbo.FNK_CapitalizarTexto([DESCRIPCION]) AS DESCRIPCION
		  ,[CLASIFICADOR]
		  ,[MCITABLOQUE]
		  ,[ESTADO]
		  ,[CLASE]
		  ,[PERSONAL_AT]
		  ,[NDIASPVEZ]
	FROM [dbo].[MES]
	WHERE 1=1
	AND LEFT(ESTADO,1) = CASE WHEN ISNULL(@ESTADO,'')='' THEN LEFT(ESTADO,1) ELSE @ESTADO END
	AND IDEMEDICA=CASE WHEN ISNULL(@IDEMEDICA,'')='' THEN IDEMEDICA ELSE @IDEMEDICA END
	--AND IDEMEDICA IN (SELECT DISTINCT IDEMEDICA FROM MED)
	AND IDEMEDICA IN (SELECT DISTINCT IDEMEDICA FROM MED WHERE IDMEDICO IN (SELECT DISTINCT IDMEDICO FROM CIT))
	ORDER BY DESCRIPCION
END
GO

EXEC SPK_MES --'001'