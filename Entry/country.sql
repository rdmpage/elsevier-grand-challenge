# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.1.25-rc-log)
# Database: plan9
# Generation Time: 2008-11-24 14:52:35 +0000
# ************************************************************

# Dump of table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `countryName` varchar(255) NOT NULL DEFAULT '',
  `isoAlpha3` char(3) DEFAULT NULL,
  `continent` char(2) DEFAULT NULL,
  `geonameId` int(11) DEFAULT NULL,
  `bBoxWest` float DEFAULT NULL,
  `bBoxNorth` float DEFAULT NULL,
  `bBoxEast` float DEFAULT NULL,
  `bBoxSouth` float DEFAULT NULL,
  PRIMARY KEY (`countryName`),
  UNIQUE KEY `geonameId` (`geonameId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Andorra','AND','EU','3041565','1.42211','42.6587','1.78039','42.4351');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('United Arab Emirates','ARE','AS','290557','51.5833','26.0842','56.3817','22.6333');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Afghanistan','AFG','AS','1149361','60.4784','38.4834','74.8795','29.3775');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Antigua and Barbuda','ATG','NA','3576396','-61.9064','17.7294','-61.6724','16.997');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Anguilla','AIA','NA','3573511','-63.1729','18.2834','-62.9714','18.1668');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Albania','ALB','EU','783754','19.294','42.6656','21.0685','39.6484');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Armenia','ARM','AS','174982','43.4498','41.3018','49.4784','38.3971');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Netherlands Antilles','ANT','NA','3513447','-69.1572','12.3857','-68.1923','12.0171');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Angola','AGO','AF','3351879','11.6792','-4.37683','24.0821','-18.0421');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Antarctica','ATA','AN','6255152','-180','-60.5155','180','-89.9999');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Argentina','ARG','SA','3865483','-73.583','-21.7813','-53.5918','-55.0613');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('American Samoa','ASM','OC','5880801','-170.841','-14.1621','-169.416','-14.3825');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Austria','AUT','EU','2782113','9.53591','49.0171','17.1627','46.378');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Australia','AUS','OC','2077456','112.911','-10.0628','153.639','-43.644');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Aruba','ABW','NA','3577279','-70.0611','12.6306','-69.8669','12.4061');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Azerbaijan','AZE','AS','587116','44.7741','41.9056','50.3701','38.8202');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bosnia and Herzegovina','BIH','EU','3277605','15.7189','45.2392','19.6222','42.5461');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Barbados','BRB','NA','3374084','-59.6489','13.3273','-59.4204','13.0398');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bangladesh','BGD','AS','1210997','88.0283','26.6319','92.6737','20.7433');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Belgium','BEL','EU','2802361','2.54694','51.5055','6.40386','49.4936');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Burkina Faso','BFA','AF','2361809','-5.51892','15.0826','2.4054','9.40111');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bulgaria','BGR','EU','732800','22.3712','44.2176','28.6122','41.2421');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bahrain','BHR','AS','290291','50.4541','26.2826','50.6645','25.7969');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Burundi','BDI','AF','433561','28.9931','-2.31012','30.8477','-4.46571');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Benin','BEN','AF','2395170','0.774575','12.4183','3.8517','6.22575');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Barthélemy','BLM','NA','3578476','-62.8764','17.9327','-62.7924','17.8839');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bermuda','BMU','NA','3573345','-64.8961','32.379','-64.652','32.2466');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Brunei','BRN','AS','1820814','114.071','5.04717','115.359','4.00308');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bolivia','BOL','SA','3923057','-69.6408','-9.68057','-57.4581','-22.8961');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Brazil','BRA','SA','3469034','-73.9855','5.26488','-32.393','-33.7507');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bahamas','BHS','NA','3572887','-78.9959','26.9192','-74.4239','22.8527');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bhutan','BTN','AS','1252634','88.7597','28.3238','92.1252','26.7076');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Bouvet Island','BVT','AN','3371123','3.3355','-54.4003','3.48798','-54.4624');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Botswana','BWA','AF','933860','19.9995','-17.7808','29.3608','-26.9072');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Belarus','BLR','EU','630336','23.1769','56.1658','32.7708','51.2564');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Belize','BLZ','NA','3582678','-89.2248','18.4966','-87.777','15.8893');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Canada','CAN','NA','6251999','-141','83.1106','-52.6363','41.676');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cocos Islands','CCK','AS','1547376','96.8213','-12.1148','96.9361','-12.1854');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Congo - Kinshasa','COD','AF','203312','12.2041','5.3861','31.3059','-13.4557');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Central African Republic','CAF','AF','239880','14.4201','11.0076','27.4634','2.22051');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Congo - Brazzaville','COG','AF','2260494','11.205','3.70308','18.6498','-5.02722');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Switzerland','CHE','EU','2658434','5.95747','47.8053','10.4915','45.8257');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ivory Coast','CIV','AF','2287781','-8.5993','10.7366','-2.4949','4.35707');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cook Islands','COK','OC','1899402','-161.094','-10.0231','-157.312','-21.9442');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Chile','CHL','SA','3895114','-109.456','-17.5075','-66.4175','-55.9164');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cameroon','CMR','AF','2233387','8.49476','13.0781','16.1921','1.65255');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('China','CHN','AS','1814991','73.5577','53.5609','134.774','15.7754');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Colombia','COL','SA','3686110','-81.7281','13.3805','-66.8698','-4.22587');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Costa Rica','CRI','NA','3624060','-85.9506','11.2168','-82.556','8.03297');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cuba','CUB','NA','3562981','-84.9574','23.226','-74.1318','19.8281');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cape Verde','CPV','AF','3374766','-25.3587','17.1972','-22.6694','14.808');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Christmas Island','CXR','AS','2078138','105.539','-10.4158','105.72','-10.5757');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cyprus','CYP','EU','146669','32.2731','35.7015','34.5979','34.5635');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Czech Republic','CZE','EU','3077311','13.4012','50.7867','16.8159','49.4445');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Germany','DEU','EU','2921044','5.86564','55.0556','15.0399','47.2758');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Djibouti','DJI','AF','223816','41.7735','12.7068','43.417','10.9099');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Denmark','DNK','EU','2623032','8.07561','57.7484','15.1588','54.5624');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Dominica','DMA','NA','3575830','-61.4841','15.6318','-61.2441','15.2017');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Dominican Republic','DOM','NA','3508796','-72.0035','19.9299','-68.32','17.5432');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Algeria','DZA','AF','2589581','-8.67387','37.0937','11.9795','18.96');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ecuador','ECU','SA','3658394','-91.6619','1.41893','-75.1846','-4.99882');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Estonia','EST','EU','453733','21.8376','59.6762','28.21','57.5162');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Egypt','EGY','AF','357994','24.6981','31.6673','35.7949','21.7254');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Western Sahara','ESH','AF','2461445','-17.1032','27.6697','-8.67027','20.7742');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Eritrea','ERI','AF','338010','36.4388','18.0031','43.1346','12.3596');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Spain','ESP','EU','2510769','-18.1696','43.7917','4.31539','27.6388');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ethiopia','ETH','AF','337996','32.9999','14.8938','47.9862','3.40242');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Finland','FIN','EU','660013','19.5207','70.0961','31.5809','59.8088');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Fiji','FJI','OC','2205218','177.129','-12.4801','-178.424','-20.676');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Falkland Islands','FLK','SA','3474414','-61.3452','-51.2406','-57.7125','-52.3605');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Micronesia','FSM','OC','2081918','138.053','9.63636','163.035','5.26533');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Faroe Islands','FRO','EU','2622320','-7.458','62.4008','-6.39958','61.3949');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('France','FRA','EU','3017382','-5.14222','51.0928','9.56156','41.3716');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Gabon','GAB','AF','2400553','8.69547','2.32261','14.5023','-3.97881');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('United Kingdom','GBR','EU','2635167','-8.62356','60.8458','1.759','49.9062');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Grenada','GRD','NA','3580239','-61.8','12.3194','-61.5738','11.9924');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Georgia','GEO','AS','614540','40.0101','43.5865','46.726','41.0532');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('French Guiana','GUF','SA','3381670','-54.5425','5.7765','-51.6139','2.12709');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guernsey','GGY','EU','3042362','-2.68247','49.5147','-2.50911','49.4224');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ghana','GHA','AF','2300660','-3.25542','11.1733','1.19178','4.73672');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Gibraltar','GIB','EU','2411586','-5.35725','36.1598','-5.33964','36.1124');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Greenland','GRL','NA','3425505','-73.042','83.6274','-11.3123','59.7774');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Gambia','GMB','AF','2413451','-16.8251','13.8266','-13.7978','13.0643');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guinea','GIN','AF','2420477','-14.9266','12.6762','-7.64107','7.19355');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guadeloupe','GLP','NA','3579143','-61.5448','16.5169','-61','15.8676');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Equatorial Guinea','GNQ','AF','2309096','9.34686','2.34699','11.3357','0.92086');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Greece','GRC','EU','390903','19.3744','41.7574','28.2464','34.8096');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('South Georgia and the South Sandwich Islands','SGS','AN','3474415','-38.0212','-53.9705','-26.2293','-59.4793');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guatemala','GTM','NA','3595528','-92.2363','17.8152','-88.2232','13.7373');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guam','GUM','OC','4043988','144.619','13.6523','144.954','13.2406');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guinea-Bissau','GNB','AF','2372248','-16.7175','12.6808','-13.6365','10.9243');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Guyana','GUY','SA','3378535','-61.3848','8.55757','-56.4802','1.17508');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Hong Kong','HKG','AS','1819730','113.838','22.5598','114.435','22.1532');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Heard Island and McDonald Islands','HMD','AN','1547314','72.5965','-52.9094','73.8592','-53.192');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Honduras','HND','NA','3608932','-89.3508','16.5103','-83.1554','12.9824');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Croatia','HRV','EU','3202326','13.4932','46.5388','19.4274','42.4359');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Haiti','HTI','NA','3723988','-74.4786','20.0878','-71.6133','18.021');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Hungary','HUN','EU','719819','16.1119','48.5857','22.906','45.7436');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Indonesia','IDN','AS','1643084','95.0093','5.90442','141.022','-10.9419');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ireland','IRL','EU','2963597','-10.4786','55.3879','-6.00239','51.4516');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Israel','ISR','AS','294640','34.2304','33.3401','35.8768','29.4966');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Isle of Man','IMN','EU','3042225','-4.79872','54.4197','-4.3115','54.0559');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('India','IND','AS','1269750','68.1867','35.5042','97.4033','6.74714');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('British Indian Ocean Territory','IOT','AS','1282588','71.26','-5.26833','72.4932','-7.43803');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Iraq','IRQ','AS','99237','38.7959','37.378','48.5759','29.0694');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Iran','IRN','AS','130758','44.0473','39.7772','63.3175','25.0641');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Iceland','ISL','EU','2629691','-24.5465','66.5346','-13.4958','63.3932');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Italy','ITA','EU','3175395','6.61489','47.0952','18.5134','36.6528');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Jersey','JEY','EU','3042142','-2.26003','49.2651','-2.02208','49.1698');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Jamaica','JAM','NA','3489940','-78.3666','18.527','-76.1803','17.7036');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Jordan','JOR','AS','248816','34.96','33.3677','39.3012','29.1859');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Japan','JPN','AS','1861060','122.939','45.5231','145.821','24.2495');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Kenya','KEN','AF','192950','33.9089','5.01994','41.8991','-4.67805');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Kyrgyzstan','KGZ','AS','1527747','69.2766','43.2382','80.2832','39.1728');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cambodia','KHM','AS','1831722','102.34','14.6864','107.628','10.4091');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Kiribati','KIR','OC','4030945','172.955','1.94878','-151.804','-11.437');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Comoros','COM','AF','921929','43.2158','-11.3624','44.5382','-12.3879');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Kitts and Nevis','KNA','NA','3575174','-62.8696','17.4201','-62.5433','17.0953');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('North Korea','PRK','AS','1873107','124.316','43.0061','130.675','37.6733');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('South Korea','KOR','AS','1835841','125.887','38.6125','129.585','33.1909');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Kuwait','KWT','AS','285570','46.5555','30.0959','48.4315','28.5246');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Cayman Islands','CYM','NA','3580718','-81.4328','19.7617','-79.7273','19.263');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Kazakhstan','KAZ','AS','1522867','46.4919','55.4512','87.3127','40.9363');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Laos','LAO','AS','1655842','100.093','22.5004','107.697','13.91');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Lebanon','LBN','AS','272103','35.1143','34.6914','36.6392','33.0539');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Lucia','LCA','NA','3576468','-61.0742','14.1032','-60.8742','13.7048');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Liechtenstein','LIE','EU','3042058','9.4778','47.2735','9.6322','47.0559');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Sri Lanka','LKA','AS','1227603','79.6529','9.83136','81.8813','5.91683');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Liberia','LBR','AF','2275384','-11.4921','8.55179','-7.36511','4.35306');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Lesotho','LSO','AF','932692','27.0291','-28.5721','29.4658','-30.669');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Lithuania','LTU','EU','597427','20.9415','56.4469','26.8719','53.9013');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Luxembourg','LUX','EU','2960313','5.73456','50.1849','6.52847','49.4466');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Latvia','LVA','EU','458258','20.9743','58.0823','28.2412','55.6689');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Libya','LBY','AF','2215636','9.38702','33.169','25.1506','19.508');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Morocco','MAR','AF','2542007','-13.1686','35.928','-0.99175','27.6621');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Monaco','MCO','EU','2993457','7.38639','43.7731','7.43929','43.7275');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Moldova','MDA','EU','617790','26.6189','48.4902','30.1354','45.4689');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Montenegro','MNE','EU','3194884','18.4613','43.5701','20.3588','41.8502');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Martin','MAF','NA','3578421','-63.1528','18.1304','-63.013','18.0522');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Madagascar','MDG','AF','1062947','43.2249','-11.9454','50.4838','-25.609');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Marshall Islands','MHL','OC','2080185','165.525','14.62','171.932','5.58764');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Macedonia','MKD','EU','718075','20.4647','42.3618','23.0381','40.8602');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mali','MLI','AF','2453866','-12.2426','25','4.24497','10.1595');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Myanmar','MMR','AS','1327865','92.1893','28.5433','101.177','9.78458');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mongolia','MNG','AS','2029969','87.7496','52.1543','119.924','41.5676');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Macao','MAC','AS','1821275','113.529','22.2223','113.566','22.1804');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Northern Mariana Islands','MNP','OC','4041467','145.127','18.8051','145.849','14.1074');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Martinique','MTQ','NA','3570311','-61.2301','14.8788','-60.8155','14.3923');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mauritania','MRT','AF','2378080','-17.0665','27.2981','-4.82767','14.7155');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Montserrat','MSR','NA','3578097','-62.2426','16.8173','-62.1464','16.671');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Malta','MLT','EU','2562770','14.1916','36.082','14.5776','35.8103');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mauritius','MUS','AF','934292','56.5127','-10.3193','63.5002','-20.5257');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Maldives','MDV','AS','1282028','72.6932','7.09836','73.6373','-0.692694');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Malawi','MWI','AF','927384','32.6739','-9.36754','35.9168','-17.125');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mexico','MEX','NA','3996063','-118.454','32.7168','-86.7034','14.5329');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Malaysia','MYS','AS','1733045','99.6434','7.36342','119.268','0.855222');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mozambique','MOZ','AF','1036973','30.2173','-10.4719','40.843','-26.8687');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Namibia','NAM','AF','3355338','11.7156','-16.9599','25.2567','-28.9714');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('New Caledonia','NCL','OC','2139685','163.565','-19.5498','168.129','-22.698');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Niger','NER','AF','2440476','0.16625','23.525','15.9956','11.697');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Norfolk Island','NFK','OC','2155115','167.916','-28.9924','168','-29.0527');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Nigeria','NGA','AF','2328926','2.66843','13.892','14.6801','4.27714');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Nicaragua','NIC','NA','3617476','-87.6903','15.0259','-82.7383','10.7075');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Netherlands','NLD','EU','2750405','3.36256','53.5122','7.22794','50.7539');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Norway','NOR','EU','3144096','4.65017','71.1881','30.9456','57.9779');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Nepal','NPL','AS','1282988','80.0563','30.4334','88.1993','26.3567');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Nauru','NRU','OC','2110425','166.899','-0.504306','166.945','-0.552333');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Niue','NIU','OC','4036232','-169.953','-18.9633','-169.781','-19.1456');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('New Zealand','NZL','OC','2186224','165.996','-29.2411','-176.276','-52.6076');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Oman','OMN','AS','286963','51.882','26.388','59.8366','16.6457');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Panama','PAN','NA','3703430','-83.0515','9.63752','-77.1741','7.19791');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Peru','PER','SA','3932488','-81.3268','-0.012977','-68.678','-18.3497');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('French Polynesia','PYF','OC','4020092','-152.877','-7.90357','-134.93','-27.6536');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Papua New Guinea','PNG','OC','2088628','140.843','-1.31864','155.963','-11.6579');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Philippines','PHL','AS','1694008','116.932','21.1206','126.602','4.64331');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Pakistan','PAK','AS','1168579','60.8786','37.097','77.8409','23.7867');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Poland','POL','EU','798544','14.123','54.8391','24.1508','49.0064');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Pierre and Miquelon','SPM','NA','3424932','-56.4207','47.1463','-56.253','46.786');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Pitcairn','PCN','OC','4030699','-128.346','-24.3159','-124.773','-24.6726');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Puerto Rico','PRI','NA','4566966','-67.9427','18.5202','-65.2427','17.9264');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Palestinian Territory','PSE','AS','6254930','34.2167','32.5464','35.5733','31.2165');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Portugal','PRT','EU','2264397','-9.49594','42.1456','-6.18269','36.9807');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Palau','PLW','OC','1559582','134.123','7.73211','134.654','6.88628');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Paraguay','PRY','SA','3437598','-62.6471','-19.294','-54.2593','-27.6087');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Qatar','QAT','AS','289688','50.7572','26.1547','51.6366','24.4829');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Reunion','REU','AF','935317','55.2191','-20.8569','55.845','-21.3722');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Romania','ROU','EU','798549','20.27','48.267','29.6911','43.6273');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Serbia','SRB','EU','6290252','18.817','46.1814','23.005','41.8558');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Russia','RUS','EU','2017370','19.25','81.8574','-169.05','41.1889');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Rwanda','RWA','AF','49518','28.8568','-1.05348','30.896','-2.84068');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saudi Arabia','SAU','AS','102358','34.4957','32.1583','55.6666','15.6142');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Solomon Islands','SLB','OC','2103350','155.509','-6.58961','166.981','-11.8506');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Seychelles','SYC','AF','241170','46.2048','-4.28372','56.2795','-9.75387');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Sudan','SDN','AF','366755','21.8389','23.1469','38.58','3.48639');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Sweden','SWE','EU','2661886','11.1187','69.0625','24.1609','55.3371');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Singapore','SGP','AS','1880251','103.638','1.47128','104.007','1.25856');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Helena','SHN','AF','3370751','-14.4212','-7.88781','-5.63875','-16.0195');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Slovenia','SVN','EU','3190538','13.3831','46.8779','16.566','45.4131');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Svalbard and Jan Mayen','SJM','EU','607072','17.6994','80.7621','33.2873','79.2203');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Slovakia','SVK','EU','3057568','16.8477','49.6032','22.5704','47.7281');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Sierra Leone','SLE','AF','2403846','-13.3076','10','-10.2842','6.92961');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('San Marino','SMR','EU','3168068','12.4019','43.9998','12.5156','43.8979');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Senegal','SEN','AF','2245662','-17.5352','16.6916','-11.3559','12.3073');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Somalia','SOM','AF','51537','40.9866','11.9792','51.4126','-1.67487');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Suriname','SUR','SA','3382998','-58.0866','6.00455','-53.9775','1.83114');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Sao Tome and Principe','STP','AF','2410758','6.47017','1.70132','7.46637','0.024766');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('El Salvador','SLV','NA','3585968','-90.1287','14.4451','-87.6922','13.1487');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Syria','SYR','AS','163843','35.7272','37.3191','42.385','32.3107');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Swaziland','SWZ','AF','934841','30.7941','-25.7196','32.1373','-27.3171');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Turks and Caicos Islands','TCA','NA','3576916','-72.4839','21.9619','-71.1236','21.4226');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Chad','TCD','AF','2434508','13.4735','23.4504','24.0027','7.44107');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('French Southern Territories','ATF','AN','1546748','50.1703','-37.7907','77.5988','-49.7352');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Togo','TGO','AF','2363686','-0.147324','11.139','1.80669','6.10442');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Thailand','THA','AS','1605651','97.3456','20.4632','105.639','5.61');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tajikistan','TJK','AS','1220409','67.3871','41.0423','75.1372','36.6741');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tokelau','TKL','OC','4031074','-172.5','-8.55361','-171.211','-9.38111');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('East Timor','TLS','OC','1966436','124.046','-8.13583','127.309','-9.46363');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Turkmenistan','TKM','AS','1218197','46.6846','47.0156','66.6843','35.1411');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tunisia','TUN','AF','2464461','7.52483','37.5439','11.5983','30.2404');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tonga','TON','OC','4032283','-175.682','-15.563','-173.908','-21.4551');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Turkey','TUR','AS','298795','25.6685','42.1076','44.835','35.8154');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Trinidad and Tobago','TTO','NA','3573591','-61.9238','11.3383','-60.5179','10.0361');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tuvalu','TUV','OC','2110297','176.119','-5.66875','178.699','-7.49436');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Taiwan','TWN','AS','1668284','119.535','25.2983','122','21.9018');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Tanzania','TZA','AF','149590','29.3272','-0.990736','40.4432','-11.7457');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Ukraine','UKR','EU','690791','22.1289','52.3694','40.2074','44.3904');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Uganda','UGA','AF','226074','29.5732','4.21443','35.0361','-1.48405');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('United States Minor Outlying Islands','UMI','OC','5854968','-176.645','18.421','-75','-0.389006');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('United States','USA','NA','6252001','-124.733','49.3886','-66.9548','24.5442');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Uruguay','URY','SA','3439705','-58.4427','-30.0822','-53.0739','-34.9808');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Uzbekistan','UZB','AS','1512440','55.9966','45.575','73.1323','37.1844');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Vatican','VAT','EU','3164670','12.4457','41.9074','12.4584','41.9003');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Saint Vincent and the Grenadines','VCT','NA','3577815','-61.4593','13.3778','-61.1139','12.581');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Venezuela','VEN','SA','3625428','-73.3541','12.2019','-59.8038','0.626311');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('British Virgin Islands','VGB','NA','3577718','-64.7154','18.7572','-64.2688','18.39');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('U.S. Virgin Islands','VIR','NA','4796775','-65.0382','18.3918','-64.5652','17.6817');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Vietnam','VNM','AS','1562822','102.148','23.3888','109.465','8.55961');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Vanuatu','VUT','OC','2134431','166.525','-13.0734','169.905','-20.2489');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Wallis and Futuna','WLF','OC','4034749','-178.207','-13.2142','-176.129','-14.3286');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Samoa','WSM','OC','4034894','-172.799','-13.4322','-171.416','-14.0409');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Yemen','YEM','AS','69543','42.5325','19.0023','54.5305','12.1111');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Mayotte','MYT','AF','1024031','45.038','-12.6489','45.293','-13.0001');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('South Africa','ZAF','AF','953987','16.458','-22.1266','32.896','-34.8398');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Zambia','ZMB','AF','895949','21.9994','-8.22436','33.7057','-18.0795');
INSERT INTO `country` (`countryName`,`isoAlpha3`,`continent`,`geonameId`,`bBoxWest`,`bBoxNorth`,`bBoxEast`,`bBoxSouth`) VALUES ('Zimbabwe','ZWE','AF','878675','25.237','-15.6088','33.0563','-22.4177');


