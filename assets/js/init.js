// JavaScript Document
/********************************************
* 	Filename:	js/init.js
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Sunday, April 20, 2008  16:22
***********************************************/


 var langManager = new languageManager();

var treeOps = new TreeOperations();
$(document).ready(function() {
	
	// binding menu functions
	$('#myMenu1 .addDoc').click(function()  {  treeOps.addElementReq(); });									   						    
	$('#myMenu1 .addFolder').click(function()  {  treeOps.addElementReq(true); });	
	$('#myMenu1 .addSurvey').click(function()  {  treeOps.addSurveyReq(true); });
	$('#myMenu1 .addEmpSurvey').click(function()  {  treeOps.addEmpSurveyReq(true); });	
	
	$('#myMenu1 .edit, #myMenu2 .edit').click(function() {  treeOps.updateElementNameReq(); });
	$('#myMenu1 .delete, #myMenu2 .delete').click(function() {  treeOps.deleteElementReq(); });
	$('#myMenu1 .expandAll').click(function (){ treeOps.expandAll($('.simpleTree > .root > ul')); });
	$('#myMenu1 .collapseAll').click(function (){ treeOps.collapseAll(); });
	
	
	// setting menu texts 
	$('#myMenu1 .addDoc').append(langManager.addDocMenu);
	$('#myMenu1 .addFolder').append("Add Item");
	$('#myMenu1 .addSurvey').append("Add Survey Point");
	$('#myMenu1 .addEmpSurvey').append("Add Employee Survey");
	$('#myMenu1 .edit, #myMenu2 .edit').append("Edit");
	$('#myMenu1 .delete, #myMenu2 .delete').append("Delete");
	$('#myMenu1 .expandAll').append("Expand all");
	$('#myMenu1 .collapseAll').append("Collapse all");
	
		
	// initialization of tree
	simpleTree = $('.simpleTree').simpleTree({
		autoclose: false,
		/**
		 * restore tree state according the cookies it stored.
		 */
		restoreTreeState: true,
		
		/**
		 * Callback function is called when one item is clicked
		 */	
		afterClick:function(node){
				//alert($('span:first', node).text() + " clicked");
				//alert($('span:first',node).parent().attr('id'));
		},
		/**
		 * Callback function is called when one item is double-clicked
		 */	
		afterDblClick:function(node){
			//alert($('span:first',node).text() + " double clicked");		
		},
		afterMove:function(destination, source, pos) {
		//	alert("destination-"+destination.attr('id')+" source-"+source.attr('id')+" pos-"+pos);	
			if (dragOperation == true) 
			{				
				
				var params = "action=changeOrder&elementid="+source.attr('id')+"&destparent_id="+destination.attr('id')+
							 "&position="+pos + "&oldparent_id=" + simpleTree.get(0).parent_idOfDraggingItem;
				
				treeOps.ajaxReq(params, structureManagerURL, null, function(result)
				{						
					treeOps.treeBusy = false;
					treeOps.showInProcessInfo(false);
					try {
						var t = eval(result);
						// if result is less than 0, it means an error occured														
						if (treeOps.isInt(t) == true  && t < 0) { 
							alert(eval("langManager.error_" + Math.abs(t)) + "\n"+"Page will be reloaded.");									
							window.location.reload();							
						}
						else {
							var info = eval("(" + result + ")");
							$('#' + info.oldElementid).attr("id", info.elementid);
						}
					}
					catch(ex) {	
							var info = eval("(" + result + ")");
							$('#' + info.oldElementid).attr("id", info.elementid);	
					}	
				});
			}
		},
		afterAjax:function(node)
		{			
			if (node.html().length == 1) {
				node.html("<li class='line-last'></li>");
			}
		},		
		afterContextMenu: function(element, event)
		{
			var className = element.attr('class');
			if (className.indexOf('doc') >= 0) {
				$('#myMenu2').css('top',event.pageY).css('left',event.pageX).show();				
			}
			else {
				if (className.indexOf('root') >= 0) {
					$('#myMenu1 .edit, #myMenu1 .delete').hide();
					$('#myMenu1 .expandAll, #myMenu1 .collapseAll').show();
				}
				else {
					$('#myMenu1 .expandAll, #myMenu1 .collapseAll').hide();
				}
				$('#myMenu1').css('top',event.pageY).css('left',event.pageX).show();
			}
			
			$('*').click(function() { $('#myMenu1, #myMenu2').hide(); $('#myMenu1 .edit, #myMenu1 .delete').show(); });
			
		},
		animate:true
		//,docToFolderConvert:true		
	});		
});