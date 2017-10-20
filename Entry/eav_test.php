<?php

require_once('eav/eav.php');
require_once('class_object.php');
require_once('class_reference.php');


// eav test

db_object_insert(
	md5('rdmpage@gmail.com'),
	1,
	'rdmpage',
	'',
	md5('rdmpage@gmail.com'),
	'127.0.0.1',
	'Root user');

/*db_object_insert(
	md5('doi:10.1016/j.ympev.2006.06.014'),
	1,
	'example',
	'',
	md5('rdmpage@gmail.com'),
	'127.0.0.1',
	'test insertion');

db_store_object_guid(
md5('doi:10.1016/j.ympev.2006.06.014'),
'doi',
'10.1016/j.ympev.2006.06.014',
md5('rdmpage@gmail.com'),
	'127.0.0.1',
	'test insertion');

db_update_attribute_value (
md5('doi:10.1016/j.ympev.2006.06.014'),
'EAV_Date',
3,
'1999-10-02');

db_update_attribute_value (
md5('doi:10.1016/j.ympev.2006.06.014'),
'EAV_String',
5,
'Hello boys');*/

$j = '{
  "atitle": "Phylogenetic relationships within an endemic group of Malagasy \u2018assassin spiders\u2019 (Araneae, Archaeidae): ancestral character reconstruction, convergent evolution and biogeography",
  "issn": "1055-7903",
  "volume": "45",
  "spage": "612",
  "epage": "619",
  "doi": "10.1016\/j.ympev.2007.07.012",
  "year": "2007",
  "date": "2007-11-00",
  "created": "2008-09-04 13:34:15",
  "title": "Molecular Phylogenetics and Evolution",
  "pmid": "17869131",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "authors": [
    {
      "lastname": "Wood",
      "forename": "H"
    },
    {
      "lastname": "Griswold",
      "forename": "C "
    },
    {
      "lastname": "Spicer",
      "forename": "G"
    }
  ]
}';

$j = '{
  "atitle": "A review of the archaeid spiders and their relatives, with notes on the limits of the superfamily Palpimanoidea (Arachnida, Araneae).",
  "issn": "0003-0090",
  "volume": "178",
  "spage": "1",
  "hdl": "2246\/991",
  "year": "1984",
  "abstract": "A comparative morphological survey of the archaeid spiders and their relatives is presented; cladistic analysis of the results supports the following taxonomic changes. The family Archaeidae Koch and Berendt is relimited to include only four genera: Archaea Koch and Berendt (containing six Baltic amber species and six Recent species from Madagascar), and the new genera Austrarchaea (type species Archaea nodosa Forster from Queensland; also including Archaea hickmani Butler from Victoria and a new species from Queensland), Afrarchaea (type species Archaea godfreyi Hewitt from South Africa and Madagascar), and Eoarchaea (type species Archaea hyperoptica Menge from Baltic amber). Other taxa previously placed in the Archaeidae are assigned to the family Mecysmaucheniidae Simon and the new families Pararchaeidae (for Pararchaea Forster, including seven species from New Zealand, Australia, and Tasmania) and Holarchacidae (for Holarchaea Forster, including H. novaeseelandiae Forster from New Zealand and Zearchaea globosa Hickman from Tasmania). The Mecysmaucheniidae is divided into two subfamilies. The Mecysmaucheniinae contains Mecysmauchenius Simon (type species M. segmentatus Simon from southern Chile, adjacent Argentina, and the Falkland Islands; also including M. gertschi Zapfe from central Chile and 14 new species from Chile and the Juan Fernandez Islands) and the new genera Mecysmauchenioides (type species Mecysmauchenius nordenskjoldi Tullgren from Chile), Semysmauchenius (type species S. antillanca, new species, from Chile), Mesarchaea (type species M. bellavista, new species, from Chile), and Aotearoa (type species Zearchaea magna Forster from New Zealand). The new subfamily Zearchaeinae contains Zearchaea Wilton (type species Z. clypeata Wilton from New Zealand; also including Z. fiordensis Forster from New Zealand) and the new genus Chilarchaea (type species C. quellon, new species, from Chile). Recent hypotheses by Lehtinen and Levi assigning these taxa to two different superfamilies are rejected. The four families are judged instead to constitute a monophyletic group with its closest relatives among the superfamily Palpimanoidea, which is expanded to include them as well as (in suggested sister-group sequence) the Textricellidae and Micropholcommatidae, the traditional palpimanoids (Huttoniidae, Stenochilidae, and Palpimanidae), and the Mimetidae.",
  "created": "2008-09-04 11:29:43",
  "title": "Bulletin of the American Museum of Natural History",
  "open_access": "Y",
  "modified": "2100-00-00 00:00:00",
  "publisher_id": "oai:digitallibrary.amnh.org:2246\/991",
  "authors": [
    {
      "lastname": "Forster",
      "forename": "Raymond R"
    },
    {
      "lastname": "Platnick",
      "forename": "Norman I"
    }
  ]
}';

