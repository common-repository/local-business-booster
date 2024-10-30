<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:s="http://www.sitemaps.org/schemas/sitemap/0.9" exclude-result-prefixes="s">
    <xsl:template match="/">
    <html> 
    <body style="width:100%; text-align:center;">
      <div style="margin: auto; width:50%; text-align:center; ">
      <h2> <xsl:value-of select="s:sitemapindex/@title"/> XML SiteMap</h2>
      <p>This Sitemap was created by <a href="http://wordpress.plustime.com.au">Local Business Booster - (Second2None) </a></p>
      <table style="width: 100%;">
        <tr style="background: #959799; color: #fff; height:40px;">
          <th style="text-align:center">Sitemap URL</th>
          <th style="text-align:center">Last Modified</th>
        </tr>
        <xsl:for-each select="s:sitemapindex/s:sitemap">
        <xsl:variable name="tr-style">
            <xsl:choose>
              <xsl:when test="position() mod 2 = 0">background: #ffffff; color:#23282d;</xsl:when>
              <xsl:otherwise>background: #cacaca; color:#fff;</xsl:otherwise>
            </xsl:choose>
          </xsl:variable>
        <tr style="{$tr-style}">
        <xsl:variable name="hyperlink"><xsl:value-of select="s:loc" /></xsl:variable>
          <td><a style="{$tr-style}" href="{$hyperlink}"><xsl:value-of select="s:loc"/></a></td>
          <td style="text-align:center"><xsl:value-of select="s:lastmod"/></td>
        </tr>
        </xsl:for-each>
      </table>
    </div>
    </body>
    </html>
    </xsl:template>
</xsl:stylesheet>