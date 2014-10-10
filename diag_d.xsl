<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output encoding="iso-8859-1"/>
	<xsl:include href="balises.xsl"/>
	<xsl:template match="diagnostic">
		<html>
			<head>
				<title>Diagnostic</title>
			</head>
			<body>
				<xsl:apply-templates select="exercice"/>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="exercice">
		<table width="80%" border="0" align="center">
			<tr>
				<td height="75">
					<table width="90%" border="2" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bgcolor="#FFFF99">
						<tr>
							<td width="60%">
								<xsl:copy-of select="enonce"/>
							</td>
							<td width="40%">
								<xsl:copy-of select="reponse"/>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<xsl:value-of select="nom"/>
					<xsl:value-of select="resolution"/>.<br/>
					<xsl:apply-templates/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="enonce"/>
	<xsl:template match="reponse"/>
	<xsl:template match="nom"/>
	<xsl:template match="resolution"/>
	<xsl:template match="prenom">
		<xsl:choose>
			<xsl:when test="@col1!=9">
				<xsl:value-of select="."/> a proc�d� de la mani�re suivante :<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="nbOper">
		<xsl:choose>
			<xsl:when test="@nbOper>1 and @calImp=0">Sa r�solution s'est faite en <xsl:value-of select="."/> calculs explicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper>1 and @calImp=1">Sa r�solution s'est faite en <xsl:value-of select="."/> calculs explicites et un ou plusieurs calculs implicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=1 and @calImp=0">Sa r�solution s'est faite en <xsl:value-of select="."/> calcul explicite.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=1 and @calImp=1">Sa r�solution s'est faite en <xsl:value-of select="."/> calcul explicite et un ou plusieurs calculs implicites.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @sexe='f' and @col1!=9">Elle n'a pas pos� d'op�rations.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @sexe='m' and @col1!=9">Il n'a pas pos� d'op�rations.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="fact"/>
	<xsl:template match="strategie">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@typeStr='D'">Il a effectu� un d�veloppement. Plus pr�cis�ment, son d�veloppement </xsl:when>
				<xsl:when test="@typeStr='F'">Il a effectu� une factorisation. Plus pr�cis�ment, sa factorisation </xsl:when>
				<xsl:when test="@typeStr='RA'">Il a utilis� un raisonnement correct mais atypique. Son raisonnement </xsl:when>
				<xsl:when test="@typeStr='RI'">Il a fait un raisonnement incomplet. Il a</xsl:when>
				<xsl:when test="@typeStr='ER'">Il a </xsl:when>
				<xsl:when test="@typeStr='PR'"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@typeStr='D'">Elle a effectu� un d�veloppement. Plus pr�cis�ment son d�veloppement </xsl:when>
				<xsl:when test="@typeStr='F'">Elle a effectu� une factorisation. Plus pr�cis�ment sa factorisation </xsl:when>
				<xsl:when test="@typeStr='RA'">Elle a utilis� un raisonnement  mais atypique. Son raisonnement </xsl:when>
				<xsl:when test="@typeStr='RI'">Elle a fait un raisonnement incomplet. Elle a</xsl:when>
				<xsl:when test="@typeStr='ER'">Elle a </xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:choose>
			<xsl:when test="@str='D' or @str='F' ">est de la forme classique, en deux �tapes :<br/>
			</xsl:when>
			<xsl:when test="@str='Dc' or @str='Fc' ">est de la forme classique, en une seule �tape :<br/>
			</xsl:when>
			<xsl:when test="@str='Fe' and @imp='1'">
				est sous forme d'additions successives des diff�rents termes de la somme : 
				<xsl:if test="@sexe='m'">
					Il a d'abord additionn� de mani�re implicite les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					il a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
				<xsl:if test="@sexe='f'">
					Elle a d'abord additionn� de mani�re implicite les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					elle a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
			</xsl:when>
			<xsl:when test="@str='Fe'">
				est sous forme d'additions successives des diff�rents termes de la somme : 
				<xsl:if test="@sexe='m'">
					Il a d'abord additionn� les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					il a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
				<xsl:if test="@sexe='f'">
					Elle a d'abord additionn� les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					elle a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
			</xsl:when>
			<xsl:when test="@str='Fe2' ">
				est sous forme d'additions successives des diff�rents termes de la somme :
				<xsl:if test="@sexe='m'">
					Il a d'abord additionn� les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					il a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
				<xsl:if test="@sexe='f'">
					Elle a d'abord additionn� les termes de la somme (<xsl:value-of select="./valSomme"/>), ensuite 
					elle a additionn� cette valeur autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
				</xsl:if>
			</xsl:when>
			<xsl:when test="@str='De' ">
					est sous forme d'additions successives des diff�rents termes de la somme (<xsl:value-of select="./valSomme"/>) 
					autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='De2' ">
				est sous forme d'addition successive du facteur (<xsl:value-of select="./facteur"/>) 
				autant de fois que les termes de la somme (<xsl:value-of select="./valSomme"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='De2' ">
				est sous forme d'addition successive du facteur (<xsl:value-of select="./facteur"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='Em' ">
				se rapproche de la factorisation,  
				<xsl:if test="@sexe='m'">il</xsl:if>
				<xsl:if test="@sexe='f'">elle</xsl:if>			
				est sous forme d'additions successives des termes de la somme (<xsl:value-of select="./valSomme"/>)
				autant de fois que la valeur du facteur (<xsl:value-of select="./facteur"/>)<br/>
			</xsl:when>
			<xsl:when test="@str='Ed' ">
				est sous forme d'addition successive du facteur (<xsl:value-of select="./facteur"/>) 
				autant de fois que la somme des termes de la somme (<xsl:value-of select="./sommeVal"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='Ea' ">
				est sous forme de cumul du facteur (<xsl:value-of select="./facteur"/>)  
				autant de fois que la somme des termes de la somme (<xsl:value-of select="./valSomme"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='Ej' ">
				est sous forme d'addition successive du facteur (<xsl:value-of select="./facteur"/>), 
				et cumul�es avec le r�sultat pr�c�dent :<br/>
			</xsl:when>
			<xsl:when test="@str='At' ">
				additionn� tous les termes de l'�nonc� (<xsl:value-of select="./facteur"/>, <xsl:value-of select="./valSomme"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='M' ">
				multipli� le facteur (<xsl:value-of select="./facteur"/>) par le nombre de termes sommables (<xsl:value-of select="./nbVal"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='M2' ">
				fait un d�veloppement erron� avec une erreur dans le facteur. 
				<xsl:if test="@sexe='m'">Il</xsl:if>
				<xsl:if test="@sexe='f'">Elle</xsl:if>
				a confondu le facteur avec le plus petit �l�ment des termes de la somme (<xsl:value-of select="./minVal"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='M3' ">
				fait un d�veloppement erron� avec une erreur dans le facteur. 
				<xsl:if test="@sexe='m'">Il</xsl:if>
				<xsl:if test="@sexe='f'">Elle</xsl:if>
				a confondu le facteur avec le nombre de termes sommables (<xsl:value-of select="./nbVal"/>) :<br/>
			</xsl:when>
			<xsl:when test="@str='A' ">
				fait une addition des termes de la somme (<xsl:value-of select="./valSomme"/>) : <br/>
			</xsl:when>
			<xsl:when test="@str='Di' ">
				fait un d�veloppement incomplet  : <br/>
			</xsl:when>
			<xsl:when test="@str='N' ">
				fait une erreur unique . <br/>
			</xsl:when>
            <xsl:when test="@imp='3' ">
				<xsl:if test="@sexe='m'">Il </xsl:if>
				<xsl:if test="@sexe='f'">Elle </xsl:if>
                n'a pas pos� d'op�ration.<br/>
			</xsl:when>
            <xsl:when test="@str='impf' ">
				<xsl:if test="@sexe='m'">Il </xsl:if>
				<xsl:if test="@sexe='f'">Elle </xsl:if>
                n'a pas pos� d'op�ration.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="calImp">
		<xsl:choose>
			<xsl:when test="@imp='1' ">
				Le calcul interm�diaire est calcul� de mani�re implicite<br/>
			</xsl:when>
			<xsl:when test="@imp='2' ">
				Le calcul final est caclul� de mani�re implicite<br/>
			</xsl:when>
			<xsl:when test="@imp='3' ">
				Le calcul interm�diaire et le calcul final sont calcul�s de mani�re implicite<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="operation">
		<xsl:copy-of select="."/>
	</xsl:template>
	<xsl:template match="errAdd">
		<xsl:if test="@sexe='m'">Il a fait une erreur d'addition dans <xsl:value-of select="."/>
		</xsl:if>
		<xsl:if test="@sexe='f'">Elle a fait une erreur d'addition dans <xsl:value-of select="."/>
		</xsl:if>
	</xsl:template>
	<xsl:template match="errMult">
		<xsl:if test="@sexe='m'">Il a fait une erreur de multiplication dans <xsl:value-of select="."/>
		</xsl:if>
		<xsl:if test="@sexe='f'">Elle a fait une erreur de multiplication dans <xsl:value-of select="."/>
		</xsl:if>
	</xsl:template>
	<xsl:template match="errCal">
		<xsl:if test="@sexe='m'"> Il a fait une <xsl:value-of select="."/>.</xsl:if>
		<xsl:if test="@sexe='f'"> Elle a fait une <xsl:value-of select="."/>.</xsl:if>
	</xsl:template>
	<xsl:template match="errAddMul">
		<xsl:if test="@sexe='m'">Il a fait <xsl:value-of select="."/>
		</xsl:if>
		<xsl:if test="@sexe='f'">Elle a fait <xsl:value-of select="."/>
		</xsl:if>
	</xsl:template>
	<xsl:template match="errPos"> (<xsl:value-of select="."/>).</xsl:template>
</xsl:stylesheet>
