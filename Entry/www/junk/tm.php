<?php

// Simple PHP treemap


//--------------------------------------------------------------------------------------------------

// Helper functions

//--------------------------------------------------------------------------------------------------
// Word wrapping
// http://www.xtremevbtalk.com/showthread.php?t=289709
function findStrWidth($str, $width, $low, $hi)
{
	$txtWidth = strlen($str);
	
	if (($txtWidth < $width) || ($hi == 1))
	{
		// string fits, or is one character long
		return $hi;
	}
	else
	{
		if ($hi - $low <= 1)
		{
			// we have at last character
			$txtWidth = $low;
			return $low;
		}
		else
		{
			$mid = $low + floor(($hi - $low)/2.0);
			
			$txtWidth = strlen(substr($str, 0, $mid));
			if ($txtWidth < $width)
			{
				// too short
				$low = $mid;
				return findStrWidth($str, $width, $low, $hi);
			}
			else
			{
				// too long
				$hi = $mid;
				return findStrWidth($str, $width, $low, $hi);
			}
		}
	}
}

//--------------------------------------------------------------------------------------------------
// http://www.herethere.net/~samson/php/color_gradient/
// Return the interpolated value between pBegin and pEnd
function interpolate($pBegin, $pEnd, $pStep, $pMax) 
{
	if ($pBegin < $pEnd) 
	{
  		return (($pEnd - $pBegin) * ($pStep / $pMax)) + $pBegin;
	} 
	else 
	{
  		return (($pBegin - $pEnd) * (1 - ($pStep / $pMax))) + $pEnd;
	}
}


