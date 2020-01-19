<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                xmlns:rss="http://purl.org/rss/1.0/"
                xmlns:dc="http://purl.org/dc/elements/1.1/"
                xmlns:syn="http://purl.org/rss/1.0/modules/syndication/"
                xmlns="http://www.w3.org/1999/xhtml"
                version="1.0">
<xsl:output method="html" indent="yes"/>

<xsl:template match="rdf:RDF">
   <html xmlns="http://www.w3.org/1999/xhtml" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:rss="http://purl.org/rss/1.0/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:syn="http://purl.org/rss/1.0/modules/syndication/">
     <head>
       <title><xsl:value-of select="rss:channel/rss:title"/></title>
       <meta charset="UTF-8"/>
       <xsl:element name="meta">
         <xsl:attribute name="name">author</xsl:attribute>
         <xsl:attribute name="content">
           <xsl:value-of select="rss:channel/dc:publisher"/>
         </xsl:attribute>
       </xsl:element>
       <xsl:element name="meta">
         <xsl:attribute name="name">description</xsl:attribute>
         <xsl:attribute name="content">
           <xsl:value-of select="rss:channel/rss:description"/>
         </xsl:attribute>
       </xsl:element>
     </head>
     <body>
       <h1>
         <xsl:value-of select="rss:channel/rss:title"/>
       </h1>
       <p>
         <xsl:text>Beskrivning: </xsl:text>
         <xsl:value-of select="rss:channel/rss:description"/>
       </p>
       <p>
         <xsl:text>Skapad av: </xsl:text>
         <xsl:value-of select="rss:channel/dc:publisher"/>
       </p>
       <p>
         <xsl:text>Kontakt: </xsl:text>
         <xsl:element name="a">
           <xsl:attribute name="href">
             <xsl:text>mailto:</xsl:text>
             <xsl:value-of select="rss:channel/dc:creator"/>
           </xsl:attribute>
           <xsl:value-of select="rss:channel/dc:creator"/>
        </xsl:element>
       </p>
       <xsl:apply-templates/>
     </body>
   </html>
</xsl:template>

<xsl:template match="rss:item">
    <h2>
      <xsl:element name="a">
        <xsl:attribute name="href">
          <xsl:value-of select="./rss:link"/>
        </xsl:attribute>
        <xsl:value-of select="./rss:title"/>
      </xsl:element>
    </h2>
    <p>
      <xsl:text>Författare: </xsl:text>
      <xsl:value-of select="./dc:creator"/>
    </p>
    <h3>Text</h3>
    <p>
      <xsl:value-of select="./rss:description"/>
    </p>
</xsl:template>

<xsl:template match="rss:channel"/>

</xsl:stylesheet>