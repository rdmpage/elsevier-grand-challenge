<?xml version='1.0' encoding='utf-8'?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:ce="http://www.elsevier.com/ce" xmlns:sb="http://www.elsevier.com/sb"
    xmlns:xlink="http://www.w3.org/1999/xlink">

    <xsl:output method="text" version="1.0" encoding="utf-8" indent="no"/>

    <xsl:template match="/">
        <xsl:text>{
</xsl:text>

        <!-- DOI -->
        <xsl:text>"doi":"</xsl:text>
        <xsl:value-of select="//ce:doi"/>
        <xsl:text>",&#x0D;</xsl:text>

        <!-- PII -->
        <xsl:text>"pii":"</xsl:text>
        <xsl:value-of select="//ce:pii"/>
        <xsl:text>",&#x0D;</xsl:text>

        <!-- bibliographic details for this paper, including authors and any
emails (which may be useful for disambiguating people) -->

        <xsl:apply-templates select="//head"/>

        <!-- list figures -->
        <xsl:text>&#x0D;"figures":[</xsl:text>
        <xsl:apply-templates select="//ce:figure"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>

        <!-- tables -->
        <xsl:text>&#x0D;"tables":[</xsl:text>

        <xsl:apply-templates select="//ce:table"/>
        <xsl:text>],</xsl:text>

		<!-- urls -->
      	<xsl:text>&#x0D;"urls":[</xsl:text>
        <xsl:apply-templates select="//ce:inter-ref"/>
        <xsl:text>],&#x0D;</xsl:text>


        <!-- bibliography -->
        <xsl:text>&#x0D;"bibliography":[</xsl:text>
        <xsl:apply-templates select="//ce:bibliography"/>
        <xsl:text>]</xsl:text>
        <xsl:text>&#x0D;}</xsl:text>



    </xsl:template>

    <xsl:template match="//ce:table">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{&#x0D;</xsl:text>
        <xsl:text>"label":"</xsl:text>
        <xsl:value-of select="ce:label"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:text>"caption":"</xsl:text>
        <xsl:value-of select="ce:caption"/>
        <xsl:text>"&#x0D;</xsl:text>
        <xsl:apply-templates select="tgroup"/>
        <xsl:text>&#x0D;}&#x0D;</xsl:text>

    </xsl:template>

    <xsl:template match="tgroup">
<!--        <xsl:if test="position() != 1"> -->
            <xsl:text>,</xsl:text>
<!--        </xsl:if> -->
        <!-- head has column headings -->
        <xsl:apply-templates select="thead"/>

        <!-- body of table has data -->
        <xsl:apply-templates select="tbody"/>
    </xsl:template>

    <xsl:template match="thead">
        <xsl:text>"header":[</xsl:text>
        <xsl:apply-templates select="row"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>
    </xsl:template>

    <xsl:template match="tbody">
        <xsl:text>"rows":[</xsl:text>
        <xsl:apply-templates select="row"/>
        <xsl:text>&#x0D;]</xsl:text>
    </xsl:template>

    <!-- one row is an array-->
    <xsl:template match="row">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;[</xsl:text>
        <xsl:apply-templates select="entry"/>
        <xsl:text>]</xsl:text>
    </xsl:template>

    <!-- loop -->

    <xsl:template name="empty">
        <xsl:param name="count" select="1"/>

        <xsl:if test="$count > 0">
            <xsl:text>,"-"</xsl:text>
            <xsl:call-template name="empty">
                <xsl:with-param name="count" select="$count - 1"/>
            </xsl:call-template>
        </xsl:if>

    </xsl:template>

    <xsl:template match="entry">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>

        <!-- here comes the fun... -->
        <xsl:text>"</xsl:text>

		<xsl:variable name="content" select="."/>
		<xsl:call-template name="cleanQuote">
			<xsl:with-param name="string" select="$content"/>
		</xsl:call-template>


 <!--        <xsl:value-of select="."/> -->
        <xsl:if test="@morerows != ''">
            <xsl:text>{@m</xsl:text>
			<xsl:value-of select="@morerows"/>
			<xsl:text>}</xsl:text>
        </xsl:if>

        <xsl:text>"</xsl:text>

        <xsl:if test="@namest != ''">


            <xsl:variable name="namest" select="substring-after(@namest, 'col')"/>
            <xsl:variable name="nameend" select="substring-after(@nameend, 'col')"/>
            <!-- <xsl:value-of select="$namest" />
<xsl:value-of select="$nameend" /> 
<xsl:value-of select="$nameend - $namest" /> -->

            <xsl:call-template name="empty">
                <xsl:with-param name="count" select="$nameend - $namest"/>
            </xsl:call-template>


            <!-- fill in missing cells -->
        </xsl:if>



    </xsl:template>

    <xsl:template match="//head">
        <xsl:text>"atitle":"</xsl:text>
        <xsl:value-of select="ce:title"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:apply-templates select="ce:author-group"/>
        <xsl:apply-templates select="ce:abstract"/>
        <xsl:apply-templates select="ce:keywords"/>
    </xsl:template>

   <!-- abstract -->
    <xsl:template match="ce:abstract">
        <xsl:text>"abstract":"</xsl:text>
        <xsl:value-of select="ce:abstract-sec"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>


   <!-- keywords -->
    <xsl:template match="ce:keywords">
        <xsl:text>"keywords":[</xsl:text>
        <xsl:apply-templates select="ce:keyword"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>
    </xsl:template>

   <!-- keyword -->
    <xsl:template match="ce:keyword">
       <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
         <xsl:text>"</xsl:text>
        <xsl:value-of select="."/>
        <xsl:text>"</xsl:text>
    </xsl:template>


    <!-- authors -->
    <xsl:template match="ce:author-group">
        <xsl:text>"authors":[</xsl:text>
        <xsl:apply-templates select="ce:author"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>
    </xsl:template>

    <!-- a single author -->
    <xsl:template match="ce:author">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{</xsl:text>
        <xsl:text>"forename":"</xsl:text>
        <xsl:apply-templates select="ce:given-name"/>
        <xsl:text>", </xsl:text>
        <xsl:text>"lastname":"</xsl:text>
        <xsl:apply-templates select="ce:surname"/>
        <xsl:text>"</xsl:text>
        <xsl:apply-templates select="ce:e-address"/>
        <xsl:text>}</xsl:text>
    </xsl:template>

    <xsl:template match="ce:e-address">
        <xsl:if test="@type='email'">
            <xsl:text>, "email":"</xsl:text>
            <xsl:value-of select="."/>
            <xsl:text>"</xsl:text>
        </xsl:if>
    </xsl:template>



    <!-- figures -->
    <xsl:template match="//ce:figure">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{&#x0D;</xsl:text>
        <xsl:text>"id":"</xsl:text>
        <xsl:value-of select="@id"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:text>"label":"</xsl:text>
        <xsl:value-of select="ce:label"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:text>"caption":"</xsl:text>
        <xsl:value-of select="ce:caption/ce:simple-para"/>
        <xsl:text>"&#x0D;</xsl:text>
        <xsl:text>}</xsl:text>
    </xsl:template>


    <!-- bibliograpy -->
    <xsl:template match="//ce:bibliography">
        <xsl:apply-templates select="//ce:bib-reference"/>
    </xsl:template>

    <!-- Individual publication -->
    <xsl:template match="//ce:bib-reference">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{&#x0D;</xsl:text>

        <xsl:apply-templates select="sb:reference"/>
        <xsl:apply-templates select="ce:other-ref"/>
        <xsl:text>"id":"</xsl:text>
        <xsl:value-of select="@id"/>
        <xsl:text>"&#x0D;</xsl:text>
        <xsl:text>&#x0D;}&#x0D;</xsl:text>

    </xsl:template>

    <xsl:template match="ce:other-ref">
        <xsl:text>"description":"</xsl:text>
        <xsl:value-of select="ce:textref"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <xsl:template match="sb:reference">
        <xsl:apply-templates select="sb:host"/>
        <xsl:apply-templates select="sb:contribution/sb:authors"/>
        <xsl:text>"atitle":"</xsl:text>
        <xsl:value-of select="sb:contribution/sb:title/sb:maintitle"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- could be article, book, or chapter -->
    <xsl:template match="sb:host">
        <xsl:apply-templates select="sb:issue"/>
        <xsl:apply-templates select="sb:pages"/>
        <xsl:apply-templates select="sb:book"/>
        <xsl:apply-templates select="sb:edited-book"/>
    </xsl:template>

    <!-- book -->
    <xsl:template match="sb:book">
        <xsl:text>"genre":"book",&#x0D;</xsl:text>
        <xsl:text>"date":"</xsl:text>
        <xsl:apply-templates select="sb:date"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:apply-templates select="sb:publisher"/>
    </xsl:template>

    <!-- edited book -->
    <xsl:template match="sb:edited-book">
        <xsl:text>"genre":"bookitem",&#x0D;</xsl:text>

        <!-- might be part of a series of books -->
        <xsl:apply-templates select="sb:book-series"/>

        <!-- might not -->
        <xsl:apply-templates select="sb:editors"/>
        <xsl:apply-templates select="sb:title/sb:maintitle"/>

        <xsl:text>"date":"</xsl:text>
        <xsl:apply-templates select="sb:date"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:apply-templates select="sb:publisher"/>
        <xsl:apply-templates select="sb:pages"/>
    </xsl:template>

    <!-- book series -->
    <xsl:template match="sb:book-series">
        <xsl:apply-templates select="sb:volume-nr"/>
        <xsl:apply-templates select="sb:editors"/>
        <xsl:text>"title":"</xsl:text>
        <xsl:value-of select="sb:series/sb:title/sb:maintitle"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- book title -->
    <xsl:template match="sb:title/sb:maintitle">
        <xsl:text>"title":"</xsl:text>
        <xsl:value-of select="."/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- book publisher -->
    <xsl:template match="sb:publisher">
        <xsl:text>"publisher":"</xsl:text>
        <xsl:value-of select="sb:name"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:text>"publoc":"</xsl:text>
        <xsl:value-of select="sb:location"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- journal -->
    <xsl:template match="sb:issue">
        <xsl:text>"genre":"article",&#x0D;</xsl:text>
        <xsl:text>"date":"</xsl:text>
        <xsl:apply-templates select="sb:date"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:apply-templates select="sb:series/sb:volume-nr"/>
        <xsl:text>"title":"</xsl:text>
        <xsl:value-of select="sb:series/sb:title/sb:maintitle"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>


    <!-- volume (journal or book series) -->
    <xsl:template match="sb:volume-nr">
        <xsl:text>"volume":"</xsl:text>
        <xsl:value-of select="."/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- pages (journal or book chapter) -->
    <xsl:template match="sb:pages">
        <xsl:text>"spage":"</xsl:text>
        <xsl:apply-templates select="sb:first-page"/>
        <xsl:text>",&#x0D;</xsl:text>
        <xsl:text>"epage":"</xsl:text>
        <xsl:apply-templates select="sb:last-page"/>
        <xsl:text>",&#x0D;</xsl:text>
    </xsl:template>

    <!-- authors -->
    <xsl:template match="sb:authors">
        <xsl:text>"authors":[</xsl:text>
        <xsl:apply-templates select="sb:author"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>
    </xsl:template>

    <!-- a single author -->
    <xsl:template match="sb:author">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{</xsl:text>
        <xsl:text>"forename":"</xsl:text>
        <xsl:apply-templates select="ce:given-name"/>
        <xsl:text>", </xsl:text>
        <xsl:text>"surname":"</xsl:text>
        <xsl:apply-templates select="ce:surname"/>
        <xsl:text>"</xsl:text>
        <xsl:text>}</xsl:text>
    </xsl:template>

    <!-- editors -->
    <xsl:template match="sb:editors">
        <xsl:text>"editors":[</xsl:text>
        <xsl:apply-templates select="sb:editor"/>
        <xsl:text>&#x0D;],&#x0D;</xsl:text>
    </xsl:template>

    <!-- a single editor -->
    <xsl:template match="sb:editor">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
        <xsl:text>&#x0D;{</xsl:text>
        <xsl:text>"forename":"</xsl:text>
        <xsl:apply-templates select="ce:given-name"/>
        <xsl:text>", </xsl:text>
        <xsl:text>"surname":"</xsl:text>
        <xsl:apply-templates select="ce:surname"/>
        <xsl:text>"</xsl:text>
        <xsl:text>}</xsl:text>
    </xsl:template>

    <xsl:template match="ce:inter-ref">
        <xsl:if test="position() != 1">
            <xsl:text>,</xsl:text>
        </xsl:if>
		<xsl:text>&#x0D;"</xsl:text><xsl:value-of select="@xlink:href"/><xsl:text>"</xsl:text>
    </xsl:template>

    <!-- From http://www.dpawson.co.uk/xsl/sect2/StringReplace.html#d10992e82 -->
<xsl:template name="cleanQuote">
<xsl:param name="string" />
<xsl:if test="contains($string, '&#x22;')"><xsl:value-of
    select="substring-before($string, '&#x22;')" />\"<xsl:call-template
    name="cleanQuote">
                <xsl:with-param name="string"><xsl:value-of
select="substring-after($string, '&#x22;')" />
                </xsl:with-param>
        </xsl:call-template>
</xsl:if>
<xsl:if test="not(contains($string, '&#x22;'))"><xsl:value-of
select="$string" />
</xsl:if>
</xsl:template>

</xsl:stylesheet>
