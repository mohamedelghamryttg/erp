// JavaScript Document
function languageManager() {
	
	
	this.addIndexes= function() {
		for (var n in arguments[0]) { 
			this[n] = arguments[0][n]; 
		}
	}	
}

var langManager = new languageManager();

langManager.addIndexes({
error_1:'An error occured in the operation',
error_2:'The element with the same name already exists',
willReload:'Page will be reloaded.',
deleteConfirm:'Are you sure you want to delete this item?',
doOneOperationAtATime:'Only one operation can be active at any time.',
operationInProcess:'Completing your request.',
selectNode2MakeOperation:'To make an operation please click an item to activate it.',
addDocMenu:'Add file',
addFolderMenu:'Add Item',
editMenu:'Edit',
deleteMenu:'Delete',
missionCompleted:'Request is completed succesfully.',
expandAll:'Expand all',
collapseAll:'Collapse all'
});