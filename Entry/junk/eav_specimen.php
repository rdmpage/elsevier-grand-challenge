<?php

// import a specimen record

require_once('eav/eav.php');
require_once('class_object.php');
require_once('class_specimen.php');

$j = '{
  "title": "USNM 514547",
  "guid": "USNM:Herps:514547",
  "institutionCode": "USNM",
  "collectionCode": "Herps",
  "catalogNumber": "514547",
  "organism": "Eleutherodactylus ridens",
  "kingdom": "Animalia",
  "phylum": "Chordata",
  "class": "Amphibia",
  "order": "Anura",
  "family": "Strabomantidae",
  "genus": "Eleutherodactylus",
  "species": "ridens",
  "country": "Honduras",
  "stateProvince": "Atlantida",
  "locality": "Parque Nacional Pico Bonito, Quebrada de Oro (tributary of R\u00edo Viejo)",
  "latitude": "15.6",
  "longitude": "-86.8",
  "elevation": "940",
  "verbatimLatitude": "15 38 -- N",
  "verbatimLongitude": "086 48 -- W",
  "dateLastModified": "2008-8-25T07:10:52.000Z",
  "verbatimCollectingDate": "28 May 1996",
  "collector": "S. Gotte",
  "collectorNumber": "LDW 10706",
  "dateCollected": "1996-05-28",
  "dateModified": "2008-08-25",
  "namebankID": [
    "2476165"
  ],
  "bci": "urn:lsid:biocol.org:col:34872"
}';


$o = new Specimen();

$data = json_decode($j);

$o->SetData($data);
$o->GenerateObjectId();
$o->Store();

$o->Dump();


?>


