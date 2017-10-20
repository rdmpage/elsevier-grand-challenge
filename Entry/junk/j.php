<?php

/*

add entities

<!ENTITY mdash  "-" > <!ENTITY ndash  "-" > <!ENTITY deg  "°" > <!ENTITY prime  "'" > <!ENTITY Prime  '\"' >
<!ENTITY plusmn  "±" >

add namespaces

xmlns:ce='http://www.elsevier.com/ce'
xmlns:sb='http://www.elsevier.com/sb'
xmlns:xlink='http://www.w3.org/1999/xlink'
xmlns:mml = 'www.w3.org/1998/Math/MathML/'

*/


$str = '{
"doi":"10.1016/j.ympev.2007.06.006",
"pii":"S1055-7903(07)00209-6",
"atitle":"A molecular phylogeny of the genus Gammarus (Crustacea: Amphipoda) based on mitochondrial and nuclear gene sequences",
"authors":[
{"forename":"Zhonge", "surname":"Hou"},
{"forename":"Jinzhong", "surname":"Fu"},
{"forename":"Shuqiang", "surname":"Li", "email":"lisq@ioz.ac.cn"}
],

"figures":[
{
"id":"fig1",
"label":"Fig. 1",
"caption":"Sampling sites of gammarids examined in this study. Square, Europe-North America species; triangle, species of the northwest group; circle, species of the southeast group."
},
{
"id":"fig2",
"label":"Fig. 2",
"caption":"Strict consensus tree of the most parsimonious trees from the combined analysis of COI, 16S, 18S and 28S genes. Numbers above the lines are bootstrap values. Vertical bars on the right depict major clades and grouping. Sinogammarus species is underlined."
},
{
"id":"fig3",
"label":"Fig. 3",
"caption":"The 50% majority rule consensus tree from the Bayesian analysis of the combined data (COI, 16S, 18S and 28S genes). Numbers above the lines are Bayesian posterior probabilities. Vertical bars on the right depict major clades and grouping. (P)=Gammarus pulex group, (B)=G. balcanicus group, (R)=G. roeseli group. (L)=G. locusta group. Sinogammarus species is underlined."
},
{
"id":"fig4",
"label":"Fig. 4",
"caption":"Strict consensus tree of the most parsimonious trees from the analysis of the 18S gene data. Numbers above the lines are bootstrap values. Vertical bars on the right depict major clades and grouping. Sinogammarus species is underlined."
},
{
"id":"fig5",
"label":"Fig. 5",
"caption":"Strict consensus tree of the most parsimonious trees from the analysis of the 28S gene data. Numbers above the lines are bootstrap values. Vertical bars on the right depict major clades and grouping. Sinogammarus species is underlined."
},
{
"id":"fig6",
"label":"Fig. 6",
"caption":"Strict consensus tree of the most parsimonious trees from the analysis of the mitochondrial genes (COI and 16S genes). Numbers above the lines are bootstrap values. Vertical bars on the right depict major clades and grouping. Sinogammarus species is underlined."
}
],

