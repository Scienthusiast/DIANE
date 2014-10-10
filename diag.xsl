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
							<td>
								<xsl:copy-of select="enonce"/>
							</td>
							<td>
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
			<xsl:when test="@nbOper=0 and @sexe='f' and @col1!=9">Elle n'a pas pos� d'op�ration.<br/>
			</xsl:when>
			<xsl:when test="@nbOper=0 and @sexe='m' and @col1!=9">Il n'a pas pos� d'op�ration.<br/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne1">
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=1">Cette �l�ve a calcul� la partie manquante en faisant </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='p' and @col16=0">Cette �l�ve a calcul� l'�cart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='t' and @col16=0">Cette �l�ve a calcul� l'�cart entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur de la partie finale (<xsl:value-of select="partie3"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=0">Cette �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=0">Cette �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=4">Cette �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. 
				</xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=4">
				Cette �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. 
				</xsl:when>
				<xsl:when test="@code=3">Cette �l�ve a calcul� la partie manquante en faisant </xsl:when>
				<xsl:when test="@code=4 and @nbOper>1 and @col2!=9">Cette �l�ve a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2=9"/>
				<xsl:when test="@code=4 and @nbOper=1 and @col2!=9"> Cette �l�ve a fait </xsl:when>
				<xsl:when test="@code=5"> Elle a utilis� une strat�gie non identifi�e qui l'a </xsl:when>
				<xsl:when test="@code=6"> Elle a effectu� des calculs mentaux non identifi�s. </xsl:when>
				<xsl:when test="@code=7"> Cette �l�ve a r�alis� l'op�ration de comparaison </xsl:when>
				<xsl:otherwise/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=1">Cet �l�ve a calcul� la partie manquante, en faisant </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='p' and @col16=0">Cet �l�ve a calcul� l'�cart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='e' and @q='t' and @col16=0">Cet �l�ve a calcul� l'�cart entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur de la partie finale (<xsl:value-of select="partie3"/>) </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=0">Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=0">Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. </xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='p' and @col16=4">
				Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. 
				</xsl:when>
				<xsl:when test="@code=2 and @type='a' and @q='t' and @col16=4">
				Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. 
				</xsl:when>
				<xsl:when test="@code=3">Cet �l�ve a calcul� la partie manquante, en faisant </xsl:when>
				<xsl:when test="@code=4 and @nbOper>=1 and @col2!=9">Cet �l�ve a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2!=9">Cet �l�ve a fait </xsl:when>
				<xsl:when test="@code=4 and @nbOper=1 and @col2=9"/>
				<xsl:when test="@code=5"> Il a utilis� une strat�gie non identifi�e qui l'a </xsl:when>
				<xsl:when test="@code=6"> Il a effectu� des calculs mentaux non identifi�s. </xsl:when>
				<xsl:when test="@code=7"> Cet �l�ve a r�alis� l'op�ration de comparaison, </xsl:when>
				<xsl:otherwise/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne2">
		<xsl:choose>
			<xsl:when test="@code='0' and @col1=6 and @sexe='m'">
				<br/>Cet �l�ve a calcul� la partie manquante, en faisant le calcul de mani�re implicite. </xsl:when>
			<xsl:when test="@code='0' and @col1=6 and @sexe='f'">
				<br/>Cette �l�ve a calcul� la partie manquante, en faisant  le calcul de mani�re implicite. </xsl:when>
			<xsl:when test="@code='0'">le calcul de mani�re implicite. </xsl:when>
			<xsl:when test="@code='1' or @code='2' or @code='20' or @code='3' or @code='7'"> une <xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=4">une <xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code=5">un calcul erron� <xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=61">une addition de tous les termes de l'�nonc� <xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=61">un calcul erron� <xsl:value-of select="op"/>.</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne4">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> Il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> Elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> Elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne3">
		<xsl:choose>
			<xsl:when test="@code=0 and @col2=4"> Le r�sultat de cette op�ration n'a pas de sens relativement � l'�nonc�. </xsl:when>
			<xsl:when test="@code=1 and @col1=4 and @col2=2"> Le r�sultat de cette op�ration n'a pas de sens relativement � l'�nonc�. </xsl:when>
			<!-- <xsl:when test="@code=1">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>-->
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne6">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2=9"><br/>Il a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>				
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2!=9"><br/>En outre, il a r�alis� l'op�ration de comparaison � partir de calculs mentaux </xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col2=9)">Il a r�alis� l'op�ration de comparaison par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=9">Il a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=0"><br/>Pour le calcul final, il a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @str='7' and @col14!=9">� partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9 and @col2=9">Il a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9"><br/>En outre, il a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col7=1)"><br/>En outre, il a fait une op�ration de comparaison reposant sur des donn�es erron�es. Il a utilis� une <xsl:value-of select="."/><xsl:text>et </xsl:text></xsl:when>
				<xsl:when test="@code='1' or @code='2' or @code='21'or @code='3' or @code='4' or @code='7'"><br/>En outre, il a r�alis� l'op�ration de comparaison par une <xsl:value-of select="."/></xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2=9"><br/>Elle a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>	
				<xsl:when test="@code='0' and @nbOper=0 and @col14!=9 and @col2!=9">	<br/>En outre, elle a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col2=9)">Elle a r�alis� l'op�ration de comparaison par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=9">Elle a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @nbOper=0 and @col14=9 and @col2=0"><br/>Pour le calcul final, elle a fait un calcul implicite qui correspond au calcul de la comparaison</xsl:when>
				<xsl:when test="@code='0' and @str='7' and @col14!=9">� partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9 and @col2=9">Elle a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
				<xsl:when test="@code='0' and @col14!=9"><br/>En outre, elle a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/></xsl:when>
				<xsl:when test="(@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7') and (@col7=1)">
					<br/>En outre, elle a fait une op�ration de comparaison reposant sur des donn�es erron�es. Elle a utilis� une <xsl:value-of select="."/>
					<xsl:text>et </xsl:text>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2' or @code='21' or @code='3' or @code='4' or @code='7'">
					<br/>En outre, elle a r�alis� l'op�ration de comparaison par une <xsl:value-of select="."/>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne7">
		<!-- <xsl:choose>
            <xsl:when test="@code=0">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=1">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>
        </xsl:choose>-->
	</xsl:template>
	<xsl:template match="colonne8">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0' and @col14!=9">, il a trouv� un r�sultat de calcul correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='0' and @col14=9 and @col2=9">, le r�sultat du calcul est correct <xsl:value-of select="res"/>. Mais, son calcul ne correspond pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='0' and @col14=9"><xsl:value-of select="res"/>, mais pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='1' or @code='2'">, il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="@code='8'">.</xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0' and @col14!=9">, elle a trouv� un r�sultat de calcul correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='0' and @col14=9 and @col2=9">, le r�sultat du calcul est correct <xsl:value-of select="res"/>. Mais, son calcul ne correspond pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='0' and @col14=9"><xsl:value-of select="res"/>, mais pas au calcul final attendu.</xsl:when>
				<xsl:when test="@code='1' or @code='2'">, elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="@code='8'">.</xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne10">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> de mani�re implicite</xsl:when>
				<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/>, il a utilis� un calcul <xsl:value-of select="."/>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2'">. Il a utilis� une <xsl:value-of select="."/>
					<xsl:text>, </xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> de mani�re implicite</xsl:when>
				<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/>, elle a utilis� un calcul <xsl:value-of select="."/>
				</xsl:when>
				<xsl:when test="@code='1' or @code='2'">. Elle a utilis� une <xsl:value-of select="."/>
					<xsl:text>, </xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne11"/>
	<xsl:template match="colonne12">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code='0'"> et il a trouv� un r�sultat correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code='0'"> et elle a trouv� un r�sultat correct <xsl:value-of select="res"/>. </xsl:when>
				<xsl:when test="@code='1' or @code='2'"> elle a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
				<xsl:when test="9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne14">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=0 and @nbOper=0 and @str=6 and (@col2!=0 or @col6!=0)">Le r�sultat donn� (<xsl:value-of select="res"/>) n'a pas de sens relativement � l'�nonc�.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0 and @col2=0 and @str=5"><br/>Pour le calcul final, il a fait un calcul implicite qui m�ne � une solution correcte (<xsl:value-of select="res"/>).</xsl:when>
                <xsl:when test="@code=0 and @nbOper=0 and @str=5">men� � une solution correcte (<xsl:value-of select="res"/>) � partir de calculs mentaux</xsl:when>
				
                <xsl:when test="@code=0 and @col16=8">
					<br/>Pour le calcul final, il a fait un calcul implicite qui m�ne � un r�sultat incorrect</xsl:when>
				<xsl:when test="@code=0">
					<br/>Pour le calcul final, il a fait un calcul implicite </xsl:when>
				<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectu� correspond au calcul de la premi�re partie manquante. Il a utilis� une </xsl:when>
				<xsl:when test="@code=1 or @code =2">
					<br/>Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>, il a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 't'">
					<br/>Pour le calcul final, il a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. Il a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 'p'">
					<br/>Pour le calcul final, il a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. Il a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col15=0 and @type='a'">Pour le calcul final, qui correspond au calcul de la comparaison, il a utilis� des calculs mentaux.</xsl:when>
				<xsl:when test="@code=3 and @nbOper=1 and @str!=2"> Il a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @nbOper=1 and @str=2">Pour le calcul final, il a utilis� une </xsl:when>
				<xsl:when test="@code=3">
					<xsl:value-of select="."/>Pour le calcul final, il a utilis� une </xsl:when>
				<xsl:when test="@code=4">Pour le calcul final, il utilise <xsl:value-of select="."/>, il a utilis� une </xsl:when>
				<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une op�ration de soustraction, au lieu de l'</xsl:when>
				<xsl:when test="@code=41 and @q='t' and @str=1">Pour le calcul final, il a fait une addition des r�sultats interm�diaires </xsl:when>
				<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une op�ration d'addition, au lieu de la </xsl:when>
				<xsl:when test="@code=43 and @nbOper=1">Il a utilis� une</xsl:when>
				<xsl:when test="@code=43">Pour le calcul final, il a utilis� une</xsl:when>
				<xsl:when test="@code=51">Pour le calcul final, il a utilis� plusieurs op�rations qui ne m�nent pas � la solution. Dans son dernier calcul, il a fait une</xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4 and @col15=8">Le calcul effectu� est erron� </xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectu� est erron�, il a utilis� une </xsl:when>
				<xsl:when test="@code=5 and @str=7">Pour le calcul final, il a utilis� une</xsl:when>
				<xsl:when test="@code=5 and @col15=8">Pour le calcul final, il a utilis� une op�ration non pertinente</xsl:when>
				<xsl:when test="@code=5">
					<br/>Pour le calcul final, il a utilis� une </xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=0 and @nbOper=0 and @str=6 and @col2!=0 and @col6!=0">Le r�sultat donn� (<xsl:value-of select="res"/>) n'a pas de sens relativement � l'�nonc�.</xsl:when>
                	<xsl:when test="@code=0 and @nbOper=0 and @col2=0 and @str=5"><br/>Pour le calcul final, elle a fait un calcul implicite qui m�ne � une solution correcte (<xsl:value-of select="res"/>).</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0 and @str=5">men� � une solution correcte (<xsl:value-of select="res"/>) � partir de calculs mentaux</xsl:when>
				<xsl:when test="@code=0 and @col16=8">
					<br/>Pour le calcul final, elle a fait un calcul implicite qui m�ne � un r�sultat incorrect </xsl:when>
				<xsl:when test="@code=0">
					<br/>Pour le calcul final, elle a fait un calcul implicite </xsl:when>
				<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectu� correspond au calcul de la premi�re partie manquante. Elle a utilis� une </xsl:when>
				<xsl:when test="@code=1 or @code =2">
					<br/>Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>, elle a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 't'">
					<br/>Pour le calcul final, elle a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur recherch�e. Elle a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col1=3 and @type ='a'  and @q = 'p'">
					<br/>Pour le calcul final, elle a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initiale (<xsl:value-of select="partie1"/>) et la valeur recherch�e. Elle a utilis� une </xsl:when>
				<xsl:when test="@code=3 and @col15=0 and @type='a'">Pour le calcul final, qui correspond au calcul de la comparaison, elle a utilis� des calculs mentaux.</xsl:when>
				<xsl:when test="@code=3 and @nbOper=1"> Elle a utilis� une </xsl:when>
				<xsl:when test="@code=3">
					<xsl:value-of select="."/>Pour le calcul final, elle a utilis� une </xsl:when>
				<xsl:when test="@code=4">Pour le calcul final, elle utilise <xsl:value-of select="."/>, elle a utilis� une </xsl:when>
				<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une op�ration de soustration, au lieu de l'</xsl:when>
				<xsl:when test="@code=41 and @q='t' and @str=1">Pour le calcul final, elle a fait une addition des r�sultats interm�diaires </xsl:when>
				<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une op�ration d'addition, au lieu de la </xsl:when>
				<xsl:when test="@code=43 and @nbOper=1">Elle a utilis� une</xsl:when>
				<xsl:when test="@code=43">Pour le calcul final, elle a utilis� une</xsl:when>
				<xsl:when test="@code=51">Pour le calcul final, elle a utilis� plusieurs op�rations qui ne m�nent pas � la solution. Dans son dernier calcul, elle a fait une</xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4 and @col15=8">Le calcul effectu� est erron� </xsl:when>
				<xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectu� est erron�, elle a utilis� une </xsl:when>
				<xsl:when test="@code=5 and @str=7">Pour le calcul final, elle a utilis� une</xsl:when>
				<xsl:when test="@code=5 and @col15=8">Pour le calcul final, elle a utilis� une op�ration non pertinente</xsl:when>
				<xsl:when test="@code=5">
					<br/>Pour le calcul final, elle a utilis� une </xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne15">
		<xsl:choose>
			<xsl:when test="@code=0"/>
			<xsl:when test="(@code=1 or @code=2 or @code=3 or @code=4 or @code=71 or @code=72) and @col14=41">
				<xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=1 or @code=2 or @code=3 or @code=4 or @code=71or @code=72">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=5 or @code=52">
				<xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code=6">op�ration non pertinente  sur tous les termes de l'�nonc� <xsl:value-of select="op"/>. </xsl:when>
			<xsl:when test="@code=7">op�ration non pertinente sur deux des termes de l'�nonc� <xsl:value-of select="op"/>. </xsl:when>
			<xsl:when test="@code=8">
				<xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne17">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@code=0 and @sol=3 and @nbOper>1"> Concernant cette op�ration, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper>1"> Il n'a pas fait d'erreur pour ce calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @col14=0 and @col15=0 and @str!=5"> qui m�ne � un r�sultat correct <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0"/>
				<xsl:when test="@code=0">  Concernant cette op�ration, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=1">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=2">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=8 and @str!=6">ab<xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9 and @col14=0 and @col15=0 and @str!=6"> qui m�ne � un r�sultat incorrect <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@code=0 and @sol=3 and @nbOper>1"> Concernant cette op�ration, elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper>1"> Elle n'a pas fait d'erreur pour ce calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=0 and @col14=0 and @col15=0 and @str!=5"> qui m�ne � un r�sultat correct <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=0 and @nbOper=0"/>
				<xsl:when test="@code=0">  Concernant cette op�ration, elle n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
				<xsl:when test="@code=1">  Elle a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=2">  Elle a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=8 and @str!=6">
					<xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9 and @col14=0 and @col15=0 and @str!=6"> qui m�ne � un r�sultat incorrect <xsl:value-of select="res"/>.</xsl:when>
				<xsl:when test="@code=9"/>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	<xsl:template match="colonne16">
		<xsl:choose>
			<xsl:when test="@code=0">
				<!-- Les donn�es utilis�es pour l'op�ration finale sont<xsl:value-of select="."/>.-->
			</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=1"> Les donn�es utilis�es sont pertinentes pour le calcul de la premi�re partie manquante, mais pas pour l'op�ration finale.</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=5">
				<!--Le r�sultat de cette op�ration n' a pas de sens relativement � l'�nonc�.-->
			 Ce calcul n'est pas coh�rent relativement � l'�nonc�. 
			</xsl:when>
			<xsl:when test="@code=1 and @col14=4 and @str=4"> Le r�sultat de cette op�ration n'a pas de sens relativement � l'�nonc�.</xsl:when>
			<xsl:when test="@code=1 and @str=7"/>
			<xsl:when test="@code=1">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=2">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=3">
				<xsl:value-of select="."/>. <br/>
			</xsl:when>
			<xsl:when test="@code=4">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=5">
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="commentaire">
		<xsl:if test="@sexe='m'">
			<xsl:choose>
				<xsl:when test="@str=1 and @nbOper=2 and @type='a' and @col14=4 and @col16=1">
					<br/>Dans la r�solution de cet exercice, il a consid�r� que le calcul final impliquait forc�ment le r�sultat du calcul pr�c�dent et la donn�e restante de l'�nonc�.			
				</xsl:when>
				<xsl:when test="@str=4 and (@col2=5 or @col15=8)">
					<br/>Dans la r�solution de cet exercice, il a fait le choix d'op�rations non pertinentes.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and (@col14=1 or @col14=2)">
					<br/>La r�solution du probl�me est inachev�e</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and @col6!=9 and @col14=9">
					<br/>La r�solution du probl�me est inachev�e</xsl:when>
				<xsl:when test="@str=1 and @col2=0 and @nbOper=0 and @col14=9">
					<br/>La r�solution du probl�me est inachev�e</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and (@nbOper=0 or @nbOper=2) and (@sol=3 or @sol=2)">
					<br/>Sa r�solution correspond � "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @col6=20">
					<br/>Dans sa r�solution, il a pos� le calcul de la diff�rence <xsl:value-of select="op"/>.</xsl:when>
			</xsl:choose>
		</xsl:if>
		<xsl:if test="@sexe='f'">
			<xsl:choose>
				<xsl:when test="@str=1 and @nbOper=2 and @type='a' and @col14=4 and @col16=1">
					<br/>Dans la r�solution de cet exercice, elle a consid�r� que le calcul final impliquait forc�ment le r�sultat du calcul pr�c�dent et la donn�e restante de l'�nonc�.
				</xsl:when>
				<xsl:when test="@str=4 and (@col2=5 or @col15=8)">
					<br/>Dans la r�solution de cet exercice, elle a fait le choix d'op�rations non pertinentes.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and (@col14=1 or @col14=2)">
					<br/>La r�solution du probl�me est inachev�e.</xsl:when>
				<xsl:when test="@str=1 and @col2=0 and @nbOper=0 and @col14=9">
					<br/>La r�solution du probl�me est inachev�e.</xsl:when>
				<xsl:when test="@str=4 and @col2=9 and @nbOper=1 and @col6!=9 and @col14=9">
					<br/>La r�solution du probl�me est inachev�e.</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and @nbOper=2 and @col6!=0 and (@sol=3 or @sol=2)">
					<br/>Sa r�solution correspond � "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @type='a' and @qi=1 and @nbOper=0 and (@sol=3 or @sol=2)">
					<br/>Sa r�solution correspond � "une question un calcul".</xsl:when>
				<xsl:when test="@str=1 and @col6=20">
					<br/>Dans sa r�solution, elle a pos� le calcul de la diff�rence <xsl:value-of select="op"/>.</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
