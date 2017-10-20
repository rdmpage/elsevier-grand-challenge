<?php

require_once('class_table.php');

// make some test cases

$tables = array();

array_push($tables,'
{
"label":"Table 1",
"caption":"Species sampled, collection localities, and GenBank accession numbers"
,"header":[
["Species","Family","Locality (latitude, longitude)",""]
],
"rows":[
["Champsocephalus esox","Channichthyidae","Falkland Islands (51°25′.0S, 57°35.0′W)",""],
["Champsocephalus gunnari","Channichthyidae","Palmer Archipelago (64°51.0′S, 63°34.0′W)",""],
["Champsocephalus gunnari","Channichthyidae","Elephant Island (61°11.7′S, 54°44.0′W)",""],
["Pagetopsis macropterus","Channichthyidae","South Shetland Islands (62°10.4′S, 60°28.4′W)",""],
["Pagetopsis maculatus","Channichthyidae","Ross Sea (77°19.0′S, 165°41.0′E)",""],
["Neopagetopsis ionah","Channichthyidae","Enderby Land (66°27.9′S, 48°32.6′E)",""],
["Pseudochaenichthys georgianus","Channichthyidae","Palmer Archipelago (64°51.0′S, 63°34.0′W)",""],
["Pseudochaenichthys georgianus","Channichthyidae","Elephant Island (61°17.3′S, 55°42.7′W)",""],
["Dacodraco hunteri","Channichthyidae","Ross Sea (77°19.0′S, 165°41.0′E)",""],
["Dacodraco hunteri","Channichthyidae","Ross Sea (77°19.0′S, 165°41.0′E)",""],
["Channichthys rhinoceratus","Channichthyidae","Kerguelen Islands",""],
["Chaenocephalus aceratus","Channichthyidae","Palmer Archipelago (64°51.0′S, 63°34.0′W)",""],
["Chaenocephalus aceratus","Channichthyidae","Elephant Island (61°04.0′S, 54°33.6′W)",""],
["Chionobathyscus dewitti","Channichthyidae","Enderby Land (66°27.9′S, 48°32.6′E)",""],
["Cryodraco antarcticus","Channichthyidae","Elephant Island (60°58.1′S, 55°04.8′W)",""],
["Cryodraco atkinsoni","Channichthyidae","Ross Sea (75°30.0′S, 174°56.0′E)",""],
["Chaenodraco wilsoni","Channichthyidae","South Shetland Islands (61°44.2′S, 58°20.5′W)",""],
["Chaenodraco wilsoni","Channichthyidae","South Shetland Islands (62°10.4′S, 60°28.4′W)",""],
["Chionodraco myersi","Channichthyidae","Ross Sea (75°30.0′S, 174°56.0′E)",""],
["Chionodraco hamatus","Channichthyidae","Prydz Bay (67°08.8′S, 75°17.1′E)",""],
["Chionodraco rastrospinosus","Channichthyidae","Elephant Island (61°10.1′S, 54°33.5′W)",""],
["Akarotaxis nudiceps","Bathydraconidae","Ross Sea (75°02.0′S, 166°16.0′E)",""],
["Bathydraco marri","Bathydraconidae","Weddell Sea (75°16.0′S, 26°39.0′W)",""],
["Racovitzia glacialis","Bathydraconidae","Ross Sea (75°30.0′S, 174°56.0′E)",""],
["Gerlachea australis","Bathydraconidae","Weddell Sea (75°00.0′S, 28°00.0′W)",""],
["Gymnodraco acuticeps","Bathydraconidae","McMurdo Sound (75°51.0′S, 166°40.0′E)",""],
["Gymnodraco acuticeps","Bathydraconidae","Palmer Archipelago (64°51.0′S, 63°34.0′W)",""]
]
}');

/*
array_push($tables,
'{
"label":"Table 1",
"caption":"Collecting locations and GenBank accession numbers for acanthuroid samples"
,"rows":[
["Specimen","Collecting location","Latitude/longitude","Accession No.","-","-"],
["","","","12S","16S","Control region"],
["Siganus doliatus 1","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057230","AY057277","AY057324"],
["S. doliatus 2","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057231","AY057278","AY057325"],
["S. vulpinus 1","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057232","AY057279","AY057326"],
["S. vulpinus 2","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057233","AY057280","AY057327"],
["Zanclus cornutus 1","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057235","AY057282","AY057329"],
["Za. cornutus 2","Lizard Island, Australia","14°39′ S, 145°27′ E","AY057236","AY057283","AY057330"],
["Luvarus imperialis","Sydney, Australia","33°54′ S, 151°16′ E","AY057234","AY057281","AY057328"],
["","","","","",""],
["AMS I.34209-001","","","","",""],
["Naso brachycentron","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057256","AY057303","AY057350"],
["N. hexacanthus 1","Day Reef (Reef 14-089), Australia","14°30′ S, 145°33′ E","AY057257","AY057304","AY057351"],
["N. hexacanthus 2","Day Reef (Reef 14-089), Australia","14°30′ S, 145°33′ E","AY057258","AY057305","AY057352"],
["N. tuberosus 1","NoName Reef (Reef 14-139), Australia","14°38′ S, 145°39′ E","AY057259","AY057306","AY057353"],
["N. tuberosus 2","Martin Reef (Reef 14-123), Australia","14°45′ S, 145°22′ E","AY057260","AY057307","AY057354"],
["N. unicornis 1","Detached Reef (Reef 14-140), Australia","14°40′ S, 145°40′ E","AY057261","AY057308","AY057355"],
["N. unicornis 2","Detached Reef (Reef 14-140), Australia","14°40′ S, 145°40′ E","AY057262","AY057309","AY057356"],
["Prionurus laticlavius 1","Perlas Archipelago, Panama","8°25′ N, 79°00′ W","AY057265","AY057312","AY057359"],
["Pr. laticlavius 2","Perlas Archipelago, Panama","8°25′ N, 79°00′ W","AY057266","AY057313","AY057360"],
["Pr. maculatus 1","Solitary Islands, Australia","30°18′ S, 153°08′ E","AY057267","AY057314","AY057361"],
["Pr. maculatus 2","Solitary Islands, Australia","30°18′ S, 153°08′ E","AY057268","AY057315","AY057362"],
["Pr. microlepidotus 1","Byron Bay, Australia","28°39′ S, 153°37′ E","AY057269","AY057316","AY057363"],
["Pr. microlepidotus 2","Byron Bay, Australia","28°39′ S, 153°37′ E","AY057270","AY057317","AY057364"],
["Paracanthurus hepatus 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057263","AY057310","AY057357"],
["Pa. hepatus 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057264","AY057311","AY057358"],
["Zebrasoma flavescens 1","French Frigate Shoals, NW Hawaiian Is.","23°45′ N, 166°10′ W","AY057271","AY057318","AY057365"],
["Ze. flavescens 2","French Frigate Shoals, NW Hawaiian Is.","23°45′ N, 166°10′ W","AY057272","AY057319","AY057366"],
["Ze. scopas 1","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057273","AY057320","AY057367"],
["Ze. scopas 2","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057274","AY057321","AY057368"],
["Ze. veliferum 1","Martin Reef (Reef 14-123), Australia","14°45′ S, 145°22′ E","AY057275","AY057322","AY057369"],
["Ze. veliferum 2","North Direction Is., Australia","14°45′ S, 145°31′ E","AY057276","AY057323","AY057370"],
["Acanthurus mata 1","NoName Reef (Reef 14-139), Australia","14°38′ S, 145°38′ E","AY057237","AY057284","AY057331"],
["A. mata 2","NoName Reef (Reef 14-139), Australia","14°38′ S, 145°38′ E","AY057238","AY057285","AY057332"],
["A. nigricans 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057239","AY057286","AY057333"],
["A. nigricans 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057240","AY057287","AY057334"],
["A. nigroris","French Frigate Shoals, NW Hawaiian Is.","23°45′ N, 166°10′ W","AY057241","AY057288","AY057335"],
["A. pyroferus 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057242","AY057289","AY057336"],
["A. pyroferus 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057243","AY057290","AY057337"],
["A. thompsoni 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057244","AY057291","AY057338"],
["A. thompsoni 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057245","AY057292","AY057339"],
["A. triostegus 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057246","AY057293","AY057340"],
["A. triostegus 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057247","AY057294","AY057341"],
["A. xanthopterus 1","Lizard Island, Australia","14°40′ S, 145°27′ E","AY057248","AY057295","AY057342"],
["A. xanthopterus 2","Lizard Island, Australia","14°40′ S, 145°27′ E","AY057249","AY057296","AY057343"],
["Ctenochaetus binotatus 1","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057250","AY057297","AY057344"],
["C. binotatus 2","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057251","AY057298","AY057345"],
["C. cyanocheilus 1","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057252","AY057299","AY057346"],
["C. cyanocheilus 2","Hick’s Reef (Reef 14-086), Australia","14°26′ S, 145°28′ E","AY057253","AY057300","AY057347"],
["C. striatus 1","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057254","AY057301","AY057348"],
["C. striatus 2","Lizard Island, Australia","14°42′ S, 145°28′ E","AY057255","AY057303","AY057349"]
]
}
');


array_push($tables, '
{
"label":"",
"caption":"",
"header":[
["Species","Tissue No.","Catalog No.","GenBank No."]
],
"rows":[
["Outgroup","-","-","-"],
["Cetopsorhamdia sp. (Heptapteridae)","stri-x3606","INHS 56139","DQ119442a, DQ990631, DQ990527, DQ990579, DQ990502"],
["Ageneiosus atronasus (Auchenipteridae)","stri-x3608","INHS 54689","DQ119403a, DQ990633, DQ990529, DQ990580, DQ990503"],
["Ictalurus punctatus (Ictaluridae)","stri-x3607","INHS 47559","AY184253a, DQ990632, DQ990528, DQ990581, AY184245b"],
["","","",""],
["Ingroup","-","-","-"],
["Gogo arcuatus (Anchariidae)","","UMMZ 238042","DQ492415b"],
["Ariopsis felis","stri-x3609","AUM 5233-02","DQ119355a, DQ990659, DQ990564, DQ990599, DQ492410b"],
["A. guatemalensis","stri-15941","STRI-5732","DQ990484, DQ990660, DQ990562, DQ990598"],
["A. seemanni","stri-12668/15948","STRI-5730/5731","DQ990485, DQ990486, DQ990661, DQ990662, DQ990561, DQ990596, DQ990517"],
["Ariopsis sp.","stri-x3602/x3603","INVEMAR-PEC 5332/5340","DQ990487, DQ990488, DQ990663, DQ990664, DQ990563, DQ990597, DQ990516"],
["Arius arius","stri-x3656/3657","USNM 376608","AY688674, DQ990501, AY688661, AY688648, DQ990681, DQ990576, DQ990622, DQ990525"],
["Bagre bagre","stri-x3540/x3545","MHNG 2608.096, ANSP 178751","AY688673, AY688660, AY688647, DQ990678, DQ990572, DQ990626, DQ990523"],
["B. marinus","stri-x3610","AUM 5234-003","DQ119472a, DQ990679, DQ990573, DQ990627, DQ990524"],
["B. aff. marinus","stri-x3605","INVEMAR-PEC 5336","DQ990500, DQ990680, DQ990574, DQ990628"],
["B. panamensis","stri-17566/12672","STRI-5735/5734","DQ990498, DQ990497, DQ990676, DQ990571, DQ990625, DQ990521"],
["B. pinnimaculatus","stri-12670","STRI-5736","DQ990499, DQ990677, DQ990575, DQ990629, DQ990522"],
["C. agassizii","stri-x3541/x3564","MHNG 2608.097, ANSP 178743","DQ990473, DQ990474, DQ990645, DQ990646, DQ990552, DQ990620"],
["Cathorops aguadulce","stri-7989, P4172","STRI-5450, ECO-SC 4270","DQ990476, DQ990648, DQ990649, DQ990544, DQ990614"],
["C. dasycephalus","stri-15944/17233","STRI-5718/5717","DQ990467, DQ990638, DQ990639, DQ990556, DQ990621, DQ990510"],
["C. fuerthii","stri-17563","STRI-5720","DQ990469, DQ990641, DQ990554, DQ990617"],
["C. aff. fuerthii","stri-15949","STRI-5726","DQ990468, DQ990640, DQ990555, DQ990618"],
["C. hypophthalmus","stri-17561","STRI-5722","DQ990478, DQ990651, DQ990548, DQ990612, DQ990512"],
["C. mapale","stri-x3600/x3601","INVEMAR-PEC 5333/5348","AY575016, AY575017, AY575018, AY575019, AY575021, AY575020, DQ990550, DQ990616"],
["C. multiradiatus","stri-16776","STRI-5723","DQ990477, DQ990650, DQ990545, DQ990609"],
["C. spixii","stri-x3563","ANSP 178744","DQ990475, DQ990647, DQ990551, DQ990619"],
["C. steindachneri","stri-17236","STRI-5725","DQ990472, DQ990644, DQ990546, DQ990611, DQ990511"],
["C. taylori","stri-15952","STRI-5727","DQ990471, DQ990643, DQ990547, DQ990610"],
["C. tuyra","stri-16391","STRI-5724","DQ990479, DQ990652, DQ990549, DQ990613"],
["Cathorops sp.","stri-x3661","INVEMAR-PEC 5734 (494)","DQ990470, DQ990642, DQ990553, DQ990615"],
["Cryptarius truncatus","stri-x3611","INHS 93580","DQ119391a, DQ990682, DQ990578, DQ990624, DQ990526"],
["Galeichthys peruvianus","stri-17993","STRI-5781","DQ990462, DQ990634, DQ990530, DQ990582, DQ990504"],
["Ketengus typus","stri-x3612","INHS 93581","DQ119485a, DQ990683, DQ990577, DQ990623, DQ492413b"],
["Notarius armbrusteri","527, 529","INVEMAR-PEC 6677/6678","DQ373045, DQ373046, DQ373041, DQ373042, DQ373043, DQ373044, DQ990542, DQ990585"],
["N. biffi","stri-15942","STRI-5713","AY688667,AY688654, AY688641, DQ990538, DQ990589"],
["N. bonillai","stri-x3613","INVEMAR-PEC 5342","AY582861, AY582863, AY582865, DQ990533, DQ990592"],
["N. cookei","stri-16750/16752","STRI-5709","AY582860, DQ990463, AY582862, AY582864, DQ990534, DQ990594"],
["N. grandicassis","stri-x3660, VEN05024","NV, AUM 44230","AY688671, AY688658, AY688645, DQ990637, DQ990540, DQ990587, DQ990509"],
["N. insculptus","stri-17958","STRI-5715","AY688666, AY688653, AY688640, DQ990543, DQ990586"],
["N. kessleri","stri-17578/17231/17577","STRI-5711/5710","AY688663. DQ990465, DQ990466, AY688650, AY688637, DQ990532, DQ990591"],
["N. neogranatensis","stri-x3598/x3599","INVEMAR-PEC 5337/5338","AY688662, DQ990464, AY688649, AY688636, DQ990531, DQ990593, DQ990505"],
["N. planiceps","stri-17575","STRI-5712","AY688664, AY688651, AY688638, DQ990536, DQ990583"],
["N. aff. planiceps","stri-15943","STRI-5714","AY688665, AY688652, AY688639, DQ990537, DQ990584"],
["N. rugispinis","stri-x3550/x3538/x3532","ANSP 178749, MHNG 2595.70/2608.094","AY688668, AY688655, AY688642, DQ990635, DQ990636, DQ990539, DQ990588, DQ990506"],
["N. quadriscutis","stri-x3571","ANSP 178740 (24J6)","AY688670, AY688657, AY688644, DQ990535, DQ990590, DQ990508"],
["N. troschelii","stri-17229","STRI-5716","AY688669, AY688656, AY688643, DQ990541, DQ990595, DQ990507"],
["Occidentarius platypogon","stri-12651/17230","STRI-5728/5729","AY688672, DQ990480, AY688659, AY688646, DQ990653, DQ990557, DQ990630, DQ990513"],
["Potamarius sp.","P4169/4173","ECO-SC 4274, NV","DQ990483, DQ990657, DQ990658, DQ990560, DQ990600"],
["P. izabalensis","stri-8279","STRI-5612","DQ990481, DQ990654, DQ990558, DQ990602, DQ990514"],
["P. nelsoni","P4165/4164","ECO-SC 4266/4267","DQ990482, DQ990655, DQ990656, DQ990559, DQ990601, DQ990515"],
["Sciades couma","stri-x3531/x3560/x3562/x3556","NV, ANSP 178745-747","DQ990495, DQ990494, DQ990672, DQ990671, DQ990674, DQ990673, DQ990569, DQ990604"],
["S. dowii","stri-17558","STRI-5733","DQ990489, DQ990665, DQ990565, DQ990608"],
["S. herzbergii","stri-x3561","ANSP 178746","DQ990496, DQ990675, DQ990568, DQ990603, DQ990520"],
["S. parkeri","stri-x3570","ANSP 178741","DQ990492, DQ990669, DQ990567, DQ990606, DQ990519"],
["S. passany","stri-x3537","NV","DQ990493, DQ990670, DQ990570, DQ990607"],
["S. proops","stri-x3565, stri-x3539, stri-x3604","ANSP 178742, MHNG 2608.095, NV","DQ990491, DQ990490, DQ990667, DQ990668, DQ990666, DQ990566, DQ990605, DQ990518"]
]
}');


array_push($tables,
'{
"label":"Table 1",
"caption":"The localities, sample sizes (N), geographic coordinates and mtDNA locus sampled for each Chersina angulata population",
"header":[
["Locality{@m1}","N{@m1}","GPS coordinates{@m1}","Locus","-","-"],
["COI","cyt b","ND4"]
],
"rows":[
["(1) Lekkersing","1","29°15\'00\'\'S 17°10\'00\'\'E","-","-","1"],
["(2) Kleinsee","8","29°47\'30\'\'S 17°07\'04\'\'E","1","7","5"],
["(3) Springbok","3","29°41\'31\'\'S 17°52\'59\'\'E","3","3","3"],
["(4) Danskraal","21","29°42\'29\'\'S 17°48\'06\'\'E","15","20","21"],
["(5) Nuwerus","1","31°06\'33\'\'S 18°20\'51\'\'E","1","1","1"],
["(6) Lutzville","1","31°30\'16\'\'S 18°17\'48\'\'E","1","1","1"],
["(7) Doorn Bay","1","31°46\'57\'\'S 18°13\'58\'\'E","1","1","1"],
["(8) Lamberts Bay","2","32°00\'43\'\'S 18°20\'28\'\'E","2","1","2"],
["(9) Graafwater","1","32°09\'00\'\'S 18°36\'45\'\'E","-","1","1"],
["(10) Algeria","1","32°21\'00\'\'S 19°04\'00\'\'E","-","1","1"],
["(11) Kriedouwkrans","2","32°22\'14\'\'S 18°59\'17\'\'E","3","2","2"],
["(12) Citrusdal","2","32°23\'45\'\'S 18°57\'02\'\'E","1","1","1"],
["(13) Kardoesie","1","32°37\'43\'\'S 18°56\'54\'\'E","1","1","1"],
["(14) WCNP","25","33°14\'03\'\'S 18°08\'01\'\'E","8","15","25"],
["(15) Dassen Island","15","33°25\'21\'\'S 18°05\'17\'\'E","13","15","13"],
["(16) Vrolijkheid","6","33°55\'21\'\'S 19°53\'28\'\'E","-","6","6"],
["(17) Kleinmond","3","34°19\'00\'\'S 19°02\'00\'\'E","-","3","3"],
["(18) Moddervlei","4","34°36\'00\'\'S 19°49\'00\'\'E","-","4","4"],
["(19) Vlooikraal","2","34°40\'00\'\'S 19°46\'00\'\'E","-","2","2"],
["(20) Potberg","1","34°23\'00\'\'S 20°32\'00\'\'E","-","1","-"],
["(21) EPNR","3","33°25\'41\'\'S 19°01\'37\'\'E","3","2","3"],
["(22) Witteberge","2","33°18\'40\'\'S 20°35\'18\'\'E","1","1","2"],
["(23) Still Bay","8","34°15\'24\'\'S 21°26\'41\'\'E","6","7","8"],
["(24) Tierberg","1","33°10\'13\'\'S 22°15\'55\'\'E","1","1","1"],
["(25) Port Elizabeth","18","34°01\'08\'\'S 25°29\'51\'\'E","18","17","17"],
["(26) Verekraal","3","33°23\'41\'\'S 23°54\'26\'\'E","-","3","-"],
["(27) Fort Brown","5","33°08\'17\'\'S 26°40\'48\'\'E","-","5","-"],
["","","","","",""],
["Total samples sequenced per locus","-","-","79","122","125"]
]
}
');


array_push($tables,'
{
"label":"Table 1",
"caption":"Specimens of Platythelphusa and Potamonautes included in the phylogenetic analyses, localities where crabs were collected, and GenBank Accession numbers",
"header":[
["Species","Code","Locality","-","Latitude, longitude","12S","16S"]
],
"rows":[
["Platythelphusa armata (A. Milne-Edwards, 1887)","JKB","Jakobsen","LT, TZ","4°54.87′S, 29°35.85′E","DQ203187","DQ203213"],
["Platythelphusa armata","MBT","Mbita","LT, ZM","8°45.23′S, 31°05.14′E","DQ203188","DQ203214"],
["Platythelphusa armata","UJJ","Ujiji","LT, TZ","4°58.00′S, 29°41.82′E","DQ203189","DQ203215"],
["Platythelphusa conculcata (Cunnington, 1907)","HTP","Hilltop","LT, TZ","4°53.20′S, 29°36.90′E","DQ203190","DQ203216"],
["Platythelphusa conculcata","JKB","Jakobsen","LT, TZ","4°54.73′S, 29°35.90′E","DQ203191","DQ203217"],
["Platythelphusa conculcata","KIG","Kigoma","LT, TZ","4°53′21′S, 29°37.21′E","DQ203192","DQ203218"],
["Platythelphusa denticulata (Capart, 1952)","KAB","Kabwe","LT, TZ","7°01.60′S, 30°33.00′Ea","DQ203194","DQ203220"],
["Platythelphusa denticulata","MZG","Mzungu","LT, TZ","4°55.05′S, 29°35.73′E","DQ203193","DQ203219"],
["Platythelphusa echinata (Capart, 1952)","HTP","Hilltop","LT, TZ","4°53.45′S, 29°35.80′E","DQ203196","DQ203222"],
["Platythelphusa echinata","MPL","Mpulungu","LT, ZM","N.A.","DQ203197","DQ203223"],
["Platythelphusa echinata","UJJ","Ujiji","LT, TZ","4°58.75′S, 29°43.27′E","DQ203195","DQ203221"],
["Platythelphusa immaculata (Marijnissen et al., 2004)","JKB","Jakobsen","LT, TZ","4°54.73′S, 29°35.90′E","DQ203199","DQ203225"],
["Platythelphusa immaculata","KTB","Katabe","LT, ZM","4°54.21′S, 29°35.67′E","DQ203200","DQ203226"],
["Platythelphusa immaculata","MBT","Mbita","LT, TZ","8°45.23′S, 31°05.14′E","DQ203198","DQ203224"],
["Platythelphusa maculata (Cunnington, 1899)","KAS","Kasanga","LT, TZ","8°28.00′S, 31°08.60′Ea","DQ203201","DQ203227"],
["Platythelphusa maculata","KMJ","Kangamoja","LT, TZ","4°57.92′S, 29°41.20′E","DQ203202","DQ203228"],
["Platythelphusa maculata","MPL","Mpulungu","LT, ZM","8°45.99′S, 31°06.40′E","DQ203203","DQ203229"],
["Platythelphusa praelongata (Marijnissen et al., 2004)","MPL","Mpulungu","LT, ZM","8°45.22′S, 31°05.14′E","DQ203204","DQ203230"],
["Platythelphusa tuberculata (Capart, 1952)","UJJ","Ujiji","LT, TZ","4°54.20′S, 29°30.00′Ea","DQ203206","DQ203232"],
["Platythelphusa tuberculata","MBT","Mbita","LT, ZM","8°44.91′S, 31°05.34′E","DQ203205","DQ203231"],
["","","","","","",""],
["Potamonautes emini (Hilgendorf, 1892)","GMB","Gombe","LT, TZ","4°38.15′S, 29°37.81′E","DQ203207","DQ203233"],
["Potamonautes emini","KIV","Ruzizi","LK, DC","N.A.","DQ203208","DQ203234"],
["Potamonautes niloticus (H. Milne-Edwards, 1837)","SRD","N.A.","N.A.","N.A.","AY803496","AY803536"],
["Potamonautes lirrangensis (Rathbun, 1904)","KIV","Ruzizi","LK, DC","N.A.","DQ203210","DQ203236"],
["Potamonautes lirrangensis","MAL","Thumbi West","LM, MW","N.A.","DQ203209","DQ203235"],
["Potamonautes lirrangensis","ZAM","Uazua","LT, ZM","N.A.","DQ203211","DQ203237"],
["Potamonautes platynotus (Cunnington, 1907)","KAL","Kalemie","LT, DC","5°55.60′S, 29°11.60′Ea","DQ203212","DQ203238"],
["Potamonautes clarus (Gouws et al., 2000)","OLI","Oliviershoekpas","KZ, SA","N.A.b","AY042320","AY042241"],
["Potamonautes brincki (Bott, 1960)","FER","Fernkloof","WC, SA","N.A.b","AY042322","AY042244"],
["Potamonautes depressus (Krauss, 1843)","COL","Coleford","KZ, SA","N.A.b","AY042325","AY042247"]
]
}
');

*/
/*
// old stryle table to do



array_push($tables,
'{
"label":"Table 1",
"caption":"
Species, collection localities, altitudes, and GPS data for the samples",
"rows":[
["Species","Location","Altitude","Position"],
["D. amazonicus","Almendras, Loreto, Peru (1)","Lowland","S 3°50′2.8″–W 73°22′32.1″"],
["D. biolat","Tambopata, Madre de Dios, Peru (10)","Lowland",""],
["D. castaneoticus","101km South, 15km East of Santarem, Para, Brazil (5)","Lowland",""],
["D. castaneoticus","101km South, 15km East of Santarem, Para, Brazil (6)","Lowland","S 3°9′2.4″–W 54°50′32.9″"],
["D. fantasticus","Taropoto, San Martin, Peru (15)","Montane",""],
["D. fantasticus","Sauce, San Martin, Peru (14)","Montane",""],
["D. fantasticus","Huallaga Canyon, San Martin, Peru (16)","Montane","S 6°34′26.4″–W 75°57′54.5″"],
["D. histrionicus","Santo Domingo, Pichincha, Ecuador","",""],
["D. imitator","Taropoto, San Martin, Peru (13)","Montane",""],
["D. imitator","Huallaga Canyon, San Martin, Peru (11)","Montane","S 6°34′26.4″–W 75°57′54.5″"],
["D. imitator","Yurimaguas, Loreto, Peru (12)","Lowland",""],
["D. lamasi","From exact paratype locality, Tingo Maria, Huanuco, Peru (9)","Highland",""],
["D. leucomelas","Tabogan, Amazonas, Venezuela","",""],
["D. quinquevittatus","Rio Ituxi at the Madeireira Scheffer, left bank, Amazonas, Brazil (4)","Lowland","S 8°20′47.0″–W 65°42′57.9″"],
["D. reticulatus","Nanay River, Loreto, Peru (3)","Lowland",""],
["D. reticulatus","Varrillal, Loreto, Peru (2)","Lowland","S 3°53′28.5″–W 73°20′52.7″"],
["D. vanzolinii","Porto Walter, Acre, Brazil","Lowland","S 8°15′31.2″–W 72°46′37.1″"],
["D. variabilis","Tarapoto, San Martin, Peru (18)","Montane",""],
["D. venrimaculatus","Porto Walter, Acre, Brazil (21)","Lowland",""],
["D. ventrimaculatus","Yurimaguas, Loreto, Peru (17)","Lowland","S 6°12′44.2″–W 76°13′33.7″"],
["D. ventrimaculatus","Pompeya, Sucumbios, Ecuador (19)","Lowland",""],
["D. ventrimaculatus","Near ACEER camp, north bank of Napo River, Loreto, Peru (20)","Lowland",""],
["D. ventrimaculatus","From across Itaya river going to Nauta, Loreto, Peru","Lowland","S 4°16′27.2″–W 73°30′45.7″"],
["D. ventrimaculatus","Porto Walter, Acre, Brazil (22)","Lowland",""],
["D. ventrimaculatus","Allpahuayo,km 28 on road from Iquitos to Nauta, Loreto, Peru (7)","Lowland",""],
["Dendrobates species","From across Itaya River going to Nauta, Loreto, Peru (8)","Lowland","S 4°16′27.2″–W 73°30′45.7″"]
]
}
');


array_push($tables,
'{
"label":"Table 2",
"caption":".",
"header":[
["Species/Code","Location","Elevation","Coordinates"]
],
"rows":[
["Allobates femoralis P1","Itaya, Loreto, Peru","100 m","S 4.45\' W 73.57\'"],
["A. femoralis P2","Itaya, Loreto, Peru","100 m","S 4.45\' W 73.57\'"],
["A. femoralis P3","Loreto, Peru","Lowland","NA"],
["A. femoralis P4","Boca Manu, Cuzco, Peru","250 m","S12.25\' W 70.9\'"],
["A. femoralis P5","Saposoa, San Martin, Peru","850 m","S 6.77107\', W 76.94120\'"],
["A. femoralis P6","Loreto, Peru","Lowland","NA"],
["A. femoralis P7","Rio Sucusari, Loreto, Peru","100 m","S 3.24073\' W 72.92835\'"],
["A. femoralis P8","Tahuayo, Loreto, Peru","140 m","S 4.18707\' W 73.10457\'"],
["A. femoralis P9","Loreto, Peru","Lowland","NA"],
["A. femoralis P10","Rio Manova Loreto, Peru","110 m","S 3.65201\' W 72.20045\'"],
["Colostethus sp.","Bonilla, San Martin, Peru","200 m","S 6.21007\' W 76.27226\'"],
["Epipedobates bassleri P1","Saposoa, San Martin, Peru","850 m","S 6.77107\', W 76.94120\'"],
["E. bassleri P2","Altoshima, San Martin, Peru","670 m","available upon request"],
["E. bassleri P3","Chazuta, San Martin, Peru","560 m","available upon request"],
["E. bassleri P4","Sauce, San Martin, Peru","720 m","available upon request"],
["E. bassleri P5","Huallaga, San Martin, Peru","390 m","available upon request"],
["E. bassleri P6","Cainarachi, San Martin, Peru","920 m","S 6.48726\' W 76.31520\'"],
["E. bassleri P7","Tarapoto, San Martin, Peru","760 m","S 6.47152\' W 76.30297\'"],
["E. bassleri P8","Sisa, San Martin, Peru","550 m","available upon request"],
["E. bassleri P9","Sisa, San Martin, Peru","550 m","available upon request"],
["E. bassleri P10","Tarapoto, San Martin, Peru","780 m","S 6.43307\' W 76.30383\'"],
["E. bassleri P11","Moyobamba, San Martin, Peru","320 m","S 6.32393\' W 76.73437\'"],
["E. bilinguis","Primavera, Napo, Ecuador","300 m","S 0.23544\' W 76.96819\'"],
["E. cainarachi P1","Cainarachi, San Martin, Peru","350 m","S 6.45043\' W 76.31758\'"],
["E. cainarachi P2","Tarapoto, San Martin, Peru","770m","S 6.43536\' W 76.35011\'"],
["E. hahneli B1","Amazonas, Brazil","50 m","NA"],
["E. hahneli B2","Amazonas, Brazil","50 m","NA"],
["E. hahneli P1","Ivochote, Cuzco, Peru","620 m","S12.47086\' W 72.99389\'"],
["E. hahneli P2","Sisa, San Martin, Peru","650 m","S 6.58299\' W 76.50974\'"],
["E. hahneli P2","Tarapoto, San Martin, Peru","500 m","NA"],
["E. hahneli P3","Tarapoto, San Martin, Peru","500 m","NA"],
["E. hahneli P4","Tarapoto, San Martin, Peru","600 m","S 6.47777\' W 76.32274\'"],
["E. hahneli P6","Saposoa, San Martin, Peru","850 m","S 6.77107\' W 76.94120\'"],
["E. hahneli P7","Chazuta, San Martin, Peru","560 m","S 6.52818\' W 76.13942\'"],
["E. hahneli P8","Tarapoto, San Martin, Peru","500 m","NA"],
["E. hahneli P9","Tarapoto San Martin, Peru","600 m","S 6.47777\' W 76.32274\'"],
["E. hahneli P11","Itaya, Loreto, Peru","100 m","S 4.45\' W 73.57\'"],
["E. hahneli P10","Rio Manova Loreto, Peru","110 m","S 3.65201\' W 72.20045\'"],
["E. hahneli P12","Itaya, Loreto, Peru","100 m","S 4.45\' W 73.57\'"],
["E. hahneli P13","Convento, San Martin, Peru","200 m","S 6.25107\' W 76.31459\'"],
["E. hahneli P14","Alto Purus, Ucayali, Peru","300 m","S10.90\' W 73.17\'"],
["E. hahneli P15","Alto Purus, Ucayali, Peru","300 m","S10.90\' W 73.17\'"],
["E. hahneli P16","Alto Purus, Ucayali, Peru","300 m","S10.90\' W 73.17\'"],
["E. hahneli P I7","Allpahuayo, Loreto, Peru","130 m","S 3.87\' W 73.57\'"],
["E. hahneli P18","Boca Manu, Cuzco, Peru","250 m","S12.25\' W 70.9\'"],
["E. macero P1","Ivochote, Cuzco, Peru","620 m","S 12.47086\' W 72.99385\'"],
["E. macero P2","Alto Purus, Ucayali, Peru","300 m","S10.90\' W 73.17\'"],
["E. pongoensis P1","Convento, San Martin, Peru","200 m","S 6.25107\' W 76.31459\'"],
["E. pongoensis P2","Huallaga, San Martin, Peru","390 m","S 6.54870\' W 75.96169\'"],
["E. silverstonei","Tingo Maria, Huanuco, Peru","1000 m","S 9.31918\' W 75.97697\'"],
["E. simulans P1","Madre de Dios, Peru","380 m","S12.97040\' W 70.34107\'"],
["E. simulans P2","Quincemille, Cuzco, Peru","490 m","S13.18396\' W 70.63308\'"],
["E. smaragdinus","Iscozazin, Pasco, Peru","350 m","S10.18879\' W 75.16052\'"],
["E. trivittatus B1","Amazonas, Brazil","50 m","NA"],
["E. trivittatus B2","Porto Walter, Acre, Brazil","200 m","S8.25\' W 72.74\'"],
["E. trivittatus FG","French Guiana","200 m","S 3.9\' W 53.0\'"],
["E. trivittatus P1","Rio Sucusari, Loreto, Peru","100 m","S 3.24073\' W 72.92835\'"],
["E. trivittatus P2","Iscozazin, Pasco, Peru","350 m","S 10.18879\' W 75.16052\'"],
["E. trivittatus P3","Panasa, San Martin, Peru","Lowland","NA"],
["E. trivittatus P4","Tahuayo, Loreto, Peru","140 m","S 4.18707\' W 73.10457\'"],
["E. trivittatus P5","Tahuayo, Loreto, Peru","140 m","S 4.18707\' W 73.10457\'"],
["E. trivittatus P6","Santa Rosa, Huanuco, Peru","Lowland","NA"],
["E. trivittatus P7","Chazuta, San Martin, Peru","260 m","S 6.57434\' W 76.14362\'"],
["E. trivittatus P8","Barranquita, San Martin, Peru","220 m","S 6.28910\' W 76.22865\'"],
["E. trivittatus P9","Chumilla, San Martin, Peru","Lowland","NA"],
["E. trivittatus P10","Rio Manati, Loreto, Peru","110 m","S 3.65201\' W 72.20045\'"],
["E. trivittatus P11","Loreto, Peru","Lowland","NA"],
["E. trivittatus P12","Alto Purus, Ucayali, Peru","300 m","S10.90\' W 73.17\'"],
["E. trivittatus P13","Bonilla, San Martin, Peru","200 m","S 6.21007\' W 76.27226\'"],
["E. trivittatus P14","Tarapoto, San Martin, Peru","540 m","S 6.43066\' W 76.29034\'"],
["E. trivittatus P15","Boca Manu, Cuzco, Peru","300 m","S 12.25\' W 70.90\'"]
]
}');


array_push($tables,
'{
"label":"Table 1",
"caption":"Localities of the investigated D. pumilio populations and related species, characteristic colouration and pattern, and accession numbers of gene fragments",
"header":[
["Population/species{@m1}","Country{@m1}","Colour and pattern{@m1}","GPS coordinates or localities{@m1}","GenBank accession numbers","-","-"],
["16S","Cyt b","COI"]
],
"rows":[
["Upala{@m1}","Costa Rica{@m1}","Red dorsum and venter, blue legs{@m1}","N10° 54.448\'","EF597169{@m1}","EF597209{@m1}","EF597189{@m1}"],
["W85° 02.494\'"],
["","","","","","",""],
["Cao Negro{@m1}","Costa Rica{@m1}","Red dorsum and venter, blue legs{@m1}","N10° 51.543\'","EF597162","EF597202","EF597182"],
["W84° 46.461\'","","",""],
["","","","","","",""],
["La Selva{@m1}","Costa Rica{@m1}","Spotted, with red dorsum and venter, blue legs{@m1}","N10° 26.499\'","EF597164{@m1}","EF597204{@m1}","EF597184{@m1}"],
["W84° 46.461\'"],
["","","","","","",""],
["Tortuguero{@m1}","Costa Rica{@m1}","Spotted, with red dorsum and venter, blackish-blue legs{@m1}","N10° 36.773\'","EF597168","EF597208","EF597188"],
["W83° 31.868\'","","",""],
["","","","","","",""],
["Gupiles{@m1}","Costa Rica{@m1}","Red dorsum and venter, blue legs{@m1}","N10° 11.297\'","EF597163{@m1}","EF597203{@m1}","EF597183{@m1}"],
["W83° 49.274\'"],
["","","","","","",""],
["Pueblo Nuevo{@m1}","Costa Rica{@m1}","Red dorsum and venter, blue legs{@m1}","N10° 19.305\'","EF597165","EF597205","EF597185"],
["W83° 34.440\'","","",""],
["","","","","","",""],
["Siquirres{@m1}","Costa Rica{@m1}","Spotted, with red dorsum and venter, blackish-blue legs{@m1}","N10° 05.546\'","EF597167{@m1}","EF597207{@m1}","EF597187{@m1}"],
["W83° 31.121\'"],
["","","","","","",""],
["Puerto Viejo{@m1}","Costa Rica{@m1}","Red dorsum and venter with brownish pattern, red legs{@m1}","N09° 38.512\'","EF597166","EF597206","EF597186"],
["W82° 45.223\'","","",""],
["","","","","","",""],
["Bribri{@m1}","Costa Rica{@m1}","Spotted, with red dorsum and venter, red legs{@m1}","N09° 38.437\'","EF597161","EF597201","EF597181"],
["W82° 52.573\'","","",""],
["","","","","","",""],
["Almirante{@m1}","Panama{@m1}","Red dorsum and venter, grey legs{@m1}","N9° 17.166\'","EF597170","EF597210","EF597190"],
["W82° 23.439\'","","",""],
["","","","","","",""],
["Tierra Oscura{@m1}","Panama{@m1}","Black/blue dorsum and legs, blue venter{@m1}","N9° 10.736\'","EF597180","EF597220","EF597200"],
["W82° 15.527\'","","",""],
["","","","","","",""],
["Isla Coln{@m1}","Panama{@m1}","Spotted, with green dorsum, yellow venter, brown legs{@m1}","N9° 23.418\'","EF597172","EF597212","EF597192"],
["W82° 14.182\'","","",""],
["","","","","","",""],
["Isla Bastimentos{@m1}","Panama{@m1}","Red dorsum, white venter, grey legs{@m1}","N9°17.420 \'","EF597171","EF597211","EF597191"],
["W82° 04.949\'","","",""],
["","","","","","",""],
["Isla Solarte{@m1}","Panama{@m1}","Orange dorsum and venter, orange legs{@m1}","N9°20.096 \'","EF597179","EF597219","EF597199"],
["W82° 13.140\'","","",""],
["","","","","","",""],
["Isla San Cristbal{@m1}","Panama{@m1}","Red dorsum and venter, grey legs{@m1}","N9° 16.291\'","EF597178","EF597218","EF597198"],
["W82° 17.403\'","","",""],
["","","","","","",""],
["Isla Pastores{@m1}","Panama{@m1}","Yellow/brown dorsum and legs, yellow venter{@m1}","N9° 14.395\'","EF597176","EF597216","EF597196"],
["W82° 21.033\'","","",""],
["","","","","","",""],
["Isla Popa{@m1}","Panama{@m1}","Dark green dorsum, blue venter and legs{@m1}","N9°13.109 \'","EF597177{@m1}","EF597217{@m1}","EF597197{@m1}"],
["W82° 08.468\'"],
["","","","","","",""],
["Isla Cayo de Agua{@m1}","Panama{@m1}","Green dorsum, yellow venter, blue legs{@m1}","N9° 09.187\'","EF597173","EF597213","EF597193"],
["W82° 03.305\'","","",""],
["","","","","","",""],
["Isla Loma Partida{@m1}","Panama{@m1}","Spotted, with green/blue dorsum, blue venter, brown legs{@m1}","N9° 08.202\'","EF597175","EF597215","EF597195"],
["W82° 09.955\'","","",""],
["","","","","","",""],
["Isla Escudo de Veraguas{@m1}","Panama{@m1}","Red dorsum, light blue flanks, venter, and legs{@m1}","N9° 06.106\'","EF597174{@m1}","EF597214{@m1}","EF597194{@m1}"],
["W81° 32.959\'"],
["","","","","","",""],
["D. arboreus","Panama","Yellow spots, brown or black dorsum and venter","Fortuna","AF098748","AF120015","AF097504"],
["","","","","","",""],
["D. speciosus","Panama","Irregular black spots, bright red dorsum and venter","Fortuna","AF098747","AF120014","AF097503"],
["","","","","","",""],
["D. histrionicus","Ecuador","Black pattern on orange, yellow, red, white or blue base colour","Santo Domingo","AF098742","AF120009","AF097498"],
["","","","","","",""],
["D. granuliferus","Costa Rica","Red or orange dorsum, green to blue-green legs","Corcovado national park","AF098749","AF120016","AF097505"]
]
}
');


array_push($tables, '
{
"label":"Table 1",
"caption":"Ecteinascidia turbinata populations sampled with their geographical location, sample size (N), and color morph observed",
"header":[
["Sea","Population","GPS position","N","Color morph"]
],
"rows":[
["Atlantic","Fort Pierce","27:30:08N; 80:18:48W","18","White"],
["","Cdiz","36:23:49N; 6:12:16W","15","White"],
["","","","",""],
["Caribbean","Key Largo","25:04:10N; 80:27:45W","17","Orange, white"],
["","Long Key","24:49:04N; 80:48:07W","16","Orange"],
["","Islamorada","24:53:88N; 80:39:63W","17","Orange, white"],
["","Rodriguez Key","25:03:12N; 80:27:09W","18","Orange"],
["","","","",""],
["Mediterranean","Pollena","39:54:34N; 3:05:57E","31","White"],
["","Alcdia","39:49:35N; 3:08:50E","31","White"]
]
}');



array_push($tables,'
{
"label":"Table 1",
"caption":"Specimen information and GenBank accession numbers for samples included in this study",
"header":[
["OTUa","GenBank Accession No.","Museum Catalog No. or Tissue Voucher ID","Collection date","Locality","Geographic coordinates","Sexb","ID by"]
],
"rows":[
["I.coi.9059.MED","DQ373940","NMNH #00729059","8/16/1967","Mediterranean Sea, Tunisia","36°57\'N, 10°37\'E","I","C.C. Lu"],
["I.coi.9046.WA","DQ373933","NMNH #00729046","12/2/1969","N. Atlantic, Dominica Island","15°34\'N, 61°10\'W","F","C.C. Lu"],
["I.coi.9027.EA","DQ373929","NMNH #00729027","9/9/1963","N. Atlantic, Congo, Gulf of Guinea","4°30\'S, 10°54\'E","F","C.C. Lu"],
["I.coi.9039.WA","DQ373937","NMNH #00729039","12/7/1969","Caribbean Sea, Antigua","18°07\'N, 64°20\'W","I","C.C. Lu"],
["I.coi.9021.WA","DQ373953","NMNH #00729021","12/14/1967","N. Atlantic, Cape Charles VA","37°06\'N, 74°35\'W","M","C.C. Lu"],
["I.coi.9036.WA","DQ373954","NMNH #00729036","8/31/1967","N. Atlantic, Kitty Hawk NC","36°05\'N, 74°52\'W","I","C.C. Lu"],
["I.coi.9060.EA","DQ373951","NMNH #00729060","2/26/1964","N. Atlantic, Cameroon, Gulf of Guinea","4°58\'N, 0°30\'W","I","C.C. Lu"],
["I.coi.9035.WA","DQ373945","NMNH #00729035","8/30/1967","N. Atlantic, Norfolk VA","36°42\'N, 74°45\'W","I","C.C. Lu"],
["I.coi.5263.WAG","DQ373944","NMNH #00575263","6/26/1956","Gulf of Mexico, Louisiana","29°11\'N, 88°05\'W","I","C.C. Lu"],
["I.coi.9066.WA","DQ373931","NMNH #00729066","12/10/1969","N. Atlantic, Puerto Rico","18°18\'N, 63°24\'W","I","C.C. Lu"],
["I.coi.9070.WA","DQ373947","NMNH #00729070","12/6/1969","N. Atlantic, Puerto Rico","18°28\'N, 63°23\'W","I","C.C. Lu"],
["I.coi.3710.MED","DQ373942","NMNH #283710","8/24/1967","Mediterranean Sea, Tunisia","36°47\'N, 11°11\'E","M","M.J. Sweeney"],
["I.coi.7410.EA","DQ373952","NMNH #00727410","5/11/1965","N. Atlantic, Gulf of Guinea","5°56\'N, 4°27\'E","F","G. Voss"],
["I.coi.GenBank.EA","AY557542c","","2001","Mediterranean Sea, France","","?","S. Boletzky"],
["I.ill.4754.WA","DQ373924","NMNH #00814754","7/26/1969","N. Atlantic, North Carolina","35°45\'N, 74°49\'W","I","?"],
["I.ill.4751.WA","DQ373923","NMNH #00814751","8/4/1977","N. Atlantic, Maryland","38°00\'N, 74°00\'W","I","?"],
["I.ill.7012.WA","DQ373925","NMNH #00577012","7/18/1957","N. Atlantic, Florida","29°56\'N, 80°12\'W","F","C.C. Lu"],
["I.ill.7008.WA","DQ373928","NMNH #00577008","08/23/1883","N. Atlantic","40°20\'N, 70°35\'W","M","C.C. Lu"],
["I.ill.4296.WA","DQ373934","NMNH #00034296","8/13/1882","N. Atlantic, Newfoundland","52°20\'N, 55°30\'W","M","C.C. Lu"],
["I.ill.9042.WA","DQ373926","NMNH #00729042","11/16/1968","Caribbean Sea, Jamaica","16°43\'N, 81°53\'W","M","C.C. Lu"],
["I.ill.4752.WA","DQ373927","NMNH #00814752","10/27/1972","N. Atlantic, North Carolina","34°29\'N, 75°48\'W","I","C.F.E. Roper"],
["I.ill.CH-01-073.WA","DQ373935","CH-01-073","2001","N. Atlantic, North Carolina","","M","M. Vecchione"],
["I.ill.CH-01-061.WA","DQ373939","CH-01-061","2001","N. Atlantic, North Carolina","","F","M. Vecchione"],
["I.ill.RVDel.WA","DQ373936","R/V Del. II 99-02","2/1/1999","N.W. Atlantic","","I","M. Vecchione"],
["I.ill.SJII-01-005.WA","DQ373941","R/V SJ II-01-005","9/20/2001","N.W. Atlantic, North Carolina","","I","M. Vecchione"],
["I.ill.ALB9402.WA","DQ373938","ALB 9402","4/22/1994","N.W. Atlantic, Gulf of Maine","","I","M. Vecchione"],
["I.oxy.5146.WAG","DQ373932","00575146","4/14/1954","Gulf of Mexico (near FL Keys)","24°28\'N, 83°25\'W","F","C.F.E. Roper"],
["I.oxy.0215.WA","DQ373946","00730215","1/20/1968","N. Atlantic, Virginia","37°57\'N, 74°06\'W","F","C.C. Lu"],
["I.oxy.5495.WA","DQ373956","00815495","8/25/1967","N. Atlantic, New Jersey","38°30\'N, 74°53\'W","F","C.C. Lu"],
["I.oxy.7604.WA","DQ373950","00577604","8/25/1967","N. Atlantic, Delaware","37°34\'N, 73°33\'W","M","C.F.E. Roper"],
["I.oxy.5086.WA","DQ373955","00575086","10/8/1892","N. Atlantic, Delaware","38°52\'N, 72°58\'W","M","C.C. Lu"],
["I.oxy.9052.WAG","DQ373948","00729052","8/27/1970","Gulf of Mexico, Tampa FL","27°49\'N, 85°12\'W","M","C.C. Lu"],
["I.oxy.7602.WA","DQ373949","00577602","8/31/1967","N. Atlantic, North Carolina","36°18\'N, 74°52\'W","M","C.F.E. Roper"],
["I.oxy.CH-01-049.WA","DQ373943","CH-01-049","2001","N. Atlantic, North Carolina","","F","M. Vecchione"],
["I.oxy.CH-01-059.WA","DQ373930","CH-01-059","2001","N. Atlantic, North Carolina","","M","M. Vecchione"],
["I.arg.0001.SA","DQ373957","0001","2005","S. Atlantic","","F","D. Carlini"],
["I.arg.0002.SA","DQ373960","0002","2005","S. Atlantic","","F","D. Carlini"],
["I.arg.0003.SA","DQ373958","0003","2005","S. Atlantic","","M","D. Carlini"],
["I.arg.0004.SA","DQ373959","0004","2005","S. Atlantic","","F","D. Carlini"]
]
}
');


array_push($tables, '

{
"label":"Table 1",
"caption":"Species information and GenBank accession numbers",
"header":[
["Species{@m1}","Locality{@m1}","Longitude/latitude{@m1}","Voucher number{@m1}","GenBank Accession Nos.","-","-","-"],
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
');

array_push($tables,
'{
"label":"Table 1",
"caption":"Specimen and sequence information for taxa included in this study",
"header":[
["Taxon{@m1}","MY No.a{@m1}","Locationb{@m1}","Lat/Long{@m1}","Accession No.","-","-"],
["COI","18S","28S"]
],
"rows":[
["Antrodiaetus sp. OR","MY 2880","Oregon, USA","N 43.97493°","","",""],
["","","","W 122.16516°","DQ981631","DQ981667","DQ981703"],
["Antrodiaetus sp. AR","MY 3385","Arkansas, USA","N 35.72209°","","",""],
["","","","W 94.40863°","DQ981632","DQ981668","DQ981704"],
["Antrodiaetus apachecus","MY 0118","Arizona, USA","N 33.99767°","","",""],
["Coyle, 1971","","","W 109.46417°","DQ981633","DQ981669","DQ981705"],
["Antrodiaetus apachecus","MY 0273","Arizona, USA","N 33.89368°","","",""],
["Coyle, 1971","","","W 109.15253°","DQ981634","DQ981670","DQ981706"],
["Antrodiaetus cerberus","MY 2919","Washington, USA","N 48.94325°","","",""],
["Coyle, 1971","","","W 117.59017°","DQ981635","DQ981671","DQ981707"],
["Antrodiaetus hageni","MY 2916","Oregon, USA","N 44.83394°","","",""],
["(Chamberlin, 1917)","","","W 117.42642°","DQ981636","DQ981672","DQ981708"],
["Antrodiaetus microunicolor","MY 2000","Georgia, USA","N 34.75646°","","",""],
["Hendrixson and Bond, 2005","","","W 84.70615°","DQ981637","DQ981673","DQ981709"],
["Antrodiaetus microunicolor","MY 2402","North Carolina, USA","N 35.06337°","","",""],
["Hendrixson and Bond, 2005","","","W 83.43687°","DQ981638","DQ981674","DQ981710"],
["Antrodiaetus montanus","MY 2910","Oregon, USA","N 43.14605°","","",""],
["(Chamberlin and Ivie, 1933)","","","W 122.12747°","DQ981639","DQ981675","DQ981711"],
["Antrodiaetus montanus","MY 2915","Idaho, USA","N 42.73289°","","",""],
["(Chamberlin and Ivie, 1933)","","","W 112.38114°","DQ981640","DQ981676","DQ981712"],
["Antrodiaetus occultus","MY 2908","Oregon, USA","N 44.55564°","","",""],
["Coyle, 1971","","","W 123.27097°","DQ981641","DQ981677","DQ981713"],
["Antrodiaetus pacificus","MY 2897","Oregon, USA","N 42.16319°","","",""],
["(Simon, 1884)","","","W 122.70294°","DQ981642","DQ981678","DQ981714"],
["Antrodiaetus pacificus","MY 2917","Oregon, USA","N 45.09817°","","",""],
["(Simon, 1884)","","","W 118.59050°","DQ981643","DQ981679","DQ981715"],
["Antrodiaetus pacificus","MY 2924","Washington, USA","N 47.71447°","","",""],
["(Simon, 1884)","","","W 121.34508°","DQ981644","DQ981680","DQ981716"],
["Antrodiaetus pacificus","MY 2933","Oregon, USA","N 44.79617°","","",""],
["(Simon, 1884)","","","W 118.00044°","DQ981645","DQ981681","DQ981717"],
["Antrodiaetus pacificus","MY 3050","California, USA","N 41.00960°","","",""],
["(Simon, 1884)","","","W 123.64559°","DQ981646","DQ981682","DQ981718"],
["Antrodiaetus pugnax","MY 2918","Washington, USA","N 46.07994°","","",""],
["(Chamberlin, 1917)","","","W 118.25894°","DQ981647","DQ981683","DQ981719"],
["Antrodiaetus robustus","MY 2203","Pennsylvania, USA","N 40.16885°","","",""],
["(Simon, 1890)","","","W 79.23348°","DQ981648","DQ981684","DQ981720"],
["Antrodiaetus robustus","MY 2208","Virginia, USA","N 38.81860°","","",""],
["(Simon, 1890)","","","W 78.79775°","DQ981649","DQ981685","DQ981721"],
["Antrodiaetus robustus","MY 2839","Indiana, USA","N 38.27747°","","",""],
["(Simon, 1890)","","","W 86.53899°","DQ981650","DQ981686","DQ981722"],
["Antrodiaetus roretzi","MY 3082","Kanagawa, JAPAN","N 35.26667°","","",""],
["(L. Koch, 1878)","","","E 139.60000°","DQ981651","DQ981687","DQ981723"],
["Antrodiaetus stygius","MY 2813","Arkansas, USA","N 36.06459°","","",""],
["Coyle, 1971","","","W 91.14906°","DQ981652","DQ981688","DQ981724"],
["Antrodiaetus stygius","MY 2823","Missouri, USA","N 37.71681°","","",""],
["Coyle, 1971","","","W 92.85632°","DQ981653","DQ981689","DQ981725"],
["Antrodiaetus unicolor","MY 2005","Georgia, USA","N 34.75646°","","",""],
["(Hentz, 1841)","","","W 84.70615°","DQ981654","DQ981690","DQ981726"],
["Antrodiaetus unicolor","MY 2015","Alabama, USA","N 34.49877°","","",""],
["(Hentz, 1841)","","","W 85.61774°","DQ981655","DQ981691","DQ981727"],
["Antrodiaetus unicolor","MY 2300","North Carolina, USA","N 35.05467°","","",""],
["(Hentz, 1841)","","","W 83.43208°","DQ981656","DQ981692","DQ981728"],
["Antrodiaetus unicolor","MY 2837","Indiana, USA","N 38.27747°","","",""],
["(Hentz, 1841)","","","W 86.53899°","DQ981657","DQ981693","DQ981729"],
["Antrodiaetus yesoensis","MY 3236","Hokkaido, JAPAN","N 42.96670°","","",""],
["(Uyemura, 1942)","","","E 141.16940°","DQ981658","DQ981694","DQ981730"],
["Atypoides gertschi","MY 0431","Oregon, USA","N 42.17383°","","",""],
["Coyle, 1968","","","W 122.71433°","DQ981659","DQ981695","DQ981731"],
["Atypoides gertschi","MY 2894","Oregon, USA","N 42.16319°","","",""],
["Coyle, 1968","","","W 122.70294°","DQ981660","DQ981696","DQ981732"],
["Atypoides hadros","MY 3390","Missouri, USA","N 37.80127°","","",""],
["Coyle, 1968","","","W 90.30163°","DQ981661","DQ981697","DQ981733"],
["Atypoides riversi","MY 2876","California, USA","N 38.94600°","","",""],
["O. P.-Cambridge 1883","","","W 120.09808°","DQ981662","DQ981698","DQ981734"],
["Atypoides riversi","MY 3039","California, USA","N 39.26095°","","",""],
["O. P.-Cambridge 1883","","","W 123.54851°","DQ981663","DQ981699","DQ981735"],
["Sphodros sp.","MY 0026","","","","",""],
["","","","","DQ981664","DQ981700","DQ981736"],
["Aliatypus sp.","MY 0106","","","","",""],
["","","","","DQ981665","DQ981701","DQ981737"],
["Aliatypus sp.","MY 0260","","","","",""],
["","","","","DQ981666","DQ981702","DQ981738"]
]
}');



array_push($tables, '
{
"label":"",
"caption":"Location data for Banza individuals sampled and GenBank accession numbers for sequences used in our analyses",
"header":[
["Taxon","Island","Location","Latitude","Longitude","COI Accession No.","Cytochrome b Accession No."]
],
"rows":[
["B. nihoa (A)","Nihoa","Miller Peak","23°03\'44\'\'N","161°55\'34\'\'W","DQ649491","DQ649515"],
["B. nihoa (B)","Nihoa","Miller Peak","23°03\'44\'\'N","161°55\'34\'\'W","DQ649492","DQ649516"],
["B. kauaiensis (A)a","Kauai","Alexander Dam","21°58\'30\'\'N","159°27\'58\'\'W","DQ649483","DQ649507"],
["B. kauaiensis (B)b","Kauai","Kokee, Pihea Trail","22°09\'14\'\'N","159°37\'30\'\'W","DQ649484","DQ649508"],
["B. unica (A)c","Oahu","Mount Tantalus","21°20\'14\'\'N","157°49\'04\'\'W","DQ649501","DQ649525"],
["B. unica (B)d","Oahu","Palikea Trail","21°24\'59\'\'N","158°06\'13\'\'W","DQ649502","DQ649526"],
["B. parvula (A)","Oahu","Puu Kaua","21°26\'41\'\'N","158°06\'05\'\'W","DQ649497","DQ649521"],
["B. parvula (B)","Oahu","Peacock Flats","21°32\'57\'\'N","158°11\'13\'\'W","DQ649498","DQ649522"],
["B. molokaiensis (A)","Molokai","Puu Kole Kole","21°06\'35\'\'N","156°54\'10\'\'W","DQ649487","DQ649511"],
["B. molokaiensis (B)","Molokai","Puu Kole Kole","21°06\'35\'\'N","156°54\'10\'\'W","DQ649488","DQ649512"],
["B. deplanata (A)","Lanai","Lanaihale","20°48\'53\'\'N","156°52\'33\'\'W","DQ649481","DQ649505"],
["B. deplanata (B)","Lanai","Lanaihale","20°48\'53\'\'N","156°52\'14\'\'W","DQ649482","DQ649506"],
["B. brunnea (A)","Maui (West)","Kaulalewelewe","20°56\'14\'\'N","156°37\'10\'\'W","DQ649479","DQ649503"],
["B. brunnea (B)","Maui (West)","Lihau","20°51\'18\'\'N","156°36\'12\'\'W","DQ649480","DQ649504"],
["B. mauiensis (A)","Maui (West)","Hanaula","20°50\'42\'\'N","156°33\'26\'\'W","DQ649485","DQ649509"],
["B. mauiensis (B)","Maui (West)","Hanaula","20°50\'42\'\'N","156°33\'26\'\'W","DQ649486","DQ649510"],
["B. pilimauiensis (A)","Maui (East)","Waikamoi","20°49\'04\'\'N","156°13\'49\'\'W","DQ649499","DQ649523"],
["B. pilimauiensis (B)","Maui (East)","Waikamoi","20°49\'04\'\'N","156°13\'49\'\'W","DQ649500","DQ649524"],
["B. nitida (A)","Hawaii","Kealakekua","19°30\'32\'\'N","155°51\'46\'\'W","DQ649493","DQ649517"],
["B. nitida (B)","Hawaii","Stainback","19°34\'14\'\'N","155°11\'19\'\'W","DQ649495","DQ649519"],
["B. nitida (C)e","Hawaii","Puu Iki","20°07\'45\'\'N","155°46\'09\'\'W","DQ649494","DQ649518"]
]
}
');



array_push($tables, '{
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
');


array_push($tables, '
{
"label":"",
"caption":"Site information, specimens sampled, and GenBank accession numbers",
"header":[
["Site information","-","-","-","Specimen information","-","-",""],
["No.","Location","Coordinates","Elev (m)","No.","Museum No.","Accession No.",""]
],
"rows":[
["1","Ecuador: Sucumbos: Lumbaqu","N 0°6\'41\"; W 77°22\'28\"","610","1","QCAZ 25790","EF470253",""],
["2","Ecuador: Sucumbos: Puerto Bolivar","S 0°5\'19\"; W 76°8\'31\"","240","2","QCAZ 27813","EF470254",""],
["","3","QCAZ 28169","EF470255",""],
["","4","QCAZ 28172","EF470256",""],
["","5","QCAZ 28178","EF470257",""],
["3","Ecuador: Sucumbos: La Selva Lodge","S 0°29\'20\"; W 76°22\'29\"","226","6","QCAZ 23975","EF011530",""],
["","7","QCAZ 24029","EF011531",""],
["","8","(DCC 3705)","EF011532",""],
["4","Ecuador: Orellana: Tiputini Biodiversity Station","S 0°38\'14\"; W 76°9\'54\"","208","9","QCAZ 28610","EF011535",""],
["","10","QCAZ 28611","EF011534",""],
["","11","QCAZ 28612","EF011538",""],
["","12","QCAZ 28620","EF011533",""],
["5","Ecuador: Orellana: Estacin Cientfica Yasun","S 0°40\'41\"; W 76°23\'48\"","250","13","QCAZ 11863","EF011539",""],
["","14","QCAZ 12128","DQ337233",""],
["","15","QCAZ 15136","EF011543",""],
["","16","QCAZ 15138","EF011542",""],
["6","Ecuador: Napo: Jatun Sacha Biological Station","S 1°2\'24\"; W 77°21\'36\"","450","17","QCAZ 24045","EF011521",""],
["","18","(MJR 005)","EF011523",""],
["","19","(MJR 006)","EF011524",""],
["","20","(MJR 008)","EF011525",""],
["7","Ecuador: Napo: Cando","S 1°4\'1\"; W 77°55\'59\"","702","21","QCAZ 11965","DQ337231",""],
["","22","(DCC 3699)","EF011516",""],
["","23","(DCC 3701)","EF011517",""],
["","24","(DCC 3710)","EF011518",""],
["8","Ecuador: Pastaza: Puyo","S 1°26\'35\"; W 77°59\'48\"","954","25","QCAZ 26210","DQ337230",""],
["","26","QCAZ 26211","EF470258",""],
["","27","QCAZ 28857","EF470259",""],
["9+","Ecuador: Pastaza: Shell+","S 1°30\'; W 78°3\'+","1069","28","QCAZ 25038","EF470260",""],
["","29","QCAZ 25039","EF470261",""],
["10","Peru: Loreto: San Jacinto","S 2°18\'45\"; W 75°51\'46\"","180","30","KUNHM 222069","EF470262",""],
["","31","KUNHM 222070","EF470263",""],
["","32","KUNHM 222071","EF470264",""],
["11","Peru: Loreto: Amazon Conservancy for Tropical Studies","S 3°15\'34\"; W 72°54\'10\"","102","33","MUSM 21546","EF470265",""],
["","34","MUSM 21556","EF470266",""],
["","35","MUSM 21562","EF470267",""],
["","36","MUSM 21564","EF470268",""],
["12","Peru: Madre de Dios: Cusco Amaznico","S 12°35\'; W 69°5\'","200","37","KUNHM 215534","EF470269",""],
["13","Peru: Madre de Dios: Trail between Madre de Dios River and Lago Sandoval","S 12°36\'; W 69°5\'","200","38","KUNHM 215133","EF470270",""],
["14+","Peru: Madre de Dios: Explorers Inn+","S 12°50\'18\"; W 69°17\'45\"+","207","39","USNM 343260","EF011546",""],
["","40","USNM 343264","EF011545",""],
["15","Peru: Madre de Dios: Tambopata Research Center","S 13°8\'6\"; W 69°36\'23\"","167","41","MUSM 19363","EF011550",""],
["","42","MUSM 19368","EF011547",""],
["","43","MUSM 19403","EF011548",""],
["","44","MUSM 19404","EF011549",""],
["16","Peru: Madre de Dios: south side of Tambopata River across from Tambopata Research Center","S 13°8\'36\"; W 69°35\'51\"","201","45","MUSM 19348","EF011551",""],
["","46","MUSM 19380","EF011553",""],
["","47","MUSM 19381","EF011552",""],
["","48","MUSM 19382","EF011554",""],
["17","Bolivia: La Paz: Chalaln Ecolodge","S 14°25\'29\"; W 67°55\'14\"","400","49","MNCN/ADN 2823","EF470271",""],
["","50","MNCN/ADN 2845","EF470272",""],
["","51","MNCN/ADN 2846","EF470273",""],
["18","Brazil: Par: Agropecuria Treviso","S 3°9\'; W 54°50\'","122","52","LSUMZ 18728","EF470274",""],
["","53","LSUMZ 18729","EF470275",""],
["","54","LSUMZ 18730","EF470276",""],
["","55","LSUMZ 18731","EF470277",""],
["19+","Brazil: Acre: Porto Walter+","S 8°15\'31\"; W 72°46\'37\"+","219","56","LSUMZ 13649","EF470278",""],
["","57","LSUMZ 13687","EF470279",""],
["20","Brazil: Acre: Mouth of Tejo River","S 9°3\'; W 72°44\'","260","58","ZUEC 9511","DQ337229",""],
["21","Brazil: Acre: Restauraao","S 9°3\'; W 72°17\'","272","59","ZUEC 9523","EF011544",""],
["22","Brazil: Rondnia: Parque Estadual Guajar-Mirim","S 10°19\'17\"; W 64°33\'48\"","151","60","LSUMZ 17422","EF470280",""],
["","61","LSUMZ 17427","EF470281",""],
["","62","LSUMZ 17459","EF470282",""],
["","63","LSUMZ 17467","EF470283",""],
["","64","LSUMZ 17489","EF470284",""],
["","65","LSUMZ 17523","EF470285",""],
["P. pustulosus","Panama: Panama: Gamboa","-","-","66","(KM91)","DQ337239",""],
["","Mexico: Chiapas: Puerto Madera","-","-","67","(LW1033)","DQ337247",""],
["P. pustulatus","Ecuador: Guayas: Cerro Blanco","-","-","68","QCAZ 23420","DQ337215",""],
["P. coloradorum","Ecuador: Pichincha: La Florida","-","-","69","QCAZ 19418","DQ337222",""]
]
}');



array_push($tables,'
{
"label":"",
"caption":"Site information, specimens sampled, and GenBank accession numbers",
"header":[
["Site information","-","-","-","Specimen information","-","-",""],
["No.","Location","Coordinates","Elev (m)","No.","Museum No.","Accession No.",""]
],
"rows":[
["1","Ecuador: Sucumbos: Lumbaqu","N 0°6\'41\"; W 77°22\'28\"","610","1","QCAZ 25790","EF470253",""],
["2{@m3}","Ecuador: Sucumbos: Puerto Bolivar{@m3}","S 0°5\'19\"; W 76°8\'31\"{@m3}","240","2","QCAZ 27813","EF470254",""],
["","3","QCAZ 28169","EF470255",""],
["","4","QCAZ 28172","EF470256",""],
["","5","QCAZ 28178","EF470257",""],
["3{@m2}","Ecuador: Sucumbos: La Selva Lodge{@m2}","S 0°29\'20\"; W 76°22\'29\"{@m2}","226","6","QCAZ 23975","EF011530",""],
["","7","QCAZ 24029","EF011531",""],
["","8","(DCC 3705)","EF011532",""],
["4{@m3}","Ecuador: Orellana: Tiputini Biodiversity Station{@m3}","S 0°38\'14\"; W 76°9\'54\"{@m3}","208","9","QCAZ 28610","EF011535",""],
["","10","QCAZ 28611","EF011534",""],
["","11","QCAZ 28612","EF011538",""],
["","12","QCAZ 28620","EF011533",""],
["5{@m3}","Ecuador: Orellana: Estacin Cientfica Yasun{@m3}","S 0°40\'41\"; W 76°23\'48\"{@m3}","250","13","QCAZ 11863","EF011539",""],
["","14","QCAZ 12128","DQ337233",""],
["","15","QCAZ 15136","EF011543",""],
["","16","QCAZ 15138","EF011542",""],
["6{@m3}","Ecuador: Napo: Jatun Sacha Biological Station{@m3}","S 1°2\'24\"; W 77°21\'36\"{@m3}","450","17","QCAZ 24045","EF011521",""],
["","18","(MJR 005)","EF011523",""],
["","19","(MJR 006)","EF011524",""],
["","20","(MJR 008)","EF011525",""],
["7{@m3}","Ecuador: Napo: Cando{@m3}","S 1°4\'1\"; W 77°55\'59\"{@m3}","702","21","QCAZ 11965","DQ337231",""],
["","22","(DCC 3699)","EF011516",""],
["","23","(DCC 3701)","EF011517",""],
["","24","(DCC 3710)","EF011518",""],
["8{@m2}","Ecuador: Pastaza: Puyo{@m2}","S 1°26\'35\"; W 77°59\'48\"{@m2}","954","25","QCAZ 26210","DQ337230",""],
["","26","QCAZ 26211","EF470258",""],
["","27","QCAZ 28857","EF470259",""],
["9{@m1}","Ecuador: Pastaza: Shell{@m1}","S 1°30\'; W 78°3\'{@m1}","1069","28","QCAZ 25038","EF470260",""],
["","29","QCAZ 25039","EF470261",""],
["10{@m2}","Peru: Loreto: San Jacinto{@m2}","S 2°18\'45\"; W 75°51\'46\"{@m2}","180","30","KUNHM 222069","EF470262",""],
["","31","KUNHM 222070","EF470263",""],
["","32","KUNHM 222071","EF470264",""],
["11{@m3}","Peru: Loreto: Amazon Conservancy for Tropical Studies{@m3}","S 3°15\'34\"; W 72°54\'10\"{@m3}","102","33","MUSM 21546","EF470265",""],
["","34","MUSM 21556","EF470266",""],
["","35","MUSM 21562","EF470267",""],
["","36","MUSM 21564","EF470268",""],
["12","Peru: Madre de Dios: Cusco Amaznico","S 12°35\'; W 69°5\'","200","37","KUNHM 215534","EF470269",""],
["13","Peru: Madre de Dios: Trail between Madre de Dios River and Lago Sandoval","S 12°36\'; W 69°5\'","200","38","KUNHM 215133","EF470270",""],
["14{@m1}","Peru: Madre de Dios: Explorers Inn{@m1}","S 12°50\'18\"; W 69°17\'45\"{@m1}","207","39","USNM 343260","EF011546",""],
["","40","USNM 343264","EF011545",""],
["15{@m3}","Peru: Madre de Dios: Tambopata Research Center{@m3}","S 13°8\'6\"; W 69°36\'23\"{@m3}","167","41","MUSM 19363","EF011550",""],
["","42","MUSM 19368","EF011547",""],
["","43","MUSM 19403","EF011548",""],
["","44","MUSM 19404","EF011549",""],
["16{@m3}","Peru: Madre de Dios: south side of Tambopata River across from Tambopata Research Center{@m3}","S 13°8\'36\"; W 69°35\'51\"{@m3}","201","45","MUSM 19348","EF011551",""],
["","46","MUSM 19380","EF011553",""],
["","47","MUSM 19381","EF011552",""],
["","48","MUSM 19382","EF011554",""],
["17{@m2}","Bolivia: La Paz: Chalaln Ecolodge{@m2}","S 14°25\'29\"; W 67°55\'14\"{@m2}","400","49","MNCN/ADN 2823","EF470271",""],
["","50","MNCN/ADN 2845","EF470272",""],
["","51","MNCN/ADN 2846","EF470273",""],
["18{@m3}","Brazil: Par: Agropecuria Treviso{@m3}","S 3°9\'; W 54°50\'{@m3}","122","52","LSUMZ 18728","EF470274",""],
["","53","LSUMZ 18729","EF470275",""],
["","54","LSUMZ 18730","EF470276",""],
["","55","LSUMZ 18731","EF470277",""],
["19{@m1}","Brazil: Acre: Porto Walter{@m1}","S 8°15\'31\"; W 72°46\'37\"{@m1}","219","56","LSUMZ 13649","EF470278",""],
["","57","LSUMZ 13687","EF470279",""],
["20","Brazil: Acre: Mouth of Tejo River","S 9°3\'; W 72°44\'","260","58","ZUEC 9511","DQ337229",""],
["21","Brazil: Acre: Restauraao","S 9°3\'; W 72°17\'","272","59","ZUEC 9523","EF011544",""],
["22{@m5}","Brazil: Rondnia: Parque Estadual Guajar-Mirim{@m5}","S 10°19\'17\"; W 64°33\'48\"{@m5}","151","60","LSUMZ 17422","EF470280",""],
["","61","LSUMZ 17427","EF470281",""],
["","62","LSUMZ 17459","EF470282",""],
["","63","LSUMZ 17467","EF470283",""],
["","64","LSUMZ 17489","EF470284",""],
["","65","LSUMZ 17523","EF470285",""],
["P. pustulosus","Panama: Panama: Gamboa","-","-","66","(KM91)","DQ337239",""],
["","Mexico: Chiapas: Puerto Madera","-","-","67","(LW1033)","DQ337247",""],
["P. pustulatus","Ecuador: Guayas: Cerro Blanco","-","-","68","QCAZ 23420","DQ337215",""],
["P. coloradorum","Ecuador: Pichincha: La Florida","-","-","69","QCAZ 19418","DQ337222",""]
]
}
');


array_push($tables, '
{
"label":"Table 1",
"caption":"Collection information and GenBank accession numbers for specimens used in this study",
"header":[
["Genus{@m1}","Species{@m1}","Collection location","-","-","-","GenBank Accession Nos.","-","-","-","-","-","-",""],
["Collection number","Latitude (N)","Longitude (W)","Date","cytb","D-loop","cox1","12S rRNA","16S rRNA","ITS1","RAG2","tRNA Thr and Pro"]
],
"rows":[
["Helicolenus","avius","SWFSC 112-37","Tokyo, Japan","-","990116","DQ678505","DQ678608","DQ678402","DQ678196","DQ678299","DQ678711","DQ678807","DQ678910"],
["Hozukius","emblemarius","FAKU 81635","34.05","135.35","NA","DQ678499","DQ678602","DQ678396","DQ678190","DQ678293","DQ678705","DQ678801","DQ678904"],
["Sebastes","aleutianus","SWFSC 4-71","41.23","124.42","950709","DQ678418","DQ678521","DQ678315","DQ678109","DQ678212","DQ678624","DQ678720","DQ678823"],
["","alutus","SWFSC 121-65","55.69","157.47","990604","DQ678416","DQ678519","DQ678313","DQ678107","DQ678210","DQ678622","DQ678718","DQ678821"],
["","atrovirens","SWFSC 166-27","32.83","117.25","020717","DQ678423","DQ678526","DQ678320","DQ678114","DQ678217","DQ678629","DQ678725","DQ678828"],
["","auriculatus","SWFSC 36-82","33.00","117.28","020304","DQ678513","DQ678616","DQ678410","DQ678204","DQ678307","NA","DQ678815","DQ678918"],
["","aurora","SWFSC 42-2","34.91","121.05","980609","DQ678417","DQ678520","DQ678314","DQ678108","DQ678211","DQ678623","DQ678719","DQ678822"],
["","babcocki","SWFSC 179-35","58.63","-151.19","990623","DQ678422","DQ678525","DQ678319","DQ678113","DQ678216","DQ678628","DQ678724","DQ678827"],
["","baramenuke","FAKU 81605","39.48","141.32","NA","DQ678491","DQ678594","DQ678388","DQ678182","DQ678285","DQ678697","DQ678793","DQ678896"],
["","borealis","SIO 01-186","36.44","121.91","010904","DQ678506","DQ678609","DQ678403","DQ678197","DQ678300","DQ678712","DQ678808","DQ678911"],
["","brevispinis","SWFSC 92-4","48.41","126.05","980731","DQ678419","DQ678522","DQ678316","DQ678110","DQ678213","DQ678625","DQ678721","DQ678824"],
["","capensis","SWFSC 10-91","South Africa","-","9601","DQ678420","DQ678523","DQ678317","DQ678111","DQ678214","DQ678626","DQ678722","DQ678825"],
["","carnatus","SWFSC 147-86","31.42","116.67","001029","DQ678424","DQ678527","DQ678321","DQ678115","DQ678218","DQ678630","DQ678726","DQ678829"],
["","caurinus","SWFSC 124-4","43.13","124.45","990830","DQ678425","DQ678528","DQ678322","DQ678116","DQ678219","DQ678631","DQ678727","DQ678830"],
["","chlorostictus","SWFSC 156-89","32.85","117.30","0205","DQ678435","DQ678538","DQ678332","DQ678126","DQ678229","DQ678641","DQ678737","DQ678840"],
["","chrysomelas","SWFSC 163-11","33.22","119.50","010328","DQ678426","DQ678529","DQ678323","DQ678117","DQ678220","DQ678632","DQ678728","DQ678831"],
["","ciliatus","UW 043242-#27","53.73","165.54","960525","DQ678515","DQ678618","DQ678412","DQ678206","DQ678309","NA","DQ678817","DQ678920"],
["","constellatus","SWFSC 153-81","30.33","116.08","001027","DQ678436","DQ678539","DQ678333","DQ678127","DQ678230","DQ678642","DQ678738","DQ678841"],
["","cortezi","SWFSC 225-76","28.98","113.43","050408","DQ678497","DQ678600","DQ678394","DQ678188","DQ678291","DQ678703","DQ678799","DQ678902"],
["","crameri","SWFSC 134-40","36.78","122.12","920111","DQ678437","DQ678540","DQ678334","DQ678128","DQ678231","DQ678643","DQ678739","DQ678842"],
["","dalli","SWFSC 114-21","34.05","119.00","990227","DQ678427","DQ678530","DQ678324","DQ678118","DQ678221","DQ678633","DQ678729","DQ678832"],
["","diploproa","SWFSC 143-51","36.79","122.13","920112","DQ678438","DQ678541","DQ678335","DQ678129","DQ678232","DQ678644","DQ678740","DQ678843"],
["","elongatus","SWFSC 89-67","48.24","125.17","980730","DQ678434","DQ678537","DQ678331","DQ678125","DQ678228","DQ678640","DQ678736","DQ678839"],
["","emphaeus","SWFSC 7-84","47.92","122.58","950413","DQ678439","DQ678542","DQ678336","DQ678130","DQ678233","DQ678645","DQ678741","DQ678844"],
["","ensifer","UW 2003-016","32.61","117.31","50817","DQ678440","DQ678543","DQ678337","DQ678131","DQ678234","DQ678646","DQ678742","DQ678845"],
["","entomelas","SWFSC 3-50","37.24","122.72","950626","DQ678441","DQ678544","DQ678338","DQ678132","DQ678235","DQ678647","DQ678743","DQ678846"],
["","eos","SWFSC 176-11","32.80","117.80","020303","DQ678442","DQ678545","DQ678339","DQ678133","DQ678236","DQ678648","DQ678744","DQ678847"],
["","exsul","SWFSC 144-75","28.98","113.43","950327","DQ678443","DQ678546","DQ678340","DQ678134","DQ678237","DQ678649","DQ678745","DQ678848"],
["","fasciatus","SWFSC 14-29","North Atlantic","-","980213","DQ678444","DQ678547","DQ678341","DQ678135","DQ678238","DQ678650","DQ678746","DQ678849"],
["","flammeus","FAKU 81606","39.48","141.32","NA","DQ678486","DQ678589","DQ678383","DQ678177","DQ678280","DQ678692","DQ678788","DQ678891"],
["","flavidus","SWFSC 20-72","36.91","122.18","980615","DQ678445","DQ678548","DQ678342","DQ678136","DQ678239","DQ678651","DQ678747","DQ678850"],
["","gilli","SWFSC 129-60","32.75","117.75","000405","DQ678446","DQ678549","DQ678343","DQ678137","DQ678240","DQ678652","DQ678748","DQ678851"],
["","glaucus","FAKU 82532","43","144.38","NA","DQ678488","DQ678591","DQ678385","DQ678179","DQ678282","DQ678694","DQ678790","DQ678893"],
["","goodei","SWFSC 155-75","32.60","117.42","020331","DQ678461","DQ678564","DQ678358","DQ678152","DQ678255","DQ678667","DQ678763","DQ678866"],
["","helvomaculatus","SWFSC 128-68","32.87","117.87","000318","DQ678496","DQ678599","DQ678393","DQ678187","DQ678290","DQ678702","DQ678798","DQ678901"],
["","hopkinsi","SWFSC 156-91","32.85","117.30","0205","DQ678447","DQ678550","DQ678344","DQ678138","DQ678241","DQ678653","DQ678749","DQ678852"],
["","hubbsi","FAKU 130191","NA","NA","NA","DQ678501","DQ678604","DQ678398","DQ678192","DQ678295","DQ678707","DQ678803","DQ678906"],
["","inermis","FAKU 86581","NA","NA","NA","DQ678483","DQ678586","DQ678380","DQ678174","DQ678277","DQ678689","DQ678785","DQ678888"],
["","iracundus","FAKU 81604","39.48","141.32","NA","DQ678495","DQ678598","DQ678392","DQ678186","DQ678289","DQ678701","DQ678797","DQ678900"],
["","jordani","SWFSC 110-84","58.90","122.58","930223","DQ678448","DQ678551","DQ678345","DQ678139","DQ678242","DQ678654","DQ678750","DQ678853"],
["","joyneri","FAKU 130109","NA","NA","NA","DQ678489","DQ678592","DQ678386","DQ678180","DQ678283","DQ678695","DQ678791","DQ678894"],
["","kiyomatsui","FAKU 81567","34.05","135.35","NA","DQ678487","DQ678590","DQ678384","DQ678178","DQ678281","DQ678693","DQ678789","DQ678892"],
["","lentiginosus","SWFSC 8-89","29.16","118.27","960808","DQ678449","DQ678552","DQ678346","DQ678140","DQ678243","DQ678655","DQ678751","DQ678854"],
["","levis","SWFSC 164-66","32.66","117.97","030115","DQ678450","DQ678553","DQ678347","DQ678141","DQ678244","DQ678656","DQ678752","DQ678855"],
["","macdonaldi","SWFSC 36-91","32.60","117.42","020312","DQ678451","DQ678554","DQ678348","DQ678142","DQ678245","DQ678657","DQ678753","DQ678856"],
["","maliger","SWFSC 26-74","49.08","126.20","980806","DQ678428","DQ678531","DQ678325","DQ678119","DQ678222","DQ678634","DQ678730","DQ678833"],
["","matsubarae","FAKU 81639","34.05","135.35","NA","DQ678498","DQ678601","DQ678395","DQ678189","DQ678292","DQ678704","DQ678800","DQ678903"],
["","melanops","SWFSC 37-50","35.65","121.52","981114","DQ678453","DQ678556","DQ678350","DQ678144","DQ678247","DQ678659","DQ678755","DQ678858"],
["","melanosema","UW 112698","32.92","117.53","040221","DQ678514","DQ678617","DQ678411","DQ678205","DQ678308","NA","DQ678816","DQ678919"],
["","melanostictus","SWFSC 7-92","36.28","121.97","950802","DQ678414","DQ678517","DQ678311","DQ678105","DQ678208","DQ678620","DQ678716","DQ678819"],
["","melanostomus","SWFSC 129-66","32.75","117.75","000405","DQ678454","DQ678557","DQ678351","DQ678145","DQ678248","DQ678660","DQ678756","DQ678859"],
["","mentella","SWFSC 12-36","69.67","18.93","950626","DQ678455","DQ678558","DQ678352","DQ678146","DQ678249","DQ678661","DQ678757","DQ678860"],
["","miniatus type 1","SWFSC 156-86","32.83","117.25","020527","DQ678456","DQ678559","DQ678353","DQ678147","DQ678250","DQ678662","DQ678758","DQ678861"],
["","miniatus type 2","SWFSC 159-72","32.83","117.25","020527","DQ678457","DQ678560","DQ678354","DQ678148","DQ678251","DQ678663","DQ678759","DQ678862"],
["","minor","FAKU 83713","44","145","NA","DQ678502","DQ678605","DQ678399","DQ678193","DQ678296","DQ678708","DQ678804","DQ678907"],
["","moseri","SIO 95-33","32.63","117.96","950901","DQ678509","DQ678612","DQ678406","DQ678200","DQ678303","DQ678715","DQ678811","DQ678914"],
["","mystinus","SWFSC 118-37","34.01","119.39","990703","DQ678458","DQ678561","DQ678355","DQ678149","DQ678252","DQ678664","DQ678760","DQ678863"],
["","nebulosus","SWFSC 151-60","45.85","124.00","000616","DQ678429","DQ678532","DQ678326","DQ678120","DQ678223","DQ678635","DQ678731","DQ678834"],
["","nigrocinctus","SWFSC 7-71","56.33","136.00","960105","DQ678459","DQ678562","DQ678356","DQ678150","DQ678253","DQ678665","DQ678761","DQ678864"],
["","norvegicus","SWFSC 12-24","69.67","18.93","940712","DQ678452","DQ678555","DQ678349","DQ678143","DQ678246","DQ678658","DQ678754","DQ678857"],
["","notius","SWFSC 8-91","25.59","113.37","960814","DQ678460","DQ678563","DQ678357","DQ678151","DQ678254","DQ678666","DQ678762","DQ678865"],
["","oblongus","FAKU 130128","NA","NA","NA","DQ678503","DQ678606","DQ678400","DQ678194","DQ678297","DQ678709","DQ678805","DQ678908"],
["","oculatus","SWFSC 10-78","N35.5","32.59","","DQ678421","DQ678524","DQ678318","DQ678112","DQ678215","DQ678627","DQ678723","DQ678826"],
["","ovalis","SWFSC 161-60","33.03","118.56","010326","DQ678431","DQ678534","DQ678328","DQ678122","DQ678225","DQ678637","DQ678733","DQ678836"],
["","owstoni","FAKU 83264","SW Sea of Japan","-","NA","DQ678493","DQ678596","DQ678390","DQ678184","DQ678287","DQ678699","DQ678795","DQ678898"],
["","pachycephalus","FAKU 130088","NA","NA","NA","DQ678490","DQ678593","DQ678387","DQ678181","DQ678284","DQ678696","DQ678792","DQ678895"],
["","paucispinis","SWFSC 153-79","30.33","116.08","001027","DQ678462","DQ678565","DQ678359","DQ678153","DQ678256","DQ678668","DQ678764","DQ678867"],
["","peduncularis","SWFSC 225-68","28.98","113.43","050408","DQ678504","DQ678607","DQ678401","DQ678195","DQ678298","DQ678710","DQ678806","DQ678909"],
["","phillipsi","SWFSC 128-62","32.87","117.87","000318","DQ678463","DQ678566","DQ678360","DQ678154","DQ678257","DQ678669","DQ678765","DQ678868"],
["","pinniger","SWFSC 76-19","45.74","124.20","980716","DQ678464","DQ678567","DQ678361","DQ678155","DQ678258","DQ678670","DQ678766","DQ678869"],
["","polyspinis","SWFSC 121-69","58.40","-153.65","990620","DQ678512","DQ678615","DQ678409","DQ678203","DQ678306","NA","DQ678814","DQ678917"],
["","proriger","SWFSC 89-65","48.24","125.17","980730","DQ678465","DQ678568","DQ678362","DQ678156","DQ678259","DQ678671","DQ678767","DQ678870"],
["","rastrelliger","NA","32.85","117.32","0101","DQ678430","DQ678533","DQ678327","DQ678121","DQ678224","DQ678636","DQ678732","DQ678835"],
["","reedi","SWFSC 74-11","45.08","124.71","980712","DQ678415","DQ678518","DQ678312","DQ678106","DQ678209","DQ678621","DQ678717","DQ678820"],
["","rosaceus","SWFSC 163-20","33.22","119.50","010328","DQ678466","DQ678569","DQ678363","DQ678157","DQ678260","DQ678672","DQ678768","DQ678871"],
["","rosenblatti","SWFSC 146-85","32.45","119.15","940526","DQ678467","DQ678570","DQ678364","DQ678158","DQ678261","DQ678673","DQ678769","DQ678872"],
["","ruberrimus","SWFSC 132-12","45.74","124.61","980715","DQ678468","DQ678571","DQ678365","DQ678159","DQ678262","DQ678674","DQ678770","DQ678873"],
["","rubrivinctus","SWFSC 126-77","32.85","117.32","990416","DQ678469","DQ678572","DQ678366","DQ678160","DQ678263","DQ678675","DQ678771","DQ678874"],
["","rufinanus","SWFSC LT22","32.42","119.96","9904","DQ678508","DQ678611","DQ678405","DQ678199","DQ678302","DQ678714","DQ678810","DQ678913"],
["","rufus","SWFSC 176-33","32.80","117.80","020303","DQ678470","DQ678573","DQ678367","DQ678161","DQ678264","DQ678676","DQ678772","DQ678875"],
["","saxicola type N","SWFSC 128-83","36.83","122.16","921120","DQ678433","DQ678536","DQ678330","DQ678124","DQ678227","DQ678639","DQ678735","DQ678838"],
["","saxicola type S","SWFSC 181-43","32.67","117.33","0210","DQ678432","DQ678535","DQ678329","DQ678123","DQ678226","DQ678638","DQ678734","DQ678837"],
["","schlegeli","FAKU 130219","NA","NA","NA","DQ678481","DQ678584","DQ678378","DQ678172","DQ678275","DQ678687","DQ678783","DQ678886"],
["","scythropus","FAKU 81566","34.05","135.35","NA","DQ678485","DQ678588","DQ678382","DQ678176","DQ678279","DQ678691","DQ678787","DQ678890"],
["","semicinctus","SWFSC 155-99","32.67","117.31","020525","DQ678471","DQ678574","DQ678368","DQ678162","DQ678265","DQ678677","DQ678773","DQ678876"],
["","serranoides","SWFSC 147-84","32.67","117.25","001015","DQ678472","DQ678575","DQ678369","DQ678163","DQ678266","DQ678678","DQ678774","DQ678877"],
["","serriceps","SWFSC 153-60","30.37","116.08","001027","DQ678473","DQ678576","DQ678370","DQ678164","DQ678267","DQ678679","DQ678775","DQ678878"],
["","simulator","SWFSC 187-15","32.61","117.31","050123","DQ678507","DQ678610","DQ678404","DQ678198","DQ678301","DQ678713","DQ678809","DQ678912"],
["","sinensis","SWFSC 225-80","28.98","113.43","050408","DQ678511","DQ678614","DQ678408","DQ678202","DQ678305","NA","DQ678813","DQ678916"],
["","spinorbis","SWFSC 144-68","28.98","113.43","950328","DQ678474","DQ678577","DQ678371","DQ678165","DQ678268","DQ678680","DQ678776","DQ678879"],
["","steindachneri","FAKU 83715","44","145","NA","DQ678484","DQ678587","DQ678381","DQ678175","DQ678278","DQ678690","DQ678786","DQ678889"],
["","taczanowskii","SWFSC 14-57","41.77","140.72","960721","DQ678494","DQ678597","DQ678391","DQ678185","DQ678288","DQ678700","DQ678796","DQ678899"],
["","thompsoni","FAKU 130111","NA","NA","NA","DQ678482","DQ678585","DQ678379","DQ678173","DQ678276","DQ678688","DQ678784","DQ678887"],
["","trivittatus","SWFSC 126-75","39.64","141.95","9904","DQ678492","DQ678595","DQ678389","DQ678183","DQ678286","DQ678698","DQ678794","DQ678897"],
["","umbrosus","SWFSC 153-62","30.37","116.08","001027","DQ678475","DQ678578","DQ678372","DQ678166","DQ678269","DQ678681","DQ678777","DQ678880"],
["","variabilis","UW 043203-#40","54.11","161.73","960601","DQ678510","DQ678613","DQ678407","DQ678201","DQ678304","NA","DQ678812","DQ678915"],
["","variegatus","SWFSC 178-3","43.38","124.55","950315","DQ678476","DQ678579","DQ678373","DQ678167","DQ678270","DQ678682","DQ678778","DQ678881"],
["","viviparus","SWFSC 35-88","Iceland","-","991020","DQ678477","DQ678580","DQ678374","DQ678168","DQ678271","DQ678683","DQ678779","DQ678882"],
["","vulpes","FAKU 130099","NA","NA","NA","DQ678478","DQ678581","DQ678375","DQ678169","DQ678272","DQ678684","DQ678780","DQ678883"],
["","wilsoni","SWFSC 174-76","55.4","134.44","9901","DQ678479","DQ678582","DQ678376","DQ678170","DQ678273","DQ678685","DQ678781","DQ678884"],
["","zacentrus","SWFSC 20-99","37.24","122.83","980616","DQ678480","DQ678583","DQ678377","DQ678171","DQ678274","DQ678686","DQ678782","DQ678885"],
["Sebastiscus","marmoratus","SWFSC 112-51","Tokyo, Japan","-","990116","DQ678516","DQ678619","DQ678413","DQ678207","DQ678310","NA","DQ678818","DQ678921"],
["Sebastolobus","alascanus","SWFSC IIF10","33.03","117.37","9003","DQ678500","DQ678603","DQ678397","DQ678191","DQ678294","DQ678706","DQ678802","DQ678905"]
]
}
');

*/



foreach ($tables as $t)
{
	$j = json_decode($t);
	$h = new TableHeader($j); // $j is a table
	
	// Classify column headings
	$h->ClassifyColumns();
	
	// Check classification based on looking at the column data
	$h->CheckColumnClassification();

	// Dump	
	//$h->Dump();
		
	// Extract actual data...
	
	//print_r($h->row_parent);
	//exit();
	
	$item = array();
	for ($i = 0; $i < count($h->rows); $i++)
	{
		$j = $h->row_parent[$i];
		if ($j == $i)
		{
			$item[$j] = new stdClass;
			$item[$j]->accessions = array();
			$item[$j]->voucher = array();
		}
	
		$column_counter = 0;
		foreach ($h->rows[$i] as $c)
		{
			//echo "$i $j $c\n";
			if ($h->column_types[$column_counter] == TYPE_GENBANK)
			{
				if (IsAccessionNumber($c))
				{
					// may have > 1 on a list
					$acc = list_to_array($c);
					foreach ($acc as $a)
					{
						// Clean up
						$a = preg_replace('/([0-9])[a-z]$/', "${1}", $a);
						array_push($item[$j]->accessions, $a);
					}
					
				}
			}

			if ($h->column_types[$column_counter] == TYPE_LOCALITY)
			{
				// clean
				$c = preg_replace('/\(\d+\)\s*/', '', $c);
				$c = preg_replace('/^\-$/', '', $c);

				if ($c != '')
				{
					$item[$j]->locality =  $c;
				}
			}
			
			if	($h->column_types[$column_counter] == TYPE_LATITUDE_LONGITUDE)
			{
				$loc = array();
				if (IsLatLong($c, $loc))
				{
					$item[$j]->latitude = $loc['latitude'];
					$item[$j]->longitude = $loc['longitude'];
				}
			}
			
			if	($h->column_types[$column_counter] == TYPE_ALTERNATING_LATITUDE_LONGITUDE)
			{
				if (IsLatitude($c, $latitude))
				{
					$item[$j]->latitude = $latitude;
				}
			}

			if	($h->column_types[$column_counter] == TYPE_ALTERNATING_LATITUDE_LONGITUDE)
			{
				if (IsLongitude($c, $longitude))
				{
					$item[$j]->longitude = $longitude;
				}
			}
			
	
			if	($h->column_types[$column_counter] == TYPE_LATITUDE)
			{
				if (IsLatitude($c, $latitude))
				{
					$item[$j]->latitude = $latitude;
				}
				else if (is_numeric($c))
				{
					$item[$j]->latitude = $c * $h->column_multipliers[$column_counter];
				}
			}
	
			if	($h->column_types[$column_counter] == TYPE_LONGITUDE)
			{
				if (IsLongitude($c, $longitude))
				{
					$item[$j]->longitude = $longitude;
				}
				else if (is_numeric($c))
				{
					$item[$j]->longitude = $c  * $h->column_multipliers[$column_counter];
				}
			}
	
			if	($h->column_types[$column_counter] == TYPE_VOUCHER)
			{
				$voucher = list_to_array($c);
				foreach ($voucher as $v)
				{
					// Clean up
					array_push($item[$j]->voucher, $v);
				}
			}
			
			$column_counter++;
		}
	}
	
	print_r($item);
	
	// KML
	if (0)
	{
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
		
		foreach ($item as $i)
		{
			if (isset($i->latitude))
			{
	
				echo '	<Placemark>
					<styleUrl>#normalPlacemark</styleUrl>
					<name>' . 'x'  . '</name>
					<description>
					</description>
					<Point>
						<extrude>0</extrude>
						<altitudeMode>absolute</altitudeMode>
						<coordinates>';
						echo $i->longitude, ',';
						echo $i->latitude;
						echo ',0</coordinates> ', "\n";
				echo '		</Point>
				</Placemark>';
				echo "\n";
			}
			
		}
		echo "</Document>\n
	</kml>\n";	
	}
}



?>

