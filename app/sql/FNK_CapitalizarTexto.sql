IF OBJECT_ID('FNK_CapitalizarTexto')IS NOT NULL DROP FUNCTION [dbo].[FNK_CapitalizarTexto]
GO
CREATE FUNCTION [dbo].[FNK_CapitalizarTexto]
(
	--Cadena de texto que necesita ser formateado
	@String VARCHAR(MAX)--Incremente el tama�o de su variable dependiendo de su necesidad.
)
RETURNS VARCHAR(200)
AS

BEGIN
	--Declaraci�n de Variables
	DECLARE @Index INT, @ResultString VARCHAR(200)--El tama�o de la cadena devuelta debe ser igual al del la cadena de entrada '@String'
	--Initializaci�n de variables
	SET @Index = 1
	SET @ResultString = ''
	--Ejecutar el bucle hasta FINAL de la cadena
	WHILE (@Index <LEN(@string)+1)
	BEGIN
		IF (@Index = 1)--Primera letra de la cadena
		BEGIN
			--Capitalizar la primera letra
			SET @ResultString = @ResultString + UPPER(SUBSTRING(@string, @Index, 1))
			SET @Index = @Index+ 1--Aumentar el indice
		END
		-- Si el car�cter anterior es espacio o '-' o el siguiente car�cter es '-'
		ELSE IF ((SUBSTRING(@string, @Index-1, 1) =' 'or SUBSTRING(@string, @Index-1, 1) ='-' or SUBSTRING(@string, @Index+1, 1) ='-') and @Index+1 <> LEN(@string))
		BEGIN
			SET @ResultString = @ResultString + UPPER(SUBSTRING(@string,@Index, 1))
			SET @Index = @Index +1--Aumentar el indice
		END
		ELSE-- Cualquier otro caracter
		BEGIN
			-- Minusculas
			SET @ResultString = @ResultString + LOWER(SUBSTRING(@string,@Index, 1))
			SET @Index = @Index +1--Aumentar el indice
		END
	END--Fin del While

	IF (@@ERROR <> 0)-- Se produce cualquier error devuelve la cadena que se recibi�
	BEGIN
		SET @ResultString = @string
	END
	-- Si ningun error ha sido encontrado devuelve la cadeba nueva
	RETURN @ResultString
END

GO


SELECT [dbo].[FNK_CapitalizarTexto]('el CARRO corre duro POR LA cArReTeRa del ferroCARRIL')