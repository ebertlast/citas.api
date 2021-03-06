IF OBJECT_ID('SPK_USUSUW','P') IS NOT NULL DROP PROCEDURE SPK_USUSUW
GO
CREATE PROCEDURE SPK_USUSUW 
	@ACTION VARCHAR(1) = 'R' -- C,R,U,D,A
	,@USUARIO VARCHAR(100) = NULL
	,@CLAVE VARCHAR(50) = NULL
	,@EMAIL VARCHAR(50) = NULL
	,@ACTIVO BIT = NULL
	,@TIPO_DOC VARCHAR(20) = NULL
	,@IDAFILIADO VARCHAR(20) = NULL
	,@KEYACTIVATE VARCHAR(50) = NULL
WITH ENCRYPTION
AS
DECLARE @SQL AS NVARCHAR(MAX)
BEGIN
	IF @ACTION = 'C'
	BEGIN
		IF ISNULL(@USUARIO,'')='' OR ISNULL(@EMAIL,'')='' 
		BEGIN	
			RAISERROR ('Parámetros incompletos.', -- Message text.  
				   16, -- Severity.  
				   1 -- State.  
				   );  
			RETURN
		END
		INSERT INTO USUSUW(USUARIO,EMAIL,ACTIVO,FECHAACTIVO,IDAFILIADO,TIPO_DOC,CLAVE)
		SELECT @USUARIO,@EMAIL,ISNULL(@ACTIVO,0), CASE WHEN ISNULL(@ACTIVO,0)=1 THEN GETDATE() ELSE NULL END, @IDAFILIADO,@TIPO_DOC, CONVERT(VARCHAR(32), HashBytes('MD5', @CLAVE), 2)

		SELECT KEYACTIVATE FROM USUSUW WHERE USUARIO=@USUARIO
	END

	IF @ACTION = 'R'
	BEGIN
		SET @SQL = 'SELECT * FROM USUSUW WHERE 1=1 '
		IF ISNULL(@USUARIO,'')<>'' SET @SQL=@SQL+' AND USUARIO = '''+@USUARIO+''''
		IF @ACTIVO <> NULL SET @SQL=@SQL+' AND ACTIVO = ' + CAST(@ACTIVO AS VARCHAR)
		IF ISNULL(@TIPO_DOC,'')<>'' SET @SQL=@SQL+' AND TIPO_DOC = '''+@TIPO_DOC+''''
		IF ISNULL(@IDAFILIADO,'')<>'' SET @SQL=@SQL+' AND IDAFILIADO = '''+@IDAFILIADO+''''
		IF ISNULL(@CLAVE,'')<>'' SET @SQL=@SQL+' AND CLAVE=CONVERT(VARCHAR(32), HashBytes(''MD5'', '''+@CLAVE+'''), 2)'
		--PRINT @SQL
		EXECUTE sp_executesql @SQL
	END

	IF @ACTION = 'U'
	BEGIN
		IF ISNULL(@USUARIO,'')='' OR ISNULL(@EMAIL,'')='' 
		BEGIN	
			RAISERROR ('Parámetros incompletos.', -- Message text.  
				   16, -- Severity.  
				   1 -- State.  
				   );  
			RETURN
		END
		UPDATE USUSUW SET EMAIL=@EMAIL,ACTIVO=@ACTIVO,FECHAACTIVO=CASE WHEN ISNULL(@ACTIVO,0)=1 THEN GETDATE() ELSE FECHAACTIVO END,IDAFILIADO = CASE WHEN ISNULL(@IDAFILIADO,'')=1 THEN @IDAFILIADO ELSE IDAFILIADO END,CLAVE=CONVERT(VARCHAR(32), HashBytes('MD5', @CLAVE), 2)
	END

	IF @ACTION = 'D'
	BEGIN
		IF ISNULL(@USUARIO,'')='' AND ISNULL(@EMAIL,'')='' 
		BEGIN	
			RAISERROR ('Parámetros incompletos.', -- Message text.  
				   16, -- Severity.  
				   1 -- State.  
				   );  
			RETURN
		END	
		DELETE FROM USUSUW 
		WHERE	USUARIO = CASE WHEN ISNULL(@USUARIO,'')='' THEN USUARIO ELSE @USUARIO END 
		AND		EMAIL = CASE WHEN ISNULL(@EMAIL,'')='' THEN EMAIL ELSE @EMAIL END
		AND		TIPO_DOC = CASE WHEN ISNULL(@TIPO_DOC,'')='' THEN TIPO_DOC ELSE @TIPO_DOC END
		AND		IDAFILIADO = CASE WHEN ISNULL(@IDAFILIADO,'')='' THEN IDAFILIADO ELSE @IDAFILIADO END
	END
	IF @ACTION = 'A'
	BEGIN
		UPDATE USUSUW SET ACTIVO=1, FECHAACTIVO=GETDATE() WHERE USUARIO=@USUARIO AND KEYACTIVATE=@KEYACTIVATE
	END
END
GO

--EXEC SPK_USUSUW @ACTION='R', @TIPO_DOC='CE', @IDAFILIADO='690989'
EXEC SPK_USUSUW @ACTION='R', @USUARIO='ebertunerg@gmail.com', @CLAVE='enclave'