$j = '{
  "atitle": "Extensive mtDNA variation within the yellow-pine chipmunk, Tamias amoenus (Rodentia: Sciuridae), and phylogeographic inferences for northwest North America",
  "issn": "1055-7903",
  "volume": "26",
  "spage": "389",
  "epage": "408",
  "doi": "10.1016\/S1055-7903(02)00363-9",
  "year": "2003",
  "date": "2003-03-00",
  "created": "2008-09-23 19:06:13",
  "title": "Molecular Phylogenetics and Evolution",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "genre": "article",
  "authors": [
    {
      "lastname": "Demboski",
      "forename": "J"
    }
  ],
  "status": "ok"
}';

$j = '{
  "atitle": "Molecular evidence for the monophyly of East Asian groups of Cyprinidae (Teleostei: Cypriniformes) derived from the nuclear recombination activating gene 2 sequences",
  "issn": "1055-7903",
  "volume": "42",
  "spage": "157",
  "epage": "170",
  "doi": "10.1016\/j.ympev.2006.06.014",
  "year": "2007",
  "date": "2007-01-00",
  "created": "2008-09-17 15:16:00",
  "title": "Molecular Phylogenetics and Evolution",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "genre": "article",
  "authors": [
    {
      "lastname": "Wang",
      "forename": "X"
    },
    {
      "lastname": "Li",
      "forename": "J"
    },
    {
      "lastname": "He",
      "forename": "S"
    }
  ],
  "status": "ok"
}';

$j = '{
  "atitle": "A Simulation Study of Reduced Tree-Search Effort in Bootstrap Resampling Analysis",
  "issn": "1063-5157",
  "volume": "49",
  "spage": "171",
  "epage": "179",
  "doi": "10.1080\/10635150050207465",
  "year": "2000",
  "date": "2000-01-01",
  "created": "2008-09-19 19:16:40",
  "title": "Systematic Biology",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "eissn": "1076-836X",
  "genre": "article",
  "authors": [
    {
      "lastname": "W. Debry, Richard G. Olmstead",
      "forename": "Ronald"
    }
  ],
  "status": "ok"
}';

$j = '{
  "atitle": "Phylogenies from Molecular Sequences: Inference and Reliability",
  "issn": "0066-4197",
  "volume": "22",
  "spage": "521",
  "epage": "565",
  "doi": "10.1146\/annurev.ge.22.120188.002513",
  "year": "1988",
  "date": "1988-12-00",
  "created": "2008-09-19 14:21:07",
  "title": "Annual Review of Genetics",
  "pmid": "3071258",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "eissn": "1545-2948",
  "genre": "article",
  "authors": [
    {
      "lastname": "Felsenstein",
      "forename": "J"
    }
  ],
  "status": "ok"
}';

$j = '
{
  "atitle": "Mendesellinae, a new subfamily of braconid wasps (Hymenoptera, Braconidae) with a review of relationships within the microgastroid assemblage",
  "issn": "0307-6970",
  "volume": "19",
  "spage": "61",
  "epage": "76",
  "doi": "10.1111\/j.1365-3113.1994.tb00579.x",
  "year": "1994",
  "date": "1994-01-00",
  "created": "2008-09-23 14:41:37",
  "title": "Systematic Entomology",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "eissn": "1365-3113",
  "genre": "article",
  "authors": [
    {
      "lastname": "Whitfield",
      "forename": "J B"
    },
    {
      "lastname": "Mason",
      "forename": "W R M"
    }
  ],
  "status": "ok"
}';

