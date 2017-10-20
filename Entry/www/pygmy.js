
// Basic pygmybrowser

var gNodePrefix 		= 'node';
var gRootId 			= 1;
var gMaxListHeight 		= 100; // for IE 6
var gChildHeight 		= 12;	// for IE 6

//--------------------------------------------------------------------------------------------------
// Format a taxon name nicely
function formatTaxonName(name, rank)
{
	var formatted_name = '';
	
	switch (rank)
	{
		case 'genus':
		case 'subspecies':
			formatted_name = '<i>' + name + '</i>';
			break;
			
		// Handle cases where species is undescribed
		case 'species':
			var spPattern = /^\w+\s+sp.\s+/;
			if (spPattern.test(name))
			{
				formatted_name = '<i>' + name.replace(' sp. ', '</i> sp. ');
			}
			else
			{
				formatted_name = '<i>' + name + '</i>';
			}
			break;

			
		default:
			formatted_name = name;
			break;
	}
	
	var hybridPattern = / x /;
	if (hybridPattern)
	{
		formatted_name = formatted_name.replace(' x ', ' &times; ');
	}
	
	
	return formatted_name;
}

//--------------------------------------------------------------------------------------------------
// Called when user clicks on a node. Make an AJAX request to get subtree rooted on node id
function show_node(id)
{
	url = 'getNCBI.php';
	pars = 'id=' + id;
	
	var myAjax = new Ajax.Request( url, 
		{method: 'get', parameters: pars, onLoading: showLoad, onComplete: showResponse} );

}

//--------------------------------------------------------------------------------------------------
// Display any message while loading the tree or its subtrees
function showLoad () 
{
//	alert('lo');
//	$('load').style.display = 'block';
}



//--------------------------------------------------------------------------------------------------
// Display the tree
function showResponse (originalRequest) 
{
	// Result of call to external servicethat supplies the tree
	var obj = eval(originalRequest.responseText);
	
	node_id = gNodePrefix + obj.id;
	parent_node_id = gNodePrefix + obj.parentId;
	
	//----------------------------------------------------------------------------------------------
	node = $(node_id);

	if (node == null)
	{
		//alert ('Node ' + obj.id + ' doesn\'t exist');
	
		// This node doesn't exist in the control, so either we are creating the control
		// for the first time, or user has clicked on a node in a list of children.

		parent_node = $(parent_node_id);
		
		//------------------------------------------------------------------------------------------
		if (parent_node == null)
		{
			// We don't have a parent node in the browser, so create complete lineage
			parent_id = gRootId;
			
			for (var i = 0; i < obj.lineage.length; i++)
			{
				if (obj.lineage[i].id != gRootId)
				{
					node = document.createElement("div");
					node.className = 'pygmy_node';
					node.setAttribute('id', gNodePrefix + obj.lineage[i].id);
					var html = '<span class="pygmy_internal"'
						+ ' onclick="show_node(' + obj.lineage[i].id + ')"'
						+ ' ondblclick="nodeInfo(' + obj.lineage[i].id + ')"'
						+ '>';
					html += formatTaxonName (obj.lineage[i].name, obj.lineage[i].rank);
						
					// common name
					var commonName = obj.lineage[i].commonName;
					if (commonName != '')
					{
						html += '&nbsp;(' + commonName + ')';
					}					
					html += '</span>';
						
					node.innerHTML = html;
					nodeParent = document.getElementById(gNodePrefix + parent_id);
					nodeParent.appendChild(node);
				
					parent_id = obj.lineage[i].id;
				}
			}
		}
		else //-------------------------------------------------------------------------------------
		{
			// User has clicked on a node in the child list
			nodeParent = document.getElementById(parent_node_id);
				
			// Delete the list of children currently being displayed
			list = document.getElementById('pygmy_list');
			nodeParent.removeChild(list);
			
			// Create node corresponding to node user clicked on in child list
			node = document.createElement("div");
			node.className = 'pygmy_node';
			node.setAttribute('id', gNodePrefix + obj.id);
			var html = '<span class="pygmy_internal"'
				+ ' onclick="show_node(' + obj.id + ')"'
				+ ' ondblclick="nodeInfo(' + obj.id + ')"'
				+ '>';
						
			html += formatTaxonName (obj.name, obj.rank);
				
			// common name
			var commonName = obj.commonName;
			if (commonName != '')
			{
				html += '&nbsp;(' + commonName + ')';
			}
			html += '</span>';
						
			node.innerHTML = html;
			nodeParent.appendChild(node);

		}
	}
	else //-----------------------------------------------------------------------------------------
	{
		
		// Node exists, so user has clicked on a node in the lineage list.
		
		// Get id of first child node in the tree (note that this is child '1' as the <span>
		// tag holding the text is the first child in the DOM). We then animate hiding these
		// descendants
		
		// Can we animate this?
		
		node.removeChild($(node_id).childElements()[1]);
	}
	
	//----------------------------------------------------------------------------------------------
	// At this point we now display the node itself. It is either a leaf node (i.e., at the tip
	// of the tree), or an internal node, in which case we display a child list.

	if (obj.children.length > 0)
	{
		//alert('children');
		
		objElement = document.createElement('div');
		objElement.className = 'pygmy_list';
		objElement.setAttribute('id', 'pygmy_list');
		
		node.appendChild(objElement);
		
		//alert(obj.children.length);
		
		var h = 0;
		
		for (var i = 0; i < obj.children.length; i++)
		{	
			var span_class = (i == obj.children.length-1) ? 'pygmy_lastchild' : 'pygmy_child';
			var html = '<span class="' + span_class + '" '
				+ ' onclick="show_node(' + obj.children[i].id + ')"'
				+ ' ondblclick="nodeInfo(' + obj.children[i].id + ')"'
				+ '>';
			html += formatTaxonName (obj.children[i].name, obj.children[i].rank);
			// common name
			var commonName = obj.children[i].commonName;
			if (commonName != '')
			{
				html += '&nbsp;(' + commonName + ')';
			}			
			html += '</span><br />';
		
			objElement.innerHTML += html;
			h += gChildHeight;
		}
		/* For IE 6 */
		if (Prototype.Browser.IE)
		{
			if (h > gMaxListHeight)
			{
				h = gMaxListHeight;
			}
			objElement.style.height = h + 'px';
		}
		
	}
	else
	{
   		// Node is a leaf, so display this in a span of class pygmy_leaf(not clickable)
   		
		var html = '<span class="pygmy_leaf">';		
		html += formatTaxonName (obj.name, obj.rank);
		// common name
		commonName = obj.commonName;
		if (commonName != '')
		{
			html += '&nbsp;(' + commonName + ')';
		}
		html += '</span>';
    	node.innerHTML = html;
	}
}