"tables":[
{
"label":"Table 1",
"caption":"Species information and GenBank accession numbers",
"header":[
["Species+","Locality+","Longitude/latitude+","Voucher number+","GenBank Accession Nos.","-","-","-"],
["COI","16S","18S","28S"]
],
"rows":[
["Gammarus abstrusus Hou, Platvoet and Li, 2006","Lushan, Sichuan, China","102.97E/30.28N","IZCASIA0344","EF570304","EF582855","EF582903","EF582950"],
["Gammarus accretus (Hou and Li, 2002)","Chishui, Guizhou, China","107.0E/28.7N","IZCASIA0480","EF570298","EF582848","","EF582942"],
["Gammarus aequicauda (Martynov, 1931)","Black Sea","","","AY926667a","AY926718a","AY926778a, AY926840a",""],
["Gammarus annulatus Smith, 1873","Massachusetts, USA","","","AY926668a","AY926719a","AY926779a, AY926841a",""],
["Gammarus balcanicus Schaferna, 1923","Alma-Ata, Kazahstan","","","","AY926720a","AY926780a, AY926842a",""],
["Gammarus bousfieldi Cole and Minckley, 1961","Monroe, Illinois, USA","90.2343W/38.2522N","IZCASIA0670","EF570299","EF582849","EF582899","EF582943"],
["Gammarus brevipodus (Hou et al., 2004)","Bayanbulak, Xinjiang, China","84.1E/43.0N","IZCASIA0437","","","","EF582944"],
["Gammarus comosus Hou, Li and Gao, 2005","Tongzhi, Guizhou, China","106.7E/28.2N","IZCASIA0406","EF570300","EF582850","EF582900","EF582945"],
["Gammarus craspedotrichus (Hou and Li, 2002)","Chishui, Guizhou, China","105.7E/28.5N","IZCASIA0463","EF570301","EF582851","","EF582946"],
["Gammarus crinicornis Stock, 1966","Egypt","","IZCASIA0664","","EF582852","EF582901","EF582947"],
["Gammarus curvativus Hou and Li, 2003","Dechang, Sichuan, China","102.31E/27.34N","IZCASIA0418","EF570302","EF582853","EF582902","EF582948"],
["Gammarus decorosus Meng, Hou and Li, 2003","Urumqi, Xinjiang, China","87.6E/43.7N","IZCASIA0079","EF570303","EF582854","","EF582949"],
["Gammarus daiberi Bousfield, 1969","","","","DQ300255d","","",""],
["Gammarus duebeni Liljeborg, 1852-MA","Maine, USA","","","AY926669a","","AY926781a, AY926843a",""],
["Gammarus duebeni Liljeborg, 1852-SC1","Isle of Great Cumbrae, Scotland","","","","","AF356545b",""],
["Gammarus duebeni Liljeborg, 1852-SC2","Isle of Great Cumbrae, Scotland","","","","","AF419226b",""],
["Gammarus duebeni Liljeborg, 1852-SC3","Isle of Great Cumbrae, Scotland","","","","","AF419227b",""],
["Gammarus electrus Hou and Li, 2003","Haidian, Beijing, China","116.4E/39.9N","IZCASIA0302","EF570305","EF582856","","EF582951"],
["Gammarus elevatus (Hou et al., 2002)","Jianchuan, Yunnan, China","99.8E/26.5N","IZCASIA0538","","","","EF582952"],
["Gammarus emeiensis Hou, Li and Koenemann, 2002","Lushan, Sichuan, China","102.97E/30.28N","IZCASIA0343","EF570306","EF582857","EF582904","EF582953"],
["Gammarus fasciatus Say, 1818-MN","Duluth, Minnesota, USA","93.087W/45.027N","IZCASIA0661","","EF582858","EF582905","EF582954"],
["Gammarus fasciatus Say, 1818-WA","Washington, DC, USA","","","","AY926721a","AY926782a, AY926844a",""],
["Gammarus fossarum Koch, 1835-PO","Nowy Korczyn, Poland","20.8E/50.32N","IZCASIA0649","","AJ269601e","EF582906","EF582955"],
["Gammarus fossarum Koch, 1835-DOE","","","","","AJ269618e","",""],
["Gammarus glabratus Hou and Li, 2003","Dafang, Guizhou, China","105.7E/27.0N","IZCASIA0398","EF570307","EF582859","EF582907","EF582956"],
["Gammarus gonggaensis (Hou, 2002)-BX1","Baoxing, Sichuan, China","102.8E/30.3N","IZCASIA0028","EF570309","EF582861","EF582909","EF582958"],
["Gammarus gonggaensis (Hou, 2002)-BX2","Baoxing, Sichuan, China","102.7E/30.6N","IZCASIA0055","EF570310","EF582862","EF582910","EF582959"],
["Gammarus gregoryi Tattersall, 1924","Yunlong, Yunnan, China","99.3E/25.9N","IZCASIA0579","EF570311","EF582863","EF582911","EF582960"],
["Gammarus kangdingensis (Hou, 2002)","Danba, Sichuan, China","101.9E/30.8N","IZCASIA0196","EF570313","EF582865","EF582913","EF582962"],
["Gammarus koreanus Ueno, 1940","Jian, Jilin, China","126.5E/43.8N","IZCASIA0336","EF570314","EF582866","EF582914","EF582963"],
["Gammarus lacustris Sars, 1863-BJ1","Fangshan, Beijing, China","115.8E/39.5N","IZCASIA0323","EF570317","EF582867","EF582915","EF582964"],
["Gammarus lacustris Sars, 1863-QH1","Hoh Xil, Qinghai, China","93.6E/35.43N","IZCASIA0340","EF570320","EF582868","","EF582965"],
["Gammarus lacustris Sars, 1863-QH2","Hoh Xil, Qinghai, China","93.6E/35.43N","IZCASIA0339","EF570319","","",""],
["Gammarus lacustris Sars, 1863-NA","Blue Pond, Manitoba, Canada","","","AY529052c","","","AY529073c"],
["Gammarus lacustris Sars, 1863-BK","Olkhon Island, Lake Baikal","","","AY926671a","AY926723a","AY926784a, AY926846a",""],
["Gammarus lacustris Sars, 1863-HV","Lake Hovsgol, Mongolia","","","AY926670a","AY926722a","AY926783a, AY926845a",""],
["Gammarus lacustris Sars, 1863-VI","Vancouver Island, CA","","","AY926672a","AY926724a","AY926785a, AY926847a",""],
["Gammarus lacustris Sars, 1863-WA","Washington, USA","","","AY926673a","AY926725a","AY926786a, AY926848a",""],
["Gammarus lacustris Sars, 1863-BJ2","Fangshan, Beijing, China","115.8E/39.5N","IZCASIA0326","EF570318","EF582869","",""],
["Gammarus lacustris Sars, 1863-BJ3","Yanqing, Beijing, China","115.9E/40.4N","IZCASIA0292","EF570315","","",""],
["Gammarus lacustris Sars, 1863-XJ","Altun, Xinjiang, China","90.3E/38.2N","IZCASIA0423","EF570321","","",""],
["Gammarus lacustris Sars, 1863-TB","Xainza, Tibet, China","88.6E/30.9N","IZCASIA0618","EF570322","","",""],
["Gammarus lacustris Sars, 1863-QH3","Haixi, Qinghai, China","97.2E/37.3N","IZCASIA0624","EF570323","","",""],
["Gammarus lichuanensis (Hou and Li, 2002)-HB1","Lichuan, Hubei, China","109.09E/30.52N","IZCASIA0335","EF570356","EF582895","EF582938","EF583002"],
["Gammarus lichuanensis (Hou and Li, 2002)-HB2","Lichuan, Hubei, China","109.09E/30.52N","IZCASIA0604","EF570357","","","EF583003"],
["Gammarus liui (Hou, 2002)","Shenmu, Shaanxi, China","110.4E/38.8N","IZCASIA0548","","","","EF582966"],
["Gammarus locusta (Linnaeus, 1758)-CA","Creswell Bay, Canada","93.42W/72.77N","IZCASIA0663","EF570324","EF582870","EF582916","EF582967"],
["Gammarus locusta (Linnaeus, 1758)-FR","Roscoff, FR","","","","AY926726a","AY926787a, AY926849a",""],
["Gammarus locusta (Linnaeus, 1758)-BS","Baltic Sea","","","","","AF419222b",""],
["Gammarus madidus Hou and Li, 2005","Laiyuan, Hebei, China","115.7E/39.4N","IZCASIA0310","","","","EF582968"],
["Gammarus martensi (Hou and Li, 2004)","Zhouzhi, Shaanxi, China","108.16E/34.02N","IZCASIA0415","EF570325","EF582871","EF582917","EF582969"],
["Gammarus minus Say, 1818-IL","Monroe, Illinois, USA","90.2473W/38.2525N","IZCASIA0674","EF570326","EF582872","EF582918","EF582970"],
["Gammarus minus Say, 1818","","","","","AF228046g","",""],
["Gammarus montanus (Hou et al., 2004)","Zhaosu, Xinjiang, China","81.1E/43.1N","IZCASIA0432","EF570327","EF582873","EF582919","EF582971"],
["Gammarus mucronatus Say, 1818","Chesapeake Bay, USA","","","","AY926727a","AY926788a, AY926850a",""],
["Gammarus nekkensis Uchida, 1935-HB1","Chengde, Hebei, China","116.9E/41.03N","IZCASIA0048","EF570328","EF582874","EF582920","EF582972"],
["Gammarus nekkensis Uchida, 1935-BJ1","Mentougou, Beijing, China","115.4E/40.0N","IZCASIA0511","EF570330","","","EF582973"],
["Gammarus nekkensis Uchida, 1935-BJ2","Mentougou, Beijing, China","115.4E/40.0N","IZCASIA0059","EF570331","EF582875","EF582921","EF582974"],
["Gammarus nekkensis Uchida, 1935-BJ3","Mentougou, Beijing, China","115.4E/40.0N","IZCASIA0051","EF570329","","",""],
["Gammarus nekkensis Uchida, 1935-BJ4","Yanqing, Beijing, China","116.2E/40.6N","IZCASIA0314","EF570316","","",""],
["Gammarus nekkensis Uchida, 1935-HB2","Yangyuan, Hebei, China","114.1E/40.1N","IZCASIA0355","EF570343","","",""],
["Gammarus nipponensis Ueno, 1940","Yoshinogawa, Tokushima, Japan","134.0E/34.262N","IZCASIA0646","EF570312","EF582864","EF582912","EF582961"],
["Gammarus oceanicus Segerstrale, 1947","Massachusetts, USA","","","AY926674a","AY926728a","AY926789a, AY926851a",""],
["Gammarus pengi (Hou, 2002)","Tianjun, Qinghai, China","99.0E/37.3N","IZCASIA0509","","","","EF582975"],
["Gammarus pexus Hou and Li, 2005","Benxi, Liaoning, China","123.7E/41.3N","IZCASIA0523","EF570332","","","EF582976"],
["Gammarus pseudolimnaeus Bousfield, 1958-IL","Monroe, Illinois, USA","90.2203W/38.3302N","IZCASIA0669","EF570333","EF582876","EF582922","EF582977"],
["Gammarus pseudolimnaeus Bousfield, 1958-VI","Virginia, USA","","","","AY926729a","",""],
["Gammarus pulex (Linnaeus, 1758)-NL","Netherlands","4.88E/52.37N","IZCASIA0610","EF570334","EF582877","EF582923","EF582978"],
["Gammarus pulex (Linnaeus, 1758)-GP1","","","","","AJ269626e","",""],
["Gammarus pulex (Linnaeus, 1758)-GP2","","","","","AJ269627e","",""],
["Gammarus pulex (Linnaeus, 1758)-GM","Bielefeld, Schwarzbach, Germany","","","","","AF202982b",""],
["Gammarus pulex (Linnaeus, 1758)-SC","Isle of Great Cumbrae, Scotland","","","","","AF419225b",""],
["Gammarus qiani (Hou and Li, 2002)","Zhaotong, Yunnan, China","103.28E/27.31N","IZCASIA0413","EF570335","EF582878","EF582924","EF582979"],
["Gammarus riparius (Hou and Li, 2002)","Xuanen, Hubei, China","109.4E/29.9N","IZCASIA0510","EF570336","","","EF582980"],
["Gammarus roeseli Gervais, 1835","Pram, Austria","14.3E/48.31N","IZCASIA0633","EF570337","EF582879","EF582925","EF582981"],
["Gammarus shanxiensis Barnard and Dai, 1988","Yangcheng, Shanxi, China","112.4E/35.5N","IZCASIA0519","","","","EF582982"],
["Gammarus shenmuensis (Hou and Li, 2004)","Shenmu, Shaanxi, China","110.4E/38.8N","IZCASIA0512","","","","EF582983"],
["Gammarus salinus Spooner, 1942","","","","","","AF356544b",""],
["Gammarus sichuanensis (Hou, Li and Zheng, 2002)","Jiuzhaigou, Sichuan, China","103.9E/33.2N","IZCASIA0011","EF570338","EF582880","","EF582984"],
["Gammarus sinuolatus (Hou and Li, 2004)","Danba, Sichuan, China","101.9E/30.8N","IZCASIA0195","EF570339","EF582881","EF582926","EF582985"],
["Gammarus sp1","Jiulong, Sichuan, China","101.4E/29.1N","IZCASIA0171","EF570308","EF582860","EF582908","EF582957"],
["Gammarus sp2","Laiyuan, Hebei, China","114.7E/39.3N","IZCASIA0315","EF570340","EF582882","EF582927","EF582986"],
["Gammarus sp3","Laiyuan, Hebei, China","114.6E/39.2N","IZCASIA0317","EF570341","EF582883","EF582928","EF582987"],
["Gammarus sp4","Fangshan, Beijing, China","115.7E/39.7N","IZCASIA0318","EF570342","EF582884","EF582929","EF582988"],
["Gammarus sp5","Nanyang, Henan, China","111.93E/33.52N","IZCASIA0570","","EF582885","EF582930","EF582989"],
["Gammarus sp6","Wenxian, Gansu, China","104.6E/33.0N","IZCASIA0520","EF570344","EF582886","EF582896","EF582939"],
["Gammarus stalagmiticus Hou and Li, 2005","Benxi, Liaoning, China","123.7E/41.3N","IZCASIA0524","EF570345","","","EF582990"],
["Gammarus takesensis (Hou et al., 2004)","Takes, Xinjiang, China","81.0E/43.2N","IZCASIA0425","EF570346","EF582887","EF582931","EF582991"],
["Gammarus taliensis Shen, 1954","Dali, Yunnan, China","100.2E/25.7N","IZCASIA0572","","EF582888","","EF582992"],
["Gammarus tastiensis (Hou, 2002)","Yumin, Xinjiang, China","82.9E/46.2N","IZCASIA0563","EF570347","EF582889","","EF582993"],
["Gammarus tigrinus Sexton, 1939","Netherlands","4.88E/52.37N","IZCASIA0609","EF570348","EF582890","EF582932","EF582994"],
["Gammarus translucidus (Hou and Li, 2004)","Suiyang, Guizhou, China","106.8E/27.2N","IZCASIA0403","EF570349","EF582891","","EF582995"],
["Gammarus troglophilus (Hubricht and Mackin, 1940)-IL","Monroe, Illinois, USA","90.22W/38.33N","IZCASIA0672","EF570350","EF582892","EF582933","EF582996"],
["Gammarus troglophilus (Hubricht and Mackin, 1940)-LO","St. Louis Co., MO, USA","90.551W/38. 517N","","","","AF202983b",""],
["Sinogammarus chuanhui (Hou and Li, 2002)-GZ","Meitan, Guizhou, China","107.493E/27.769N","IZCASIA0666","EF570355","EF582894","EF582937","EF583000"],
["Sinogammarus chuanhui (Hou and Li, 2002)-SC","Nanchuan, Sichuan, China","103.5E/28.9N","IZCASIA0018","EF570354","EF582893","","EF583001"],
["Dikerogammarus villosus Sowinsky, 1894-GM","Havel Brandenburg, Germany","12.53E/52.41N","IZCASIA0676","EF570297","AY926706a","EF582898","EF582941"],
["Dikerogammarus villosus Sowinsky, 1894-BK","Black Sea","","","AY529048c","","",""],
["Dikerogammarus villosus Sowinsky, 1894-CE","","","","","AJ440901f","",""],
["Jesogammarus (Annanogammarus) debilis Hou and Li, 2005","Fangshan, Beijing, China","115.8E/39.5N","IZCASIA0325","EF570351","EF582846","EF582934","EF582997"],
["Jesogammarus (J.) hebeiensis (Hou and Li, 2004)","Yanqing, Beijing, China","115.9E/40.4N","IZCASIA0294","EF570352","EF582847","EF582935","EF582998"],
["Crangonyx serratus (Embody, 1910)","USA","","","","AY926703a","",""],
["Crangonyx forbesi (Hubricht and Mackin, 1940)","St. Louis Co., MO, USA","90.708W/38.616N","","","","AF202980b",""],
["Crangonyx pseudogracilis Bousfield, 1958","Guelph, Ontario, Canada","80.2W/43.35N","IZCASIA0637","EF570296","EF582845","EF582897","EF582940"],
["Crangonyx sp","","","","AY529053c","","",""],
["Platorchestia japonica (Tattersall, 1922)","Hengshui, Hebei, China","115.59E/37.64N","IZCASIA0338","EF570353","EF582844","EF582936","EF582999"]
]
}
,
{
"label":"Table 2",
"caption":"Primers used for amplification and sequencing in this study",
"header":[
["Gene","Primer","Sequence (5\'-3\')","Reference"]
],
"rows":[
["COI","LCO1490","GGTCAACAAATCATAAAGATATTGG","Folmer et al. (1994)"],
["","HCO2198","TAAACTTCAGGGTGACCAAAAAATCA","Folmer et al. (1994)"],
["16S rRNA","12S-1G","GTGGATCCATTAGATACCC","Berschick (1997)"],
["","12-2F","GTACAAATTGCCCGTCARTCTC","This study"],
["","16Sbr","CCGGTTTGAACTCAGATCATGT","Palumbi (1996)"],
["","16STf","GGTAWHYTRACYGTGCTAAG","Macdonald et al. (2005)"],
["","16S-650R","CCAGCTACCAATTAAAAARC","This study"],
["18S rRNA","18SF","CCTAYCTGGTTGATCCTGCCAGT","Englisch et al. (2003)"],
["","18SR","TAATGATCCTTCCGCAGGTT","Englisch et al. (2003)"],
["","18SGF","GGATAACTGTGGTAATTCCAGAGCT","This study"],
["","18SGR-1","TGCACCAGTTCGGACCTCTTTC","This study"],
["","18SGR-2","TAGTAGCGACGGGCGGTGTGTA","This study"],
["","18S-1155F","GCTGAAACTTAAAGGAATTGACGG","This study"],
["","18S-1250R","CACTCCACCAACTAAGAACGGC","This study"],
["","18S-750F","TATCGAGCGCAGRTCAGGTGGAC","This study"],
["","18S-800R","ACGGGGGTGTGTGGAAAAGC","This study"],
["28S","28Sa","TTGGCGACCCGCAATTTAAGCAT","Cristescu and Hebert (2005)"],
["","28Sb","CCTGAGGGAAACTTCGGAGGGAAC","Cristescu and Hebert (2005)"],
["","28F","TTAGTAGGGGCGACCGAACAGGGAT","This study"],
["","28R","GTCTTTCGCCCCTATGCCCAACTGA","This study"],
["","28S-700F","AAGACGCGATAACCAGCCCACCA","This study"],
["","28S-1000R","GACCGATGGGCTTGGACTTTACACC","This study"]
]
}
],
"bibliography":[
{
"genre":"article",
"date":"2005",
"volume":"21",
"title":"Cladistics",
"spage":"575",
"epage":"596",
"authors":[
{"forename":"A.", "surname":"Audzijonyte"},
{"forename":"J.", "surname":"Damgaard"},
{"forename":"S.L.", "surname":"Varvio"},
{"forename":"J.K.", "surname":"Vainio"},
{"forename":"R.", "surname":"Vinl"}
],
"atitle":"Phylogeny of Mysis (Crustacea, Mysida): history of continental invasions inferred from molecular and morphological data",
"id":"bib1"

}
,
{
"genre":"article",
"date":"1997",
"volume":"46",
"title":"Syst. Biol.",
"spage":"654",
"epage":"673",
"authors":[
{"forename":"R.H.", "surname":"Baker"},
{"forename":"R.", "surname":"DeSalle"}
],
"atitle":"Multiple sources of character information and the phylogeny of Hawaiian Drosophilids",
"id":"bib2"

}
,
{
"genre":"article",
"date":"2001",
"volume":"50",
"title":"Syst. Biol.",
"spage":"87",
"epage":"105",
"authors":[
{"forename":"R.H.", "surname":"Baker"},
{"forename":"G.S.", "surname":"Wilkinson"},
{"forename":"R.", "surname":"DeSalle"}
],
"atitle":"Phylogenetic utility of different types of molecular data used to infer evolutionary relationships among stalk-eyed flies (Diopsidae)",
"id":"bib3"

}
,
{
"genre":"book",
"date":"1983",
"publisher":"Hayfield Associates",
"publoc":"Mt. Vernon, VA",
"authors":[
{"forename":"J.L.", "surname":"Barnard"},
{"forename":"C.M.", "surname":"Barnard"}
],
"atitle":"Freshwater Amphipoda of the World I & II",
"id":"bib4"

}
,
{
"genre":"article",
"date":"1997",
"volume":"23",
"title":"Biotechniques",
"spage":"494",
"epage":"498",
"authors":[
{"forename":"P.", "surname":"Berschick"}
],
"atitle":"One primer pair amplifies small subunit ribosomal DNA from mitochondria, plastids and bacteria",
"id":"bib5"

}
,
{
"genre":"article",
"date":"1977",
"volume":"4",
"title":"Crustaceana Suppl.",
"spage":"282",
"epage":"316",
"authors":[
{"forename":"E.L.", "surname":"Bousfield"}
],
"atitle":"A new look at the systematics of gammaroidean amphipods of the world",
"id":"bib6"

}
,
{
"genre":"article",
"date":"1993",
"volume":"361",
"title":"Nature",
"spage":"344",
"epage":"345",
"authors":[
{"forename":"T.E.", "surname":"Cerling"},
{"forename":"Y.", "surname":"Wang"},
{"forename":"J.", "surname":"Quade"}
],
"atitle":"Expansion of C4 ecosystems as an indicator of global ecological changes in the Late Miocene",
"id":"bib7"

}
,
{
"genre":"article",
"date":"2004",
"volume":"31",
"title":"Mol. Phylogenet. Evol.",
"spage":"300",
"epage":"307",
"authors":[
{"forename":"Y.", "surname":"Chen"},
{"forename":"H.", "surname":"Xiao"},
{"forename":"J.", "surname":"Fu"},
{"forename":"D.W.", "surname":"Huang"}
],
"atitle":"A molecular phylogeny of eurytomid wasps inferred from DNA sequence data of 28S, 18S, 16S and COI genes",
"id":"bib8"

}
,
{
"genre":"article",
"date":"1998",
"volume":"394",
"title":"Nature",
"spage":"769",
"epage":"773",
"authors":[
{"forename":"S.L.", "surname":"Chung"},
{"forename":"C.H.", "surname":"Lo"},
{"forename":"T.Y.", "surname":"Lee"},
{"forename":"Y.", "surname":"Zhang"},
{"forename":"Y.", "surname":"Xie"},
{"forename":"X.", "surname":"Li"},
{"forename":"K.L.", "surname":"Wang"},
{"forename":"P.L.", "surname":"Wang"}
],
"atitle":"Diachronous uplift of the Tibetan Plateau staring 40 Mys ago",
"id":"bib9"

}
,
{
"genre":"article",
"date":"1998",
"volume":"46",
"title":"J. Mol. Evol.",
"spage":"307",
"epage":"313",
"authors":[
{"forename":"T.J.", "surname":"Crease"},
{"forename":"J.K.", "surname":"Colbourne"}
],
"atitle":"The unusually long small-subunit ribosomal RNA of the crustacean, Daphnia pulex: sequence and predicted secondary structure",
"id":"bib10"

}
,
{
"genre":"article",
"date":"2005",
"volume":"62",
"title":"Can. J. Fish. Aquat. Sci.",
"spage":"505",
"epage":"517",
"authors":[
{"forename":"M.E.A.", "surname":"Cristescu"},
{"forename":"P.D.N.", "surname":"Hebert"}
],
"atitle":"The Crustacean Seas-an evolutionary perspective on the Ponto-Caspian peracarids",
"id":"bib11"

}
,
{
"genre":"article",
"date":"2001",
"volume":"1",
"title":"Org. Divers. Evol.",
"spage":"139",
"epage":"145",
"authors":[
{"forename":"U.", "surname":"Englisch"},
{"forename":"S.", "surname":"Koenemann"}
],
"atitle":"Preliminary phylogenetic analysis of selected subterranean amphipod crustaceans, using small subunit rDNA gene sequences",
"id":"bib12"

}
,
{
"genre":"article",
"date":"2003",
"volume":"37",
"title":"J. Nat. Hist.",
"spage":"2461",
"epage":"2486",
"authors":[
{"forename":"U.", "surname":"Englisch"},
{"forename":"C.O.", "surname":"Coleman"},
{"forename":"J.W.", "surname":"Wgele"}
],
"atitle":"First observations on the phylogeny of the families Gammaridae, Crangonyctidae, Melitidae, Niphargidae, Megaluropidae and Oedicerotidae (Amphipoda, Crustacea), using small subunit rDNA gene sequences",
"id":"bib13"

}
,
{
"genre":"article",
"date":"1995",
"volume":"44",
"title":"Syst. Biol.",
"spage":"570",
"epage":"572",
"authors":[
{"forename":"J.S.", "surname":"Farris"},
{"forename":"M.", "surname":"Kallersjo"},
{"forename":"A.G.", "surname":"Kluge"},
{"forename":"C.", "surname":"Bult"}
],
"atitle":"Constructing a significance test for incongruence",
"id":"bib14"

}
,
{
"genre":"article",
"date":"1985",
"volume":"39",
"title":"Evolution",
"spage":"783",
"epage":"791",
"authors":[
{"forename":"J.", "surname":"Felsenstein"}
],
"atitle":"Confidence limits on phylogenies: an approach using the bootstrap",
"id":"bib15"

}
,
{
"genre":"article",
"date":"1995",
"volume":"26",
"title":"Annu. Rev. Ecol. Syst.",
"spage":"249",
"epage":"268",
"authors":[
{"forename":"D.W.", "surname":"Fong"},
{"forename":"T.C.", "surname":"Kane"},
{"forename":"D.C.", "surname":"Culver"}
],
"atitle":"Vestigialization and loss of nonfunctional characters",
"id":"bib16"

}
,
{
"genre":"article",
"date":"1994",
"volume":"3",
"title":"Mol. Mar. Biol. Biotechnol.",
"spage":"294",
"epage":"299",
"authors":[
{"forename":"O.", "surname":"Folmer"},
{"forename":"M.", "surname":"Black"},
{"forename":"W.", "surname":"Hoeh"},
{"forename":"R.", "surname":"Vrijenhoek"}
],
"atitle":"DNA primers for amplification of mitochondrial cytochrome c oxidase subunit I from diverse metazoan invertebrates",
"id":"bib17"

}
,
{
"genre":"article",
"date":"2003",
"volume":"19",
"title":"Cladistics",
"spage":"379",
"epage":"418",
"authors":[
{"forename":"T.", "surname":"Grant"},
{"forename":"G.", "surname":"Kluge"}
],
"atitle":"Data exploration in phylogenetic inference: scientific, heuristic, or neither",
"id":"bib18"

}
,
{
"genre":"article",
"date":"1992",
"volume":"255",
"title":"Science",
"spage":"1663",
"epage":"1670",
"authors":[
{"forename":"T.M.", "surname":"Harrison"},
{"forename":"P.", "surname":"Copeland"},
{"forename":"W.S.F.", "surname":"Kidd"},
{"forename":"A.", "surname":"Yin"}
],
"atitle":"Raising Tibet",
"id":"bib19"

}
,
{
"spage":"321",
"epage":"381",
"genre":"chapter",
"editors":[
{"forename":"D.M.", "surname":"Hillis"},
{"forename":"C.", "surname":"Moritz"},
{"forename":"B.K.", "surname":"Mable"}
],
"title":"Molecular Systematics",
"date":"1996",
"publisher":"Sinauer Associates",
"publoc":"Sunderland, MA",
"authors":[
{"forename":"D.M.", "surname":"Hillis"},
{"forename":"B.K.", "surname":"Mable"},
{"forename":"A.", "surname":"Larson"},
{"forename":"S.K.", "surname":"Davis"},
{"forename":"E.A.", "surname":"Zimmer"}
],
"atitle":"Nucleic Acids IV: sequencing and cloning",
"id":"bib20"

}
,
{
"description":"Hou, Z., 2002. Systematics of Chinese Freshwater Amphipoda. Ph.D. Dissertation. Graduate University of Chinese Academy of Sciences, Beijing.",
"id":"bib21"

}
,
{
"genre":"article",
"date":"2002",
"volume":"50",
"title":"Raffles B. Zool.",
"spage":"27",
"epage":"36",
"authors":[
{"forename":"Z.", "surname":"Hou"},
{"forename":"S.", "surname":"Li"}
],
"atitle":"Two new species of troglobitic amphipod crustaceans (Gammaridae) from Hubei Province, China",
"id":"bib22"

}
,
{
"genre":"article",
"date":"2004",
"volume":"52",
"title":"Raffles B. Zool.",
"spage":"147",
"epage":"170",
"authors":[
{"forename":"Z.", "surname":"Hou"},
{"forename":"S.", "surname":"Li"}
],
"atitle":"Gammarus species from Tibet Plateau, China (Crustacea: Amphipoda: Gammaridae)",
"id":"bib23"

}
,
{
"genre":"article",
"date":"2002",
"volume":"19",
"title":"Zool. Sci.",
"spage":"939",
"epage":"960",
"authors":[
{"forename":"Z.", "surname":"Hou"},
{"forename":"S.", "surname":"Li"},
{"forename":"H.", "surname":"Morino"}
],
"atitle":"Three new species of the genus Gammarus (Crustacea, Amphipoda, Gammaridae) from Yunnan, China",
"id":"bib24"

}
,
{
"genre":"article",
"date":"2004",
"volume":"111",
"title":"Rev. Suisse Zool.",
"spage":"257",
"epage":"284",
"authors":[
{"forename":"Z.", "surname":"Hou"},
{"forename":"S.", "surname":"Li"},
{"forename":"D.", "surname":"Platvoet"}
],
"atitle":"Three new species of the genus Gammarus from Ili River, China",
"id":"bib25"

}
,
{
"genre":"article",
"date":"1984",
"volume":"4",
"title":"Montenegrin Acad. Sci. Arts. Glasnik. Sec. Nat. Sci.",
"spage":"139",
"epage":"162",
"authors":[
{"forename":"G.S.", "surname":"Karaman"}
],
"atitle":"Remarks to the freshwater Gammarus species (Fam. Gammaridae) from Korea, China, Japan and some adjacent regions (Contribution to the knowledge of the Amphipoda 134)",
"id":"bib26"

}
,
{
"genre":"article",
"date":"1977",
"volume":"47",
"title":"Bijdr. Dierk.",
"spage":"1",
"epage":"97",
"authors":[
{"forename":"G.S.", "surname":"Karaman"},
{"forename":"S.", "surname":"Pinkster"}
],
"atitle":"Freshwater Gammarus species from Europe, North Africa and adjacent regions of Asia (Crustacea-Amphipoda). Part I. Gammarus pulex-group and related species",
"id":"bib27"

}
,
{
"genre":"article",
"date":"1977",
"volume":"47",
"title":"Bijdr. Dierk.",
"spage":"165",
"epage":"196",
"authors":[
{"forename":"G.S.", "surname":"Karaman"},
{"forename":"S.", "surname":"Pinkster"}
],
"atitle":"Freshwater Gammarus species from Europe, North Africa and adjacent regions of Asia (Crustacea-Amphipoda).Part II. Gammarus roeseli-group and related species",
"id":"bib28"

}
,
{
"genre":"article",
"date":"1987",
"volume":"57",
"title":"Bijdr. Dierk.",
"spage":"207",
"epage":"260",
"authors":[
{"forename":"G.S.", "surname":"Karaman"},
{"forename":"S.", "surname":"Pinkster"}
],
"atitle":"Freshwater Gammarus species from Europe, North Africa and adjacent regions of Asia (Crustacea-Amphipoda). Part III. Gammarus balcanicus-group and related species",
"id":"bib29"

}
,
{
"genre":"article",
"date":"1995",
"volume":"23",
"title":"Int. J. Speleol.",
"spage":"157",
"epage":"171",
"authors":[
{"forename":"G.S.", "surname":"Karaman"},
{"forename":"S.", "surname":"Ruffo"}
],
"atitle":"Sinogammarus troglodytes n. gen. n. sp. A new troglobiont gammarid from China (Crustacea: Amphipoda)",
"id":"bib30"

}
,
{
"genre":"article",
"date":"2006",
"title":"Evolution",
"spage":"257",
"epage":"267",
"authors":[
{"forename":"D.W.", "surname":"Kelly"},
{"forename":"H.J.", "surname":"MacIsaac"},
{"forename":"D.D.", "surname":"Heath"}
],
"atitle":"Vicariance and dispersal effects on phylogeographic structure and speciation in a widespread estuarine invertebrate",
"id":"bib31"

}
,
{
"genre":"article",
"date":"1998",
"volume":"265",
"title":"Proc. R. Soc. Lond. B Biol. Sci.",
"spage":"2257",
"epage":"2263",
"authors":[
{"forename":"N.", "surname":"Knowlton"},
{"forename":"L.A.", "surname":"Weigt"}
],
"atitle":"New date and new rates for divergence across the Isthmus of Panama",
"id":"bib32"

}
,
{
"genre":"article",
"date":"1993",
"volume":"260",
"title":"Science",
"spage":"1629",
"epage":"1632",
"authors":[
{"forename":"N.", "surname":"Knowlton"},
{"forename":"L.A.", "surname":"Weigt"},
{"forename":"L.A.", "surname":"Solorzan"},
{"forename":"D.K.", "surname":"Mills"},
{"forename":"E.", "surname":"Bermingham"}
],
"atitle":"Divergence in proteins, mitochondrial DNA, and reproductive compatibility across the Isthmus of Panama",
"id":"bib33"

}
,
{
"genre":"article",
"date":"1999",
"volume":"44",
"title":"Chin. Sci. Bull.",
"spage":"2117",
"epage":"2124",
"authors":[
{"forename":"J.J.", "surname":"Li"},
{"forename":"X.M.", "surname":"Fang"}
],
"atitle":"Uplift of the Tibetan Plateau and environmental changes",
"id":"bib34"

}
,
{
"genre":"article",
"date":"2005",
"volume":"35",
"title":"Mol. Phylogenet. Evol.",
"spage":"323",
"epage":"343",
"authors":[
{"forename":"K.S.", "surname":"Macdonald"},
{"forename":"L.", "surname":"Yampolsky"},
{"forename":"J.E.", "surname":"Duffy"}
],
"atitle":"Molecular and morphological evolution of the amphipod radiation of Lake Baikal",
"id":"bib35"

}
,
{
"genre":"book",
"date":"2000",
"publisher":"Sinauer Associates",
"publoc":"Sunderland, MA",
"authors":[
{"forename":"D.R.", "surname":"Maddison"},
{"forename":"W.P.", "surname":"Maddison"}
],
"atitle":"MacClade 4: Analysis of Phylogeny and Character Evolution",
"id":"bib36"

}
,
{
"genre":"article",
"date":"2004",
"volume":"24",
"title":"J. Crustacean Biol.",
"spage":"541",
"epage":"557",
"authors":[
{"forename":"K.", "surname":"Meland"},
{"forename":"E.", "surname":"Willassen"}
],
"atitle":"Molecular phylogeny and biogeography of the genus Pseudomma (Peracarida: Mysida)",
"id":"bib37"

}
,
{
"genre":"article",
"date":"1997",
"volume":"8",
"title":"Mol. Phylogenet. Evol.",
"spage":"1",
"epage":"10",
"authors":[
{"forename":"J.C.", "surname":"Meyran"},
{"forename":"M.", "surname":"Monnerot"},
{"forename":"P.", "surname":"Taberlet"}
],
"atitle":"Taxonomic status and phylogenetic relationships of some species of the genus Gammarus (Crustacea, Amphipoda) deduced from mitochondrial DNA sequences",
"id":"bib38"

}
,
{
"genre":"article",
"date":"1998",
"volume":"39",
"title":"Freshwater Biol.",
"spage":"259",
"epage":"265",
"authors":[
{"forename":"J.C.", "surname":"Meyran"},
{"forename":"P.", "surname":"Taberlet"}
],
"atitle":"Mitochondrial DNA polymorphism among alpine populations of Gammarus lacustris (Crustacea, Amphipoda)",
"id":"bib39"

}
,
{
"genre":"article",
"date":"2000",
"volume":"15",
"title":"Mol. Phylogenet. Evol.",
"spage":"260",
"epage":"268",
"authors":[
{"forename":"J.", "surname":"Mller"}
],
"atitle":"Mitochondrial DNA variation and the evolutionary history of cryptic Gammarus fossarum types",
"id":"bib40"

}
,
{
"genre":"article",
"date":"2002",
"volume":"47",
"title":"Freshwater Biol.",
"spage":"2039",
"epage":"2048",
"authors":[
{"forename":"J.C.", "surname":"Mller"},
{"forename":"S.", "surname":"Schramm"},
{"forename":"A.", "surname":"Seitz"}
],
"atitle":"Genetic and morphological differentiation of Dikerogammarus invaders and their invasion history in Central Europe",
"id":"bib41"

}
,
{
"genre":"book",
"date":"2004",
"publisher":"Evolutionary Biology Centre",
"publoc":"Uppsala University",
"authors":[
{"forename":"J.A.A.", "surname":"Nylander"}
],
"atitle":"MrModeltest v2. Program Distributed by the Author",
"id":"bib42"

}
,
{
"spage":"205",
"epage":"247",
"genre":"chapter",
"editors":[
{"forename":"D.M.", "surname":"Hillis"},
{"forename":"C.", "surname":"Moritz"},
{"forename":"B.K.", "surname":"Mable"}
],
"title":"Molecular Systematics",
"date":"1996",
"publisher":"Sinauer Associates",
"publoc":"Sunderland, MA",
"authors":[
{"forename":"S.R.", "surname":"Palumbi"}
],
"atitle":"Nucleic acids II: the polymerase chain reaction",
"id":"bib43"

}
,
{
"genre":"article",
"date":"2006",
"volume":"39",
"title":"Mol. Phylogenet. Evol.",
"spage":"568",
"epage":"572",
"authors":[
{"forename":"Z.", "surname":"Peng"},
{"forename":"S.Y.W.", "surname":"Ho"},
{"forename":"Y.", "surname":"Zhang"},
{"forename":"S.", "surname":"He"}
],
"atitle":"Uplift of the Tibetan Plateau: evidence from divergence times of glyptosternoid catfishes",
"id":"bib44"

}
,
{
"genre":"article",
"date":"1983",
"volume":"33",
"title":"Beaufortia",
"spage":"15",
"epage":"28",
"authors":[
{"forename":"S.", "surname":"Pinkster"}
],
"atitle":"The value of morphological characters in taxonomy of Gammarus",
"id":"bib45"

}
,
{
"genre":"article",
"date":"2003",
"volume":"19",
"title":"Bioinformatics",
"spage":"1572",
"epage":"1574",
"authors":[
{"forename":"F.", "surname":"Ronquist"},
{"forename":"J.P.", "surname":"Huelsenbeck"}
],
"atitle":"MRBAYES 3: bayesian phylogenetic inference under mixed models",
"id":"bib46"

}
,
{
"genre":"book",
"date":"1999",
"publisher":"Boston University",
"publoc":"Boston, MA",
"authors":[
{"forename":"M.D.", "surname":"Sorenson"}
],
"atitle":"TreeRot, Version 2",
"id":"bib47"

}
,
{
"genre":"article",
"date":"1967",
"volume":"90",
"title":"Zoologische Verhandelingen",
"spage":"1",
"epage":"56",
"authors":[
{"forename":"J.H.", "surname":"Stock"}
],
"atitle":"A revision of the European species of the Gammarus locusta-group (Crustacea, Amphipoda)",
"id":"bib48"

}
,
{
"genre":"article",
"date":"1998",
"volume":"48",
"title":"Beaufortia",
"spage":"173",
"epage":"234",
"authors":[
{"forename":"J.H.", "surname":"Stock"},
{"forename":"A.R.", "surname":"Mirzajani"},
{"forename":"R.", "surname":"Vonk"},
{"forename":"S.", "surname":"Naderi"},
{"forename":"B.H.", "surname":"Kiabi"}
],
"atitle":"Limnic and brackish water Amphipoda (Crustacea) from Iran",
"id":"bib49"

}
,
{
"genre":"book",
"date":"2002",
"publisher":"Sinauer Associates",
"publoc":"Sunderland, MA",
"authors":[
{"forename":"D.L.", "surname":"Swofford"}
],
"atitle":"PAUP: Phylogenetic Analysis Using Parsimony (and Other Methods)",
"id":"bib50"

}
,
{
"genre":"article",
"date":"1983",
"volume":"37",
"title":"Evolution",
"spage":"221",
"epage":"244",
"authors":[
{"forename":"A.R.", "surname":"Templeton"}
],
"atitle":"Phylogenetic inference from restriction endonuclease cleavage site maps with particular reference to the evolution of humans and the apes",
"id":"bib51"

}
,
{
"genre":"article",
"date":"1997",
"volume":"25",
"title":"Nucleic Acids Res.",
"spage":"4876",
"epage":"4882",
"authors":[
{"forename":"J.D.", "surname":"Thompson"},
{"forename":"T.J.", "surname":"Gibson"},
{"forename":"F.", "surname":"Plewniak"},
{"forename":"F.", "surname":"Jeanmougin"},
{"forename":"D.G.", "surname":"Higgins"}
],
"atitle":"The Clustal_X windows interface: flexible strategies for multiple sequence alignment aided by quality analysis tools",
"id":"bib52"

}
,
{
"genre":"article",
"date":"1993",
"volume":"364",
"title":"Nature",
"spage":"50",
"epage":"54",
"authors":[
{"forename":"S.", "surname":"Turner"},
{"forename":"C.", "surname":"Hawkesworth"},
{"forename":"J.", "surname":"Liu"},
{"forename":"N.", "surname":"Rogers"},
{"forename":"S.", "surname":"Kelley"},
{"forename":"P.", "surname":"van Calsteren"}
],
"atitle":"Timing of Tibetan uplift constrained by analysis of volcanic rocks",
"id":"bib53"

}
,
{
"description":"Vader, W., 2007. New amphipod species described in the period 1974-2006, ordered by family. Amphipod Newsletter 31. (http://uit.no/tmu/133/43).",
"id":"bib54"

}
,
{
"genre":"article",
"date":"2003",
"volume":"79",
"title":"Biol. J. Linn. Soc.",
"spage":"523",
"epage":"542",
"authors":[
{"forename":"J.K.", "surname":"Vainio"},
{"forename":"R.", "surname":"Vinl"}
],
"atitle":"Refugial races and postglacial colonization history of the freshwater amphipod Gammarus lacustris in Northern Europe",
"id":"bib55"

}
,
{
"description":"Vinl, R., Witt, J.D.S., Grabowski, M., Bradbury, J.H., Jazdzewski, K., Sket, B., 2007. Global diversity of amphipods (Amphipoda; Crustacea) in freshwater. Hydrobiologia, in press.",
"id":"bib56"

}
,
{
"genre":"article",
"date":"2006",
"volume":"15",
"title":"Mol. Ecol.",
"spage":"3037",
"epage":"3082",
"authors":[
{"forename":"J.S.", "surname":"Witt"},
{"forename":"D.L.", "surname":"Threloff"},
{"forename":"P.D.N.", "surname":"Hebert"}
],
"atitle":"DNA barcoding reveals extraordinary cryptic diversity in an amphipod genus: implications for desert spring conservation",
"id":"bib57"

}
,
{
"genre":"article",
"date":"2001",
"volume":"36",
"title":"Geomorphology",
"spage":"203",
"epage":"216",
"authors":[
{"forename":"Y.Q.", "surname":"Wu"},
{"forename":"Z.J.", "surname":"Cui"},
{"forename":"G.N.", "surname":"Liu"},
{"forename":"D.K.", "surname":"Ge"},
{"forename":"J.R.", "surname":"Yin"},
{"forename":"Q.H.", "surname":"Xu"},
{"forename":"Q.Q.", "surname":"Pang"}
],
"atitle":"Quanternary geomorphological evolution of the Kunlun Pass areas and uplift of the Qinghai-Xizang (Tibet) Plateau",
"id":"bib58"

}
,
{
"genre":"article",
"date":"2006",
"volume":"103",
"title":"PNAS",
"spage":"7360",
"epage":"7365",
"authors":[
{"forename":"P.", "surname":"Zhang"},
{"forename":"Y.Q.", "surname":"Chen"},
{"forename":"H.", "surname":"Zhou"},
{"forename":"Y.F.", "surname":"Liu"},
{"forename":"X.L.", "surname":"Wang"},
{"forename":"T.J.", "surname":"Papenfuss"},
{"forename":"D.B.", "surname":"Wake"},
{"forename":"L.H.", "surname":"Qu"}
],
"atitle":"Phylogeny, evolution and biogeography of Asiatic salamanders (Hynobiidae)",
"id":"bib59"

}
]
}';

