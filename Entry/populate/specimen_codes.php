<?php


// Need mapping between codes, collections, and DiGIR

// Extract museum specimen code
function extract_specimen_codes($t)
{
	$specimens = array();
	$ids = array();
	
	// Psuedo guids in genbank
	
	//echo $t;
	
	if (preg_match('/(?<code>[A-Z]+)( Herp )(?<number>[0-9]+)/', $t, $matches))
	{
		//print_r($matches);
		$s = new stdClass;
		$s->code = $matches['code'];
		$s->prefix = '';
		$s->number = $matches['number'];
		$s->end = '';
		array_push($specimens, $s);	
	}
	
	// Codes we recognise
	if (preg_match_all(
		'/
		(?<code>
		ABTC
		|AMCC
		|AMNH
		|ANWC
		|AMS
		|ANSP
		|ASU
		|BNHS
		|CAS
		|CASENT
		|CFBH
		|CWM
		|FMNH
		|INHS
		|IZUA
		|JAC
		|LACM
		|LSUMZ
		|KU
		|KUHE
		|MACN
		|MCZ
		|MNCN
		|MHNUC
		|MNRJ
		|MPEG
		|MRAC
		|MRT
		|MUJ
		|MVUP
		|MVZ
		|MZUFV
		|MZUSP
		|NT
		|NTM
		|OMNH
		|QCAZ
		|QM
		|QMJ
		|RAN
		|ROM
		|SAMA
		|SIUC
		|TNHC
		|THNHM
		|UCR
		|UMFS
		|UMMZ
		|USNM
		|USNMENT
		|USNM\sENT
		|UTA
		|UWBM
		|WAM
		|WHT
		|ZFMK
		|ZMA
		|ZMB
		|ZUFRJ
		)
		\s*
		(:|_|\-)?
		(?<number>((?<prefix>(J|R|A[\.|\s]?|A\-))?[0-9]+))
		
		(
			(\-|–|­|—)
			(?<end>[0-9]+)
		)?		

		
		
		/x',  
		
		$t, $out, PREG_PATTERN_ORDER))
	{
		//print_r($out);
		$found = true;
		
		for ($i = 0; $i < count($out[0]); $i++)
		{
			$s = new stdClass;
			$s->code = $out['code'][$i];
			$s->prefix = $out['prefix'][$i];
			$s->number = $out['number'][$i];
			$s->end = $out['end'][$i];
			array_push($specimens, $s);
		}
		
		//print_r($specimens);
		
	}
	
	if (preg_match_all(
		'/
		(?<code>BMNH)
		\s*
		(?<number>([0-9]{4}(\.[0-9]+)+) )
		
		(
			(\-|–|­|—)
			(?<end>[0-9]+)
		)?		
		
		/x',  
		
		$t, $out, PREG_PATTERN_ORDER))
	{
		//print_r($out);
		$found = true;
		
		for ($i = 0; $i < count($out[0]); $i++)
		{
			$s = new stdClass;
			$s->code = $out['code'][$i];
			$s->prefix = '';
			$s->number = $out['number'][$i];
			$s->end = $out['end'][$i];
			array_push($specimens, $s);
		}
		
		//print_r($specimens);
		
	}	
	
	if (preg_match_all(
		'/
		(?<code>MNHN)
		\s*
		(?<number>([0-9]{4}\.[0-9]+) )

		(
			(\-|–|­|—)
			(?<end>[0-9]+)
		)?		

		/x',  
		
		$t, $out, PREG_PATTERN_ORDER))
	{
		//print_r($out);
		$found = true;
		
		for ($i = 0; $i < count($out[0]); $i++)
		{
			$s = new stdClass;
			$s->code = $out['code'][$i];
			$s->prefix = '';
			$s->number = $out['number'][$i];
			$s->end = $out['end'][$i];
			array_push($specimens, $s);
		}
		
		//print_r($specimens);
		
	}	
	

	if (preg_match_all(
		'/
		(?<code>NCA|QVM|ZSM)
		\s*
		(?<number>([0-9]+(:|\/)[0-9]+))
		/x',  
		
		$t, $out, PREG_PATTERN_ORDER))
	{
		//print_r($out);
		$found = true;
		
		for ($i = 0; $i < count($out[0]); $i++)
		{
			$s = new stdClass;
			$s->code = $out['code'][$i];
			$s->number = $out['number'][$i];
			array_push($specimens, $s);
		}
		
		//print_r($specimens);
		
	}
	
	// Post process to handle lists of specimens
	foreach ($specimens as $z)
	{
		// Fix any codes
		if ($z->code == 'USNM ENT')
		{
			$z->code = 'USNMENT';
		}
	
	
		if ($z->end == '')
		{
			array_push($ids, $z->code . ' ' . $z->number);
		}
		else
		{
			// we've a range
		
			$prefix = $z->prefix;
			$start = preg_replace("/$prefix/", "", $z->number);
			
			
			if ($z->code == 'BMNH' || $z->code == 'MNHN')
			{
				//
				
				$pos = strrpos($start, ".");
				
				$leading = substr($start, 0, $pos+1);
				$start = substr($start, $pos+1);
				
				$len = strlen($z->end);			
				$part = substr($start, 0, strlen($start) - $len);
				$end = $part . $z->end;
				
				//echo $start . "\n";
				//echo $leading . "\n";
		
				for ($i = $start; $i <= $end; $i++)
				{
					//echo $z->code . ' ' . $leading . $i . "\n";
					
					array_push($ids, $z->code . ' ' . $leading . $i);

					
					// Need to store code here
				}
			}
			else
			{	
				$len = strlen($z->end);
					
				$part = substr($start, 0, strlen($start) - $len);
				$end = $part . $z->end;
				
			
				//echo $start . "\n";
				//echo $end . "\n";
				
				for ($i = $start; $i <= $end; $i++)
				{
					//echo $z->code . ' ' . $z->prefix . $i . "\n";
		
					array_push($ids, $z->code . ' ' . $z->prefix . $i);
					// Need to store code here
				}
			}
		}
	}
	
	
	return $ids;
}

if (0)
{
	
	// test code
	$samples = array();
	$failed = array();
	$specimens = array();
	
	/*array_push($samples, 'spinosa: ECUADOR: PICHINCHA: USNM 288443: RÌo Blanco. LOS RÌOS: USNM 286741≠44: RÌo Palenque.');
	
	array_push($samples, 'BMNH1947.2.26.89');
	
	array_push($samples, 'Material examined. ≠ Holotype - male, 30.3 mm SVL, WHT 5862, Hunnasgiriya (Knuckles), elevation 1,100 m (07∫23\' N, 80∫41\' E), coll. 17 Oct.2003. Paratypes - females, 35.0 mm SVL, WHT 2477, Corbett\'s Gap (Knuckles), 1,245 m (07∫ 22\' N, 80∫ 51\' E) coll. 6 Jun.1999; 33.8 mm SVL, WHT 6124, Corbett\'s Gap (Knuckles), 1,245 m (07∫ 22\' N, 80∫ 51\' E) coll. 16 Jun.2004; males, 30.3 mm SVL, WHT 5868, Hunnasgiriya, same data as holotype, coll. 16 Oct.2003; 31.3 mm');
	*/
	/*
	array_push($samples,'Gephyromantis runewsweeki, spec. nov. Figs 1-4, 6
	Types. Holotype: ZSM 49/2005, collected by M. Vences, I. De la Riva, E. and T. Rajearison on 25 January 2004 at the top of Maharira mountain, Ranomafana National Park, south-eastern Madagascar (21∞20.053\' S, 47∞ 24.787\' E), ca. 1350 m above sea level. ≠ Paratype: MNCN 42085, adult male with same collecting data as holotype.');
	
	array_push($samples,'Figure 57. L. orarius sp. nov., male paratype ex QVM 23:17693.
	Mesal (left) and anterior (right) views of right gonopod telopodite.
	Dashed lines indicate course of prostatic groove; scale bar = 0.25 mm.
	Figure 59. L. otwayensis sp. nov., male paratype, NMV K-9619. Mesal');
	
	array_push($samples,'FIGURES 1≠6. Adults and male genitalia. 1, Schinia immaculata, male, Arizona, Coconino Co.
	Colorado River, Grand Canyon, river mile 166.5 L, USNMENT 00229965; 2, S biundulata, female,
	Nevada, Humboldt Co. Sulphur, USNMENT 00220807; 3, S. immaculata, male genitalia; 4, S.
	immaculata, aedoeagus; 5, S. biundulata, male genitalia; 6, S. biundulata, aedoeagus.
	Material Examined. PARATYPES (3∞): U.S.A.: ARIZONA: COCONINO CO. 1∞
	same data as holotype except: USNM ENT 00210120 (NAU); river mile 166.5 L, old high
	water, 36.2542 N, 112.8996 W, 14 Apr. 2003 (1∞), R. J. Delph, USNM ENT 00219965
	(USNM); river mile 202 R, new high water, 36.0526 N, 113.3489 W, 15 May 2001 (1∞), J.
	Rundall, USNM ENT 00210119 (NAU). Paratypes deposited in the National Museum of
	Natural History, Washington, DC (USNM) and Northern Arizona University, Flagstaff,
	AZ (NAU).');
	
	*/
	// exmaples
	
	/*array_push($samples, 'WHT 5868');
	array_push($samples, 'BMNH1947.2.26.89');
	array_push($samples, 'ZSM 49/2005');
	array_push($samples, 'MNCN 42085');
	array_push($samples, 'USNM ENT 00210120');
	array_push($samples, 'MCZ A-119850');
	array_push($samples, 'SAMA R37834');
	array_push($samples, 'NT R.18657');
	array_push($samples, 'QVM 23:16172');
	array_push($samples, 'WAM R166250'); */
	//array_push($samples, 'LSUMZ 81921–7');
	//array_push($samples, 'LSUMZ 81921–7');
	//array_push($samples, 'MNHN 2000.612-23');
	array_push($samples,'BMNH 1933.9.10.9–11');
	array_push($samples, 'AMS R 93465');
	array_push($samples, 'SAMAR20583');
	array_push($samples, 'TNHC63518');
	array_push($samples,'FIGURES 1≠6. Adults and male genitalia. 1, Schinia immaculata, male, Arizona, Coconino Co.
	Colorado River, Grand Canyon, river mile 166.5 L, USNMENT 00229965; 2, S biundulata, female,
	Nevada, Humboldt Co. Sulphur, USNMENT 00220807; 3, S. immaculata, male genitalia; 4, S.
	immaculata, aedoeagus; 5, S. biundulata, male genitalia; 6, S. biundulata, aedoeagus.
	Material Examined. PARATYPES (3∞): U.S.A.: ARIZONA: COCONINO CO. 1∞
	same data as holotype except: USNM ENT 00210120 (NAU); river mile 166.5 L, old high
	water, 36.2542 N, 112.8996 W, 14 Apr. 2003 (1∞), R. J. Delph, USNM ENT 00219965
	(USNM); river mile 202 R, new high water, 36.0526 N, 113.3489 W, 15 May 2001 (1∞), J.
	Rundall, USNM ENT 00210119 (NAU). Paratypes deposited in the National Museum of
	Natural History, Washington, DC (USNM) and Northern Arizona University, Flagstaff,
AZ (NAU).');

array_push($samples, 'Material examined. ≠ Holotype - male, 30.3 mm SVL, WHT 5862, Hunnasgiriya (Knuckles), elevation 1,100 m (07∫23\' N, 80∫41\' E), coll. 17 Oct.2003. Paratypes - females, 35.0 mm SVL, WHT 2477, Corbett\'s Gap (Knuckles), 1,245 m (07∫ 22\' N, 80∫ 51\' E) coll. 6 Jun.1999; 33.8 mm SVL, WHT 6124, Corbett\'s Gap (Knuckles), 1,245 m (07∫ 22\' N, 80∫ 51\' E) coll. 16 Jun.2004; males, 30.3 mm SVL, WHT 5868, Hunnasgiriya, same data as holotype, coll. 16 Oct.2003; 31.3 mm');

	$ok = 0;
	foreach ($samples as $str)
	{
		$s = extract_specimen_codes($str);
		$matched = count($s);
		
		if ($matched > 0)
		{
			$specimens = array_merge($specimens, $s);
			$ok++;
		}
		else
		{
			array_push($failed, $str);
		}
	}
	
	// report
	
	echo "--------------------------\n";
	echo count($samples) . ' samples, ' . (count($samples) - $ok) . ' failed' . "\n";
	print_r($failed);
	
	print_r($specimens);
	
	// Post process specimens
	

	
	
	
	
}



?>