$j='
{
  "atitle": "The amphibian tree of life.",
  "issn": "0003-0090",
  "volume": "297",
  "spage": "1",
  "doi": "10.1206\/0003-0090(2006)297[0001:TATOL]2.0.CO;2",
  "hdl": "2246\/5781",
  "year": "2006",
  "abstract": "The evidentiary basis of the currently accepted classification of living amphibians is discussed and shown not to warrant the degree of authority conferred on it by use and tradition. A new taxonomy of living amphibians is proposed to correct the deficiencies of the old one. This new taxonomy is based on the largest phylogenetic analysis of living Amphibia so far accomplished. We combined the comparative anatomical character evidence of Haas (2003) with DNA sequences from the mitochondrial transcription unit H1 (12S and 16S ribosomal RNA and tRNA[superscript Valine] genes, [approximately equal to] 2,400 bp of mitochondrial sequences) and the nuclear genes histone H3, rhodopsin, tyrosinase, and seven in absentia, and the large ribosomal subunit 28S ([approximately equal to] 2,300 bp of nuclear sequences; ca. 1.8 million base pairs; x [arithmetic mean] = 3.7 kb\/terminal). The dataset includes 532 terminals sampled from 522 species representative of the global diversity of amphibians as well as seven of the closest living relatives of amphibians for outgroup comparisons. The primary purpose of our taxon sampling strategy was to provide strong tests of the monophyly of all \'family-group\' taxa. All currently recognized nominal families and subfamilies were sampled, with the exception of Protohynobiinae (Hynobiidae). Many of the currently recognized genera were also sampled. Although we discuss the monophyly of genera, and provide remedies for nonmonophyly where possible, we also make recommendations for future research. A parsimony analysis was performed under Direct Optimization, which simultaneously optimizes nucleotide homology (alignment) and tree costs, using the same set of assumptions throughout the analysis. Multiple search algorithms were run in the program POY over a period of seven months of computing time on the AMNH Parallel Computing Cluster. Results demonstrate that the following major taxonomic groups, as currently recognized, are nonmonophyletic: Ichthyophiidae (paraphyletic with respect to Uraeotyphlidae), Caeciliidae (paraphyletic with respect to Typhlonectidae and Scolecomorphidae), Salamandroidea (paraphyletic with respect to Sirenidae), Leiopelmatanura (paraphyletic with respect to Ascaphidae), Discoglossanura (paraphyletic with respect to Bombinatoridae), Mesobatrachia (paraphyletic with respect to Neobatrachia), Pipanura (paraphyletic with respect to Bombinatoridae and Discoglossidae\/Alytidae), Hyloidea (in the sense of containing Heleophrynidae; paraphyletic with respect to Ranoidea), Leptodactylidae (polyphyletic, with Batrachophrynidae forming the sister taxon of Myobatrachidae + Limnodynastidae, and broadly paraphyletic with respect to Hemiphractinae, Rhinodermatidae, Hylidae, Allophrynidae, Centrolenidae, Brachycephalidae, Dendrobatidae, and Bufonidae), Microhylidae (polyphyletic, with Brevicipitinae being the sister taxon of Hemisotidae), Microhylinae (poly\/paraphyletic with respect to the remaining non-brevicipitine microhylids), Hyperoliidae (para\/polyphyletic, with Leptopelinae forming the sister taxon of Arthroleptidae + Astylosternidae), Astylosternidae (paraphyletic with respect to Arthroleptinae), Ranidae (paraphyletic with respect to Rhacophoridae and Mantellidae). In addition, many subsidiary taxa are demonstrated to be nonmonophyletic, such as (1) Eleutherodactylus with respect to Brachycephalus; (2) Rana (sensu Dubois, 1992), which is polyphyletic, with various elements falling far from each other on the tree; and (3) Bufo, with respect to several nominal bufonid genera. A new taxonomy of living amphibians is proposed, and the evidence for this is presented to promote further investigation and data acquisition bearing on the evolutionary history of amphibians. The taxonomy provided is consistent with the International Code of Zoological Nomenclature (ICZN, 1999). Salient features of the new taxonomy are (1) the three major groups of living amphibians, caecilians\/Gymnophiona, salamanders\/Caudata, and frogs\/Anura, form a monophyletic group, to which we restrict the name Amphibia; (2) Gymnophiona forms the sister taxon of Batrachia (salamanders + frogs) and is composed of two groups, Rhinatrematidae and Stegokrotaphia; (3) Stegokrotaphia is composed of two families, Ichthyophiidae (including Uraeotyphlidae) and Caeciliidae (including Scolecomorphidae and Typhlonectidae, which are regarded as subfamilies); (4) Batrachia is a highly corroborated monophyletic group, composed of two taxa, Caudata (salamanders) and Anura (frogs); (5) Caudata is composed of two taxa, Cryptobranchoidei (Cryptobranchidae and Hynobiidae) and Diadectosalamandroidei new taxon (all other salamanders); (6) Diadectosalamandroidei is composed of two taxa, Hydatinosalamandroidei new taxon (composed of Perennibranchia and Treptobranchia new taxon) and Plethosalamandroidei new taxon; (7) Perennibranchia is composed of Proteidae and Sirenidae; (8) Treptobranchia new taxon is composed of two taxa, Ambystomatidae (including Dicamptodontidae) and Salamandridae; (9) Plethosalamandroidei new taxon is composed of Rhyacotritonidae and Xenosalamandroidei new taxon; (10) Xenosalamandroidei is composed of Plethodontidae and Amphiumidae; (11) Anura is monophyletic and composed of two clades, Leiopelmatidae (including Ascaphidae) and Lalagobatrachia new taxon (all other frogs); (12) Lalagobatrachia is composed of two clades, Xenoanura (Pipidae and Rhinophrynidae) and Sokolanura new taxon (all other lalagobatrachians); (13) Bombinatoridae and Alytidae (former Discoglossidae) are each others\' closest relatives and in a clade called Costata, which, excluding Leiopelmatidae and Xenoanura, forms the sister taxon of all other frogs, Acosmanura; (14) Acosmanura is composed of two clades, Anomocoela (5 Pelobatoidea of other authors) and Neobatrachia; (15) Anomocoela contains Pelobatoidea (Pelobatidae and Megophryidae) and Pelodytoidea (Pelodytidae and Scaphiopodidae), and forms the sister taxon of Neobatrachia, together forming Acosmanura; (16) Neobatrachia is composed of two clades, Heleophrynidae, and all other neobatrachians, Phthanobatrachia new taxon; (17) Phthanobatrachia is composed of two major units, Hyloides and Ranoides; (18) Hyloides comprises Sooglossidae (including Nasikabatrachidae) and Notogaeanura new taxon (the remaining hyloids); (19) Notogaeanura contains two taxa, Australobatrachia new taxon and Nobleobatrachia new taxon; (20) Australobatrachia is a clade composed of Batrachophrynidae and its sister taxon, Myobatrachoidea (Myobatrachidae and Limnodynastidae), which forms the sister taxon of all other hyloids, excluding sooglossids; (21) Nobleobatrachia new taxon, is dominated at its base by frogs of a treefrog morphotype, several with intercalary phalangeal cartilages--Hemiphractus (Hemiphractidae) forms the sister taxon of the remaining members of this group, here termed Meridianura new taxon; (22) Meridianura comprises Brachycephalidae (former Eleutherodactylinae + Brachycephalus) and Cladophrynia new taxon; (23) Cladophrynia is composed of two groups, Cryptobatrachidae (composed of Cryptobatrachus and Stefania, previously a fragment of the polyphyletic Hemiphractinae) and Tinctanura new taxon; (24) Tinctanura is composed of Amphignathodontidae (Gastrotheca and Flectonotus, another fragment of the polyphyletic Hemiphractinae) and Athesphatanura new taxon; (25) Athesphatanura is composed of Hylidae (Hylinae, Pelodryadinae, and Phyllomedusinae, and excluding former Hemiphractinae, whose inclusion would have rendered this taxon polyphyletic) and Leptodactyliformes new taxon;",
  "created": "2008-09-17 15:16:00",
  "title": "Bulletin of the American Museum of Natural History",
  "open_access": "Y",
  "modified": "2100-00-00 00:00:00",
  "publisher_id": "oai:digitallibrary.amnh.org:2246\/5781",
  "genre": "article",
  "authors": [
    {
      "lastname": "Frost",
      "forename": "Darrel R"
    },
    {
      "lastname": "Grant",
      "forename": "Taran"
    },
    {
      "lastname": "Faivovich",
      "forename": "Juli\u00e1n"
    },
    {
      "lastname": "Bain",
      "forename": "Raoul H"
    },
    {
      "lastname": "Haas",
      "forename": "Alexander"
    },
    {
      "lastname": "Haddad",
      "forename": "Celio F B"
    },
    {
      "lastname": "De Sa",
      "forename": "Rafael O"
    },
    {
      "lastname": "Channing",
      "forename": "A"
    },
    {
      "lastname": "Wilkinson",
      "forename": "Mark"
    },
    {
      "lastname": "Donnellan",
      "forename": "Stephen C"
    },
    {
      "lastname": "Raxworthy",
      "forename": "Christopher J"
    },
    {
      "lastname": "Campbell",
      "forename": "Jonathan A"
    },
    {
      "lastname": "Blotto",
      "forename": "Boris L"
    },
    {
      "lastname": "Moler",
      "forename": "Paul"
    },
    {
      "lastname": "Drewes",
      "forename": "Robert C"
    },
    {
      "lastname": "Nussbaum",
      "forename": "Ronald A"
    },
    {
      "lastname": "Lynch",
      "forename": "John D"
    },
    {
      "lastname": "Green",
      "forename": "David M"
    },
    {
      "lastname": "Wheeler",
      "forename": "Ward C"
    }
  ],
  "status": "ok"
}';