//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a rectangle
 *
 */class Rectangle
{
	var $x;
	var $y;
	var $w;
	var $h;
	

	function Rectangle($x=0, $y=0, $w=0, $h=0)
	{
		$this->x = $x;
		$this->y = $y;
		$this->w = $w;
		$this->h = $h;
	}
	
	function Dump()
	{
		echo $this->x . ' ' . $this->y . ' ' . $this->w . ' ' . $this->h . "\n";
	}
	
	
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Encapsulate a cell in the Treemap
 *
 */
class Item
{
	var $bounds;			 // rectangle cell occupies (computed by treemap layout)
	var $size;				 // quantity cell corresponds to
	var $id;				 // id, typically an external id so we can make a link
	var $children = array(); // children of this node, if we are doing > 1 level
	var $label;				 // label for cell
	var $isLeaf;			 // flag for whether cell is a leaf

	/**
	* @brief Constructor
	*
	* @param n Number of items in this cell
	* @param label Label for this cell
	* @param ext External identifier for this cell (used to make a link)
	* @param leaf True if this cell has no children
	*
	*/
	function Item($n = 0, $label = '', $ext = 0, $leaf = false)
	{		
		$this->bounds 	= new Rectangle();
		$this->size 	= $n;
		$this->label 	= $label;
		$this->isLeaf 	= $leaf;
		$this->id		= $ext;
	}
	
}

//--------------------------------------------------------------------------------------------------
/**
 * @brief Compute weight of list of items to be placed
 *
 * This is the sum of the quantity represented by each item in the list.
 * @param l Array of items being placed
 *
 * @return Weight of items
 */
function w($l)
{
	$sum = 0.0;
	foreach ($l as $item)
	{
		$sum += $item->size;
	}
	return $sum;
}


$drawme = array();


//--------------------------------------------------------------------------------------------------
/**
 * @brief Split layout
 *
 * Implements Björn Engdahl's Split Layout algorithm for treemaps,
 * see http://www.nada.kth.se/utbildning/grukth/exjobb/rapportlistor/2005/rapporter05/engdahl_bjorn_05033.pdf
 *
 * This is a recursive function that lays out the treemap. It tries to satisfy the twin goals of 
 * a good aspect ratio for the rectangles, and minimal changes to the order of the items in the treemap.
 *
 * @param items Array of items to place
 * @param r Current rectangle
 *
 */
function splitLayout($items, &$r)
{
	global $cr;
	global $drawme;
	
	if (count($items) == 0)
	{
		return;
	}
	
	if (count($items) == 1)
	{
		// Store rectangle dimensions
		$cr[$items[0]->id] = $r;
		
		$items[0]->bounds = $r;
		
		
		// add to list of rectangles to draw...
		array_push($drawme, $items[0]);
		
		
		// Handle children (if any)		
		if (isset($items[0]->children))
		{
			$rc = new Rectangle($r->x, $r->y+10, $r->w, $r->h-10);
			splitLayout($items[0]->children, $rc);
		}
		else
		{
			return;
		}
		
		return;
		
	}
	
	// Split list of items into two roughly equal lists
	$l1 = array();
	$l2 = array();
	
	$halfSize = w($items) / 2.0;
	$w1 		= 0.0;
	$tmp 		= 0.0;
	
	while (count($items) > 0)
	{
		$item = $items[0];
		
		$tmp = $w1 + $item->size;
		
		// Has it gotten worse by picking another item?
		if (abs($halfSize - $tmp) > abs($halfSize - $w1))
		{
			break;
		}
		
		// It was good to pick another
		array_push($l1, array_shift($items));
		$w1 = $tmp;
	}
	
	// The rest of the items go into l2
	foreach ($items as $item)
	{
		array_push($l2, $item);
	}
	
	$wl1 = w($l1);
	$wl2 = w($l2);
	
	
	// Which way do we split current rectangle it?	
	if ($r->w > $r->h)
	{
		// vertically
		$r1 = new Rectangle(
			$r->x, 
			$r->y,
			$r->w * $wl1/($wl1 + $wl2),
			$r->h);
	
		$r2 = new Rectangle(
			$r->x + $r1->w, 
			$r->y,
			$r->w - $r1->w,
			$r->h);
	}
	else
	{
		// horizontally
		$r1 = new Rectangle(
			$r->x, 
			$r->y,
			$r->w,
			$r->h * $wl1/($wl1 + $wl2));
	
		$r2 = new Rectangle(
			$r->x, 
			$r->y + $r1->h,
			$r->w,
			$r->h - $r1->h);	
	}
		
	// Continue recursively
	splitLayout($l1, $r1);
	splitLayout($l2, $r2);
}


function centre_image($imageRect, $viewRect)
{

	$imageRect->Dump();
	$viewRect->Dump();
	
	// scale image
	
	$image_aspect = $imageRect->w / $imageRect->h;
	echo $image_aspect . '<br/>';
	
	$view_aspect = $viewRect->w / $viewRect->h;
	echo $view_aspect . '<br/>';
	
	if ($image_aspect < $view_aspect)
	{
		// image is too low
		echo 'Image is too low<br/>';
		$factor = $viewRect->w / $imageRect->w;
		
		$imageRect->w = $viewRect->w;
		$imageRect->h = $imageRect->h * $factor;
		
		$imageRect->Dump();
		echo '<br/>';
	}
	else
	{
		// image is too wide
		echo 'Image is too wide<br/>';
		
		$factor = $viewRect->h / $imageRect->h;
		
		$imageRect->h = $viewRect->h;
		$imageRect->w = $imageRect->w * $factor;
		
		$imageRect->Dump();
		echo '<br/>';
		
	}
	
	
	$image_cx = ($imageRect->w)/2;
	$image_cy = ($imageRect->h)/2;
	
	echo "<br/>image_cx=$image_cx image_cy=$image_cy<br/>";
	
	
	
	$view_cx = ($viewRect->w)/2;
	$view_cy = ($viewRect->h)/2;
	
	echo "<br/>view_cx=$view_cx view_cy=$view_cy<br/>";
	
	
	$offset_x = $image_cx - $view_cx;
	$offset_y = $image_cy - $view_cy;
	
	echo "offset_x=$offset_x offset_y=$offset_y<br/>";
	

}




function treemap_widget($x, $y, $width, $height, $data)
{
	global $drawme;

	// Initial bounding rectangle
	$r = new Rectangle($x,$y,$width,$height);

	// Compute the layout
	splitLayout($data, $r);
	
	//  HTML
	
	$html = '';
	
	
	// Enclosed treemap in a DIV that has position:relative. The cells themselves have position:absolute.
	// Note also that the enclosing DIV has the same height as the treemap, so that elements that follow
	// the treemap appear below the treemap (rather than being obscured).
	$html .= '<div style="position:relative;font-family:Arial;font-size:10px;height:' . $height . 'px;background-color:black;width:' . $width . 'px;">';
	$theNumSteps = count($drawme);
	$count = 0;
	foreach ($drawme as $i)
	{
		// Note that each treemap cell has position:absolute
		$html .= '<div id="div' . $i->id . '" class="cell" style="position: absolute; overflow:hidden;text-align:center;';
		$html .= 'background-color:rgb(240,240,240);';
		$html .= ' left:' . $i->bounds->x . 'px;';
		$html .= ' top:' . $i->bounds->y . 'px;';
		$html .= ' width:' . $i->bounds->w. 'px;';
		$html .= ' height:' . $i->bounds->h . 'px;';
		$html .= ' border:4px solid white;';
		$html .= '" ';
		
		$html .= ' >';
		
		
					
		// Text is taxon name, plus number of leaf descendants
		// Note that $number[$count] is log (n+1)
		$tag = $i->label; // . ' ' . number_format(pow(10, $i->size) - 1);
				
				
		// format the tag...
		
		$html .= '<div style="font-size:10px;text-align:center;background-color:white">' . $tag . '</div>';
		if ($i->label == '5')
		{
			// Image dimensions
			$w = 75;
			$h = 75;
			
			$imageRect = new Rectangle(0, 0, $w, $h);
			$viewRect = $i->bounds;
			
			centre_image($imageRect,$viewRect);
			
			
			$html .= '<div style="position:relative;top:0px"><img src="3010412027_8bdec3f2fb_s.jpg" width="100"/></div>';
//			$html .= '<div style="position:relative;left:-23px"><img src="3010412027_8bdec3f2fb_s.jpg" height="100"/></div>';
		
		}
		
		$html .= '</div>';
		$count++;
	}
	$html .= '</div>';
	
	return $html;

}


// Create some data for us to plot

$items = array();


	$i = new Item(10,'10',1);
	array_push($items, $i);
	$i = new Item(5,'5', 2);
	array_push($items, $i);
	$i = new Item(4,'4', 3);
	array_push($items, $i);
	$i = new Item(1,'2', 4);
	array_push($items, $i);
	$i = new Item(1,'2', 5);
	array_push($items, $i);
	$i = new Item(20,'20', 6);
	array_push($items, $i);
	
	
echo treemap_widget(0,0,200,200,$items);
	
/*	

// Treemap bounds
$tm_width = 200;
$tm_height = 200;
$r = new Rectangle(0,0,$tm_width,$tm_height);

// Compute the layout
splitLayout($items, $r);

?>
<html>
<head>

<script type="text/javascript">
<!--

    function mouse_over(id) 
    {
    	var e = document.getElementById(id);
//    	e.style.opacity= "1.0";
//	    e.style.filter = "alpha(opacity=100)";
    	e.style.opacity=0.6;
       e.style.filter = "alpha(opacity=60)";
    }
    
    function mouse_out(id) 
    {
    	var e = document.getElementById(id);
//    	e.style.opacity=0.6;
//        e.style.filter = "alpha(opacity=60)";
   		e.style.opacity=1.0;
        e.style.filter = "alpha(opacity=100)";
    }    
//-->
</script>
<style type="text/css">

</style>
</head>
<body style="background-color:rgb(192,192,192);">
<?php


// Tell user where we are in the classification


// Dump cells
echo '<pre>';
foreach ($items as $i)
{
	print_r($i);
}
foreach ($drawme as $i)
{
	print_r($i);
}
echo '</pre>';



// Enclosed treemap in a DIV that has position:relative. The cells themselves have position:absolute.
// Note also that the enclosing DIV has the same height as the treemap, so that elements that follow
// the treemap appear below the treemap (rather than being obscured).
echo '<div style="color:white;font-family:Arial;position:relative;font-size:10px;height:' . $tm_height . 'px;margin-left:20px;background-color:black;width:' . $tm_width . 'px;">';
$theNumSteps = count($drawme);
$count = 0;
foreach ($drawme as $i)
{
	// Note that each treemap cell has position:absolute
	echo '<div id="div' . $i->id . '" class="cell" style="position: absolute; overflow:hidden;text-align:center;';
// 	echo 'opacity:0.6;filter:alpha(opacity=60);';
 //	echo 'background: url(240px-Gammarus_roeselii.jpg) 0% 0% repeat-x;';
 	echo 'background-color:yellow;';
	echo ' left:' . $i->bounds->x . 'px;';
	echo ' top:' . $i->bounds->y . 'px;';
	echo ' width:' . $i->bounds->w. 'px;';
	echo ' height:' . $i->bounds->h . 'px;';
	echo ' border:1px solid white;';
	//echo ' padding:2px;';
	
//	echo "background-color:black; ";
	echo '" ';
    
    // Mouse activity
    echo ' onMouseOver="mouse_over(\'div' . $i->id . '\');" ';
    echo ' onMouseOut="mouse_out(\'div' . $i->id . '\');" ';

	// Link to drill down
//	if (!$i->isLeaf)
//	{
//	    echo ' onClick="document.location=\'?node=' . $i->id . '\';" ';
//	}
	echo ' >';
	
	if ($i->label == '10')
	{
		// Image dimensions
		$w = 249;
		$h = 149;
	
	
		echo '<img src="240px-Gammarus_roeselii.jpg" />';
	
	}
	
				
	// Text is taxon name, plus number of leaf descendants
	// Note that $number[$count] is log (n+1)
	$tag = $i->label; // . ' ' . number_format(pow(10, $i->size) - 1);
			
			
	// format the tag...
	
	if (count($i->children) != 0)
	{
	echo '<div style="font-size:10px;text-align:left;background-color:rgb(128,128,128)">' . $tag . '</div>';
	}
	
	echo '</div>';
	echo "\n";

	$count++;
}
echo '</div>';

echo '<div><p>Text following the treemap goes here...</p></div>';

echo '</body>
</html>';
*/
?>






	