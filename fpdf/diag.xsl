<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output encoding="iso-8859-1"/>
	<xsl:template match="diagnostic">
				<xsl:apply-templates select="exercice"/>
	</xsl:template>
	<xsl:template match="exercice">						
					<xsl:value-of select="nom"/>
					<xsl:value-of select="resolution"/>.
                    Cet �l�ve a proc�d� de la mani�re suivante :
                    <xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="enonce"/>
	<xsl:template match="reponse"/>
	<xsl:template match="nom"/>
	<xsl:template match="resolution"/>
	<xsl:template match="nbOper">
		<xsl:choose>
			<xsl:when test="@nbOper>1">Sa r�solution s'est faite en <xsl:value-of select="."/> calculs.</xsl:when>
			<xsl:when test="@nbOper=1">Sa r�solution s'est faite en <xsl:value-of select="."/> calcul.</xsl:when>
			<xsl:when test="@nbOper=0">Il n'a pas pos� d'op�rations.</xsl:when>
		</xsl:choose> 
	</xsl:template>
	<xsl:template match="colonne1">
		<xsl:choose>
			<xsl:when test="@code=1">Tout d'abord, cet �l�ve a calcul� la partie manquante, en faisant </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;e&quot; and @q=&quot;p&quot;">Tout d'abord, cet �l�ve a calcul� l'�cart entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur du tout final (<xsl:value-of select="tout2"/>). </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;e&quot; and @q=&quot;t&quot;">Tout d'abord, cet �l�ve a calcul� l'�cart entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur du tout final (<xsl:value-of select="partie2"/>). </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;a&quot; and @q=&quot;p&quot;">Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur de la partie recherch�e. </xsl:when>
			<xsl:when test="@code=2 and @type=&quot;a&quot; and @q=&quot;t&quot;">Cet �l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur de la partie recherch�e. </xsl:when>
			<xsl:when test="@code=3">Tout d'abord, cet �l�ve a calcul� la partie manquante, en faisant </xsl:when>
			<xsl:when test="@code=4 and @nbOper>1">Tout d'abord, cet �l�ve a fait </xsl:when>
			<xsl:when test="@code=4"><!--Il a utilis� une <xsl:value-of select="@intitule"/><xsl:value-of select="."/>, --></xsl:when>
			<xsl:when test="@code=5">Il a utilis� une strat�gie non identifi�e qui l'a </xsl:when>
			<xsl:when test="@code=6">Il a effectu� des calculs mentaux non identifi�es. </xsl:when>
			<xsl:when test="@code=7">Tout d'abord, cet �l�ve a r�alis� l'op�ration de comparaison, </xsl:when>
			<xsl:otherwise/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne2">
		<xsl:choose>
			<xsl:when test="@code='0'">le calcul de mani�re <xsl:value-of select="."/>.</xsl:when>
			<xsl:when test="@code='1' or @code='2' or @code='3' or @code='7'"> une <xsl:value-of select="."/><xsl:text>. </xsl:text></xsl:when>
			<xsl:when test="@code=4">une <xsl:value-of select="."/>.</xsl:when>

		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne4">
		<xsl:choose>
			<xsl:when test="@code='0'"> Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> Il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne3">
		<xsl:choose>
            <xsl:when test="@code=0 and @col2=4"> Le r�sultat de cette op�ration n'a pas de sens relativement � l'�nonc�. </xsl:when>
            <!-- <xsl:when test="@code=1">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>-->
        </xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne6">
		
        <xsl:choose>
			<xsl:when test="@code='0' and @nbOper=0">Il a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
			<xsl:when test="@code='0'">Ensuite, il a r�alis� l'op�ration de comparaison � partir de calculs mentaux</xsl:when>
			<xsl:when test="(@code='1' or @code='2' or @code='3' or @code='4' or @code='7') and (@str='7')">par une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
		 <xsl:when test="@code='1' or @code='2' or @code='3' or @code='4' or @code='7'">
				Ensuite, il a r�alis� l'op�ration de comparaison, par  une <xsl:value-of select="."/><xsl:text>, </xsl:text>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne7">
		<!-- <xsl:choose>
            <xsl:when test="@code=0">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=1">les donn�es utilis�es pour son op�ration sont <xsl:value-of select="."/>, </xsl:when>
            <xsl:when test="@code=9"></xsl:when>
        </xsl:choose>-->
	</xsl:template>
	<xsl:template match="colonne8">
		<xsl:choose>
			<xsl:when test="@code='0'"> et il a trouv� un <xsl:value-of select="@intitule"/> <xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne10">
		<xsl:choose>
			<xsl:when test="@code='0'"> Pour le <xsl:value-of select="@intitule"/> il a utilis� un  calcul <xsl:value-of select="."/></xsl:when>
			<xsl:when test="@code='1' or @code='2'"> Il a utilis� une <xsl:value-of select="."/><xsl:text>, </xsl:text></xsl:when>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="colonne11"/>
	<xsl:template match="colonne12">
		<xsl:choose>
			<xsl:when test="@code='0'"> et il a trouv� un <xsl:value-of select="@intitule"/>
				<xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code='1' or @code='2'"> il a fait une <xsl:value-of select="."/> de calcul. </xsl:when>
			<xsl:when test="9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne14">
		<xsl:choose>
			<xsl:when test="@code=0 and @nbOper=0 and @str=6">Le r�sultat donn� n'a pas de sens relativement � l'�nonc�.</xsl:when>
			<xsl:when test="@code=0 and @nbOper=0 and @str=5">men� � une solution correcte � partir de calculs mentaux.</xsl:when>
			<xsl:when test="@code=0">Pour le calcul final, il a fait un calcul <xsl:value-of select="."/>, </xsl:when>
			<xsl:when test="@code=1 and @nbOper =1 and @str=4">Le calcul effectu� correspond au calcul de la premi�re partie manquante. Il a utilis� une </xsl:when>
			<xsl:when test="@code=1 or @code =2">Pour le calcul final, qui correspond au calcul d'<xsl:value-of select="."/>. Il a utilis� une </xsl:when>
			<xsl:when test="@code=3 and @col1=3 and @type =&quot;a&quot;  and @q = &quot;t&quot;">Pour le calcul final, l'�l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur du tout initial (<xsl:value-of select="tout1"/>) et la valeur de la partie recherch�e. Il a utilis� une </xsl:when>
			<xsl:when test="@code=3 and @col1=3 and @type =&quot;a&quot;  and @q = &quot;p&quot;">Pour le calcul final, l'�l�ve a calcul� directement la solution en utilisant l'�cart (<xsl:value-of select="valdiff"/>) entre la valeur de la partie initial (<xsl:value-of select="partie1"/>) et la valeur de la partie recherch�e. Il a utilis� une </xsl:when>
			<xsl:when test="@code=3 and @col15=0 and @type=&quot;a&quot;">Pour le calcul final, il correspond au calcul de la comaraison. Il a utilis� des calculs mentaux.</xsl:when>
			<xsl:when test="@code=3"><xsl:value-of select="."/>Pour le calcul final, Il a utilis� une </xsl:when>
			<xsl:when test="@code=4">Pour le calcul final, il utilise <xsl:value-of select="."/>. Il a utilis� une </xsl:when>
			<xsl:when test="@code=41 and @q='p' and @str=1">Pour le calcul final, la question finale porte sur une partie. Il aurait donc fallu une op�ration de soustration, au lieu de l' </xsl:when>
			<xsl:when test="@code=42 and @q='t' and @str=1">Pour le calcul final, la question finale porte sur un tout. ll aurait donc fallu une op�ration d'addition, au lieu de la </xsl:when>
		    <xsl:when test="@code=51">Pour le calcul final, il a utilis� plusieurs op�rations qui ne m�nent pas � la solution. Dans son dernier calcul, il a fait une</xsl:when>
  
		    <xsl:when test="@code=5 and @nbOper =1 and @str=4">Le calcul effectu� est erron�. Il a utilis� une </xsl:when>
		    <xsl:when test="@code=5 and @str=7">Pour le calcul final, il a utils� une</xsl:when>
		    <xsl:when test="@code=5 and @col15=8">Pour le calcul final, il a utilis� une op�ration non pertinente</xsl:when>
		    <xsl:when test="@code=5">Pour le calcul final, qui correspond <xsl:value-of select="."/>,</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne15">
		<xsl:choose>
			<xsl:when test="@code=0"/>
			<xsl:when test="@code=1 or @code=2 or @code=3 or @code=4 "><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=6">. </xsl:when>
			<xsl:when test="@code=7">. </xsl:when>
			<xsl:when test="@code=8"><xsl:value-of select="op"/>.</xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="colonne17">
		<xsl:choose>
			<xsl:when test="@code=0 and @sol=3 and @nbOper>1">Concernant cette op�ration, il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=0 and @nbOper>1"> Il n'a pas fait d'erreur pour ce calcul<xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=0 and @col14=0 and @col15=0"> qui m�ne � un resultat correct<xsl:value-of select="res"/></xsl:when>
			<xsl:when test="@code=0 and @nbOper=0"></xsl:when>
			<xsl:when test="@code=0">  Il n'a pas fait d'erreur de calcul <xsl:value-of select="./res"/>.</xsl:when>
			<xsl:when test="@code=1">  Il a commis une une petite erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
			<xsl:when test="@code=2">  Il a commis une erreur de calcul <xsl:value-of select="res"/>.</xsl:when>
			<xsl:when test="@code=9 and @col14=0 and @col15=0"> qui m�ne � un resultat incorrect<xsl:value-of select="res"/></xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>	
	
	<xsl:template match="colonne16">
		<xsl:choose>
			<xsl:when test="@code=0"> <!-- Les donn�es utilis�es pour l'op�ration finale sont<xsl:value-of select="."/>.--></xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=1"> Les donn�es utilis�es sont pertinente pour le calcul de la premi�re partie manquante, mais pas pour l'op�ration finale.</xsl:when>
			<xsl:when test="@code=1 and @nbOper=1 and @str=4 and @col14=5"> Le r�sultat de cette op�ration n' a pas de sens relativement � l'�nonc�.</xsl:when>
			<xsl:when test="@code=1 and @col14=4 and @str=4"> Le r�sultat de cette op�ration n' a pas de sens relativement � l'�nonc�.</xsl:when>
			<xsl:when test="@code=1 and @str=7"></xsl:when>			
			<xsl:when test="@code=1"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=2"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=3"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=4"><xsl:value-of select="."/>. </xsl:when>
			<xsl:when test="@code=9"/>
		</xsl:choose>
	</xsl:template>
	
</xsl:stylesheet>