//echo $str;

$j = json_decode($str);
//print_r($j);


print_r ( $j->tables[0]->header);
print_r ( $j->tables[0]->rows[0]);
print_r ( $j->tables[0]->rows[1]);

//print_r($j->tables[0]);

// Fix second row of header (if it exists)
// A cell may span more than one row, which knocks cells in the next row out of alignment
if (isset($j->tables[0]->header[1]))
{
	$r = array();
	foreach ($j->tables[0]->header[0] as $h)
	{
		if (preg_match('/\+$/', $h))
		{
			array_push($r, "-");
		}
		else
		{
			array_push($r, array_shift($j->tables[0]->header[1]));
		}
	}
	print_r($r);
}

// Fix a data row
$row = 1;

	$r = array();
	foreach ($j->tables[0]->rows[$row-1] as $h)
	{
		if (preg_match('/\+$/', $h))
		{
			array_push($r, "-");
		}
		else
		{
			array_push($r, array_shift($j->tables[0]->rows[$row]));
		}
	}
	print_r($r);
	
	
// Parse bibliography
foreach ($j->bibliography as $bib)
{
	print_r($bib);
}



/*

// Simple case to KML

	$pts = array();

	foreach ($j->tables[0]->rows as $r)
	{
		//print_r($r);
		
		if ($r[2] != '')
		{
			list($long,$lat) = explode("/", $r[2]);
			
			//echo "$lat|\n";
			
			if (preg_match('/W$/', $long))
			{
				$long = str_replace("W", "", $long);
				$long *= -1.0;
			}
			else
			{
				$long = str_replace("E", "", $long);
			}
			if (preg_match('/S$/', $lat))
			{
				$lat = str_replace("S", "", $lat);
				$lat *= -1.0;
			}
			else
			{
				$lat = str_replace("N", "", $lat);
			}
			
			echo "$long $lat\n";
			
			$pt = new stdClass;
			$pt->name = $r[3];
			$pt->long = $long;
			$pt->lat = $lat;
			
			array_push($pts, $pt);
			
			
		}
		
		
		
	}
	




	
	// KML
	
	echo  '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://earth.google.com/kml/2.1">
	<Document>
		<name>Extracted from PDF</name>';
	
	echo '        <Style id="normalPlacemark">
          <IconStyle>
            <Icon>
              <href>http://maps.google.com/mapfiles/kml/paddle/wht-blank.png</href>
            </Icon>
          </IconStyle>
        </Style>';
	
	foreach ($pts as $pt)
	{

		echo '	<Placemark>
			<styleUrl>#normalPlacemark</styleUrl>
			<name>' . $pt->name  . '</name>
			<description>
			</description>
			<Point>
				<extrude>0</extrude>
				<altitudeMode>absolute</altitudeMode>
				<coordinates>';
				echo $pt->long, ',';
				echo $pt->lat;
				echo ',0</coordinates> ', "\n";
		echo '		</Point>
		</Placemark>';
		echo "\n";
		
	}
	echo "</Document>\n
</kml>\n";


*/





?>