IF OBJECT_ID('SPK_TGEN','P') IS NOT NULL DROP PROCEDURE SPK_TGEN
GO
CREATE PROCEDURE SPK_TGEN
	@TABLA VARCHAR(15) = NULL
	,@CAMPO VARCHAR(20) = NULL
	,@CODIGO VARCHAR(20) = NULL
WITH ENCRYPTION
AS
DECLARE @SQL AS NVARCHAR(MAX)

BEGIN
	SET @SQL = 'SELECT * FROM TGEN WHERE 1=1 '
	IF ISNULL(@TABLA,'')<>'' SET @SQL=@SQL+' AND TABLA = '''+@TABLA+''''
	IF ISNULL(@CAMPO,'')<>'' SET @SQL=@SQL+' AND CAMPO = '''+@CAMPO+''''
	IF ISNULL(@CODIGO,'')<>'' SET @SQL=@SQL+' AND CODIGO = '''+@CODIGO+''''
		
	EXECUTE sp_executesql @SQL
END
GO

--EXEC SPK_TGEN 'GENERAL', 'TIPOIDENT' 
