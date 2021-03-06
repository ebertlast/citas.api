IF OBJECT_ID('SPK_PLN','P') IS NOT NULL DROP PROCEDURE SPK_PLN
GO
CREATE PROCEDURE SPK_PLN
	@IDTERCERO VARCHAR(20) = NULL,
	@IDCATEGORIA VARCHAR(20) = NULL
WITH ENCRYPTION
AS
BEGIN
	
	SELECT * FROM PLN 
	WHERE IDPLAN IN (
		SELECT DISTINCT IDPLAN 
		FROM PPT 
		WHERE IDTERCERO IN 
			(SELECT IDTERCERO 
			FROM TEXCA 
			WHERE IDCATEGORIA = CASE WHEN ISNULL(@IDCATEGORIA,'')='' THEN IDCATEGORIA ELSE @IDCATEGORIA END
		)
		AND IDTERCERO = CASE WHEN ISNULL(@IDTERCERO,'')='' THEN IDTERCERO ELSE @IDTERCERO END

	)
	AND ESTADO='ACTIVO'
	ORDER BY DESCPLAN
END
GO

EXEC SPK_PLN --'','CON'