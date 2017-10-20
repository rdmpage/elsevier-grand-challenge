<?php 

// Make sure includes are absolute paths
$rootdir = dirname(__FILE__) . '/';

require_once($rootdir . 'config.inc.php');
require_once($rootdir . 'utils.php');

class Graph {
	
	var $edges;
	var $nodes;
	var $node_count;
	var $root;
	var $directed = false;

	function Graph ($directed = false)
	{
		$this->node_count = 0;
		$this->edges = array();
		$this->nodes = array();
		$this->directed = $directed;
	}

	function AddNode ($label, $name='', $type = '', $count=1)
	{

		$id = $this->node_count;
		if (isset ($this->nodes[$label]))
		{
			$id = $this->nodes[$label]['id'];
		}
		else
		{
			$this->nodes[$label] = array(
				"id" => $this->node_count, 
				"label" => $label, 
				"name" => $name, 
				"type" => $type,
				"count" => $count);
			$this->node_count++;
		}
		return $id;
	}

	function AddEdge ($source_id, $target_id, $label = '')
	{
		$edge = array(
				"source" => $source_id, 
				"target" => $target_id, 
				"label" => $label);

		if (!array_search($edge, $this->edges)) {

		array_push ($this->edges, $edge);}

	}
	function WriteDot ()
	{
		global $config;
		
		$dot = '';
		if ($this->directed)
		{
			$dot .= "digraph G {\n";
		}
		else
		{
			$dot .= "graph G {\n";
		}
//		$dot .= "rankdir=LR;\n";
//		$dot .= "bgcolor=\"#f1f5f9\";\n";
		$dot .= "size=\"3,3\";\n";
		
		$dot .= "node [fontsize=7, fontname=\"Helvetica\"];\n";
		$dot .= "edge [fontsize=7, fontname=\"Helvetica\"];\n";
		
		foreach ($this->nodes as $node)
		{		
			$label = $node['label'];	
			
			if ($node['name'] != '')
			{
				$label = $node['name'];
			}		
		
			$dot .= "node" . $node["id"] . " [label=\"" . trim_text($label, 10) .  "\"";
						
			$c = $node["count"];
			$c = log10($c + 1);
			
			$size = sqrt($c) * 0.5;
			$dot .= ", width=$size,height=$size";
			
/*			if (1 == $node["count"])
			{
				$dot .= ', URL="' . $config['webroot'] . 'uri/' . $node["label"] . '"'; 
			}
*/			
			
			if ($node["type"] == "literal")
			{
				$dot .= ", shape=box";
				$dot .= ", fillcolor=yellow";
			}
			if ($node["type"] == "bnode")
			{
				$dot .= ", shape=circle";
			}
			
			$dot .= "];\n";
		}
		

		foreach ($this->edges as $edge)
		{
			$dot .= "node" . $edge["source"];
			
			if ($this->directed)
			{
				$dot .= " -> ";
			}
			else
			{
				$dot .= " -- ";
			}
			$dot .=	 "node" . $edge["target"];
			
			$dot .= " [label=\"" . $edge["label"] . "\"]";
			
			$dot .= ";\n";
				}
		$dot .= "}\n\n";
		
		return $dot;
	}
	
	function WriteDotToFile($filename)
	{
		$fd = fopen($filename, "w");
		fwrite($fd, $this->WriteDot());
		fclose($fd);
	}
	
	function Html($id)
	{
		global $config;
		
		$filename = "tmp/" . $id . ".dot";
		$this->WriteDotToFile($filename);	
		
		$html = '<img src="' . $config['webdot'] . '/' . $config['webroot'] . $filename . '.png" usemap="#G" border="0" alt="graph"/>';
		
		// Image map
		
		$map_file_name = "tmp/" . $id . ".map";
		
		$command = $config['neato'] . " -Tcmapx -o$map_file_name " .  $filename;
		system($command);
		
		// Include image map
		$map_file = @fopen($map_file_name, "r") or die("could't open file \"$map_file_name\"");
		$map = @fread($map_file, filesize ($map_file_name));
		fclose($map_file);
		
		$html .= $map;
		
		return $html;	
	}


}




// test
/*
$G = new Graph();

$source = $G->AddNode('a');
$target = $G->AddNode('b');

$G->AddEdge($source, $target, 'edge'); 


$dot = $G->WriteDot();

$html = $G->Html(1);

echo $html;  

echo htmlentities($html);
*/
?>