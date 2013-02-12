var funcMap = new Array();
funcMap['committee'] = ['04'];
funcMap['treasurer'] = ['02'];
funcMap['president'] = ['06'];
funcMap['secretary'] = ['07', '14'];
funcMap['accounts'] = ['08'];
funcMap['notices'] = ['09'];
funcMap['correspondence'] = ['10'];
funcMap['meetings'] = ['11'];
funcMap['memberList'] = ['12'];
funcMap['memberCoord'] = ['13', '18'];
funcMap['members'] = ['16'];

function ahighlight(what) {
	var changes = funcMap[what];
	for (var i=0; i<changes.length; i++) {
	  	var toChange = $("ia" + changes[i]);
		var image = new Image();
		image.src = "images/arch/info-arch-on_" + changes[i] + ".gif";
	  	toChange.src = image.src;
	}
  	
  	if (what != sthisPage) {
		var changes = funcMap[sthisPage];
		if (changes) {
			for (var i=0; i<changes.length; i++) {
			  	var toChange = $("ia" + changes[i]);
			  	toChange.src = "images/arch/info-arch-off_" + changes[i] + ".gif";
			}
		}
   	}
}
function aofflight(what) {
	var changes = funcMap[what];
	for (var i=0; i<changes.length; i++) {
	  	var toChange = $("ia" + changes[i]);
	  	toChange.src = "images/arch/info-arch-off_" + changes[i] + ".gif";
	}
  	
  	var changes = funcMap[sthisPage];
  	if (changes) {
		for (var i=0; i<changes.length; i++) {
			var toChange = $("ia" + changes[i]);
			toChange.src = "images/arch/info-arch-on_" + changes[i] + ".gif";
		}
	}
}	