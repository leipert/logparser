function impressum(){
		var url = 'impressum.htm';
		var seite= 'Impressum';
		var dialog = $('<div style="display:none"></div>').appendTo('body');
		// load remote content
		dialog.load(
				url, 
				{}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object
				function (responseText, textStatus, XMLHttpRequest) {
					var hohe=$(window).height()*80/100;
					var breite=$(window).width()*56/100;
					dialog.dialog({
						title: seite,
						height: hohe,
						width: breite,
						resizable: false,
						// add a close listener to prevent adding multiple divs to the document
						close: function(event, ui) {
							// remove div with all data and events
							dialog.remove();
						}
					});
				}
			);
			// prevent the browser to follow the link
		return false;
	}
	
function SelectText(element) {
    var doc = document
        , text = doc.getElementById(element)
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}