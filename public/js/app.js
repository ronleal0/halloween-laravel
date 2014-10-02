// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$('.productPart').infinitescroll({
 
    navSelector  : ".pagination",            
                   // selector for the paged navigation (it will be hidden)
    nextSelector : ".pagination a:first",    
                   // selector for the NEXT link (to page 2)
    itemSelector : ".productbox"    
                   // selector for all items you'll retrieve
  });

	function dosearch() {
	var sf=document.searchform;
	for (i=sf.siteSearch.length-1; i > -1; i--) {
		if (sf.siteSearch[i].checked) {
			var submitto = sf.siteSearch[i].value + escape(sf.query.value);
		}
	}
	var word = escape(sf.query.value);
	if(submitto === undefined){
		submitto = '/q?query=' + word;
	}
	// console.log(submitto);
	// window.location.href = submitto;
	return false;
	}

$('.prodName a').dotdotdot();