$j = '{
  "atitle": "Phylogenetic systematics of dart-poison frogs and their relatives (Amphibia, Athesphatanura, Dendrobatidae).",
  "issn": "0003-0090",
  "volume": "299",
  "spage": "1",
  "doi": "10.1206\/0003-0090(2006)299[1:PSODFA]2.0.CO;2",
  "hdl": "2246\/5803",
  "year": "2006",
  "abstract": "The known diversity of dart-poison frog species has grown from 70 in the 1960s to 247 at present, with no sign that the discovery of new species will wane in the foreseeable future. Although this growth in knowledge of the diversity of this group has been accompanied by detailed investigations of many aspects of the biology of dendrobatids, their phylogenetic relationships remain poorly understood. This study was designed to test hypotheses of dendrobatid diversification by combining new and prior genotypic and phenotypic evidence in a total evidence analysis. DNA sequences were sampled for five mitochondrial and six nuclear loci (approximately 6,100 base pairs [bp]; \u00e5[arithmetic mean] = 53,740 bp per terminal; total dataset composed of approximately 1.55 million bp), and 174 phenotypic characters were scored from adult and larval morphology, alkaloid profiles, and behavior. These data were combined with relevant published DNA sequences. Ingroup sampling targeted several previously unsampled species, including Aromobates nocturnus, which was hypothesized previously to be the sister of all other dendrobatids. Undescribed and problematic species were sampled from multiple localities when possible. The final dataset consisted of 414 terminals: 367 ingroup terminals of 156 species and 47 outgroup terminals of 46 species. Direct optimization parsimony analysis of the equally weighted evidence resulted in 25,872 optimal trees. Forty nodes collapse in the strict consensus, with all conflict restricted to conspecific terminals. Dendrobatids were recovered as monophyletic, and their sister group consisted of Crossodactylus, Hylodes, and Megaelosia, recognized herein as Hylodidae. Among outgroup taxa, Centrolenidae was found to be the sister group of all athesphatanurans except Hylidae, Leptodactyidae was polyphyletic, Thoropa was nested within Cycloramphidae, and Ceratophryinae was paraphyletic with respect to Telmatobiinae. Among dendrobatids, the monophyly and content of Mannophryne and Phyllobates were corroborated. Aromobates nocturnus and Colostethus saltuensis were found to be nested within Nephelobates, and Minyobates was paraphyletic and nested within Dendrobates. Colostethus was shown to be rampantly nonmonophyletic, with most species falling into two unrelated cis- and trans-Andean clades. A morphologically and behaviorally diverse clade of median lingual process-possessing species was discovered. In light of these findings and the growth in knowledge of the diversity of this large clade over the past 40 years, we propose a new, monophyletic taxonomy for dendrobatids, recognizing the inclusive clade as a superfamily (Dendrobatoidea) composed of two families (one of which is new), six subfamilies (three new), and 16 genera (four new). Although poisonous frogs did not form a monophyletic group, the three poisonous lineages are all confined to the revised family Dendrobatidae, in keeping with the traditional application of this name. We also propose changes to achieve a monophyletic higher-level taxonomy for the athesphatanuran outgroup taxa. Analysis of character evolution revealed multiple origins of phytotelm-breeding, parental provisioning of nutritive oocytes for larval consumption (larval oophagy), and endotrophy. Available evidence indicates that transport of tadpoles on the dorsum of parent nurse frogs--a dendrobatid synapomorphy--is carried out primitively by male nurse frogs, with three independent origins of female transport and five independent origins of biparental transport. Reproductive amplexus is optimally explained as having been lost in the most recent common ancestor of Dendrobatoidea, with cephalic amplexus arising independently three times.",
  "created": "2008-09-17 15:16:00",
  "title": "Bulletin of the American Museum of Natural History",
  "open_access": "Y",
  "modified": "2100-00-00 00:00:00",
  "publisher_id": "oai:digitallibrary.amnh.org:2246\/5803",
  "genre": "article",
  "authors": [
    {
      "lastname": "Grant",
      "forename": "Taran"
    },
    {
      "lastname": "Frost",
      "forename": "Darrel R"
    },
    {
      "lastname": "Caldwell",
      "forename": "Janalee P"
    },
    {
      "lastname": "Gagliardo",
      "forename": "Ron"
    },
    {
      "lastname": "Haddad",
      "forename": "Celio F B"
    },
    {
      "lastname": "Kok",
      "forename": "Philippe J R"
    },
    {
      "lastname": "Means",
      "forename": "D Bruce"
    },
    {
      "lastname": "Noonan",
      "forename": "Brice P"
    },
    {
      "lastname": "Schargel",
      "forename": "Walter E"
    },
    {
      "lastname": "Wheeler",
      "forename": "Ward"
    }
  ],
  "status": "ok"
}';

$j='
{
  "atitle": "A new species of Diurnal Frog in the genus Crossodactylus Dum\u00e9ril and Bibron, 1841 (Anura, Leptodactylidae) from Southeastern Brazil",
  "issn": "0173-5373",
  "volume": "26",
  "spage": "497",
  "epage": "505",
  "doi": "10.1163\/156853805774806214",
  "year": "2005",
  "date": "2005-12-01",
  "created": "2008-10-02 20:34:57",
  "title": "Amphibia-Reptilia",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "eissn": "1568-5381",
  "genre": "article",
  "authors": [
    {
      "lastname": "Nascimento",
      "forename": "Luciana B"
    },
    {
      "lastname": "Cruz",
      "forename": "Carlos A G"
    },
    {
      "lastname": "Feio",
      "forename": "Renato N"
    }
  ],
  "status": "ok"
}';


$j = '{
  "atitle": "Paleogene equatorial penguins challenge the proposed relationship between biogeography, diversity, and Cenozoic climate change",
  "issn": "0027-8424",
  "volume": "104",
  "spage": "11545",
  "epage": "11550",
  "doi": "10.1073\/pnas.0611099104",
  "year": "2007",
  "date": "2007-07-10",
  "created": "2008-10-02 21:25:15",
  "title": "Proceedings of the National Academy of Sciences",
  "pmid": "17601778",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "eissn": "1091-6490",
  "genre": "article",
  "authors": [
    {
      "lastname": "Clarke",
      "forename": "J A"
    },
    {
      "lastname": "Ksepka",
      "forename": "D T"
    },
    {
      "lastname": "Stucchi",
      "forename": "M"
    },
    {
      "lastname": "Urbina",
      "forename": "M"
    },
    {
      "lastname": "Giannini",
      "forename": "N"
    },
    {
      "lastname": "Bertelli",
      "forename": "S"
    },
    {
      "lastname": "Narvaez",
      "forename": "Y"
    },
    {
      "lastname": "Boyd",
      "forename": "C A"
    }
  ],
  "status": "ok"
}';


$j='{
  "atitle": "Phylogeny-based delimitation of species boundaries and contact zones in the trilling chorus frogs (Pseudacris)",
  "issn": "1055-7903",
  "volume": "44",
  "spage": "1068",
  "epage": "1082",
  "doi": "10.1016\/j.ympev.2007.04.010",
  "year": "2007",
  "date": "2007-09-00",
  "created": "2008-10-02 23:17:55",
  "title": "Molecular Phylogenetics and Evolution",
  "pmid": "17562372",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "genre": "article",
  "authors": [
    {
      "lastname": "Lemmon",
      "forename": "E"
    },
    {
      "lastname": "Lemmon",
      "forename": "A"
    },
    {
      "lastname": "Collins",
      "forename": "J"
    },
    {
      "lastname": "Leeyaw",
      "forename": "J"
    },
    {
      "lastname": "Cannatella",
      "forename": "D"
    }
  ],
  "status": "ok"
}';

$j = '{
  "atitle": "Molecular phylogeny of the scincid lizards of New Caledonia and adjacent areas: evidence for a single origin of the endemic skinks of Tasmantis.",
  "issn": "1055-7903",
  "volume": "43",
  "issue": "3",
  "spage": "1151",
  "doi": "10.1016\/j.ympev.2007.02.007",
  "year": "2007",
  "date": "0000-00-00",
  "abstract": "We use approximately 1900bp of mitochondrial (ND2) and nuclear (c-mos and Rag-1) DNA sequence data to recover phylogenetic relationships among 58 species and 26 genera of Eugongylus group scincid lizards from New Caledonia, Lord Howe Island, New Zealand, Australia and New Guinea. Taxon sampling for New Caledonian forms was nearly complete. We find that the endemic skink genera occurring on New Caledonia, New Zealand and Lord Howe Island, which make up the Gondwanan continental block Tasmantis, form a monophyletic group. Within this group New Zealand and New Zealand+Lord Howe Island form monophyletic clades. These clades are nested within the radiation of skinks in New Caledonia. All of the New Caledonian genera are monophyletic, except Lioscincus. The Australian and New Guinean species form a largely unresolved polytomy with the Tasmantis clade. New Caledonian representatives of the more widespread genera Emoia and Cryptoblepharus are more closely related to the non-Tasmantis taxa than to the endemic New Caledonian genera. Using ND2 sequences and the calibration estimated for the agamid Laudakia, we estimate that the diversification of the Tasmantis lineage began at least 12.7 million years ago. However, using combined ND2 and c-mos data and the calibration estimated for pygopod lizards suggests the lineage is 35.4-40.74 million years old. Our results support the hypothesis that skinks colonized Tasmantis by over-water dispersal initially to New Caledonia, then to Lord Howe Island, and finally to New Zealand.",
  "created": "2008-10-31 14:03:47",
  "title": "Molecular phylogenetics and evolution",
  "pmid": "17400482",
  "open_access": "N",
  "modified": "2100-00-00 00:00:00",
  "genre": "article",
  "authors": [
    {
      "lastname": "Smith",
      "forename": "Sarah A"
    },
    {
      "lastname": "Sadlier",
      "forename": "Ross A"
    },
    {
      "lastname": "Bauer",
      "forename": "Aaron M"
    },
    {
      "lastname": "Austin",
      "forename": "Christopher C"
    },
    {
      "lastname": "Jackman",
      "forename": "Todd"
    }
  ],
  "status": "ok",
  
  
  "keywords":["Scincidae", "Phylogeny", "New Caledonia"]

  
}';

$o = new Reference();

$data = json_decode($j);

print_r($data);

$o->SetData($data);
$o->GenerateObjectId();
$o->Store();

$o->Dump();


?>


