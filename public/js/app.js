// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation({
	accordion: {
	    // specify the class used for active (or open) accordion panels
	    active_class: 'active',
	    // allow multiple accordion panels to be active at the same time
	    multi_expand: false,
	    // allow accordion panels to be closed by clicking on their headers
	    // setting to false only closes accordion panels when another is opened
	    toggleable: true
 	 }
});

$('.productPart').infinitescroll({
 
    navSelector  : ".pagination",            
                   // selector for the paged navigation (it will be hidden)
    nextSelector : ".pagination a:first",    
                   // selector for the NEXT link (to page 2)
    itemSelector : ".productbox"    
                   // selector for all items you'll retrieve
 });

	

$('.prodName a').dotdotdot();

function dosearch() {
	var sf=document.searchform;
	for (i=sf.siteSearch.length-1; i > -1; i--) {
		if (sf.siteSearch[i].checked) {
			var submitto = sf.siteSearch[i].value + escape(sf.query.value);
		}
	}
	var word = escape(sf.query.value);
	if(submitto === undefined){
		submitto = '/become/q?query=' + word;
	}
	console.log(submitto);
	window.location.href = submitto;
	return false;
	}
function dosearchDecido() {
	var sf=document.searchform;
	for (i=sf.siteSearch.length-1; i > -1; i--) {
		if (sf.siteSearch[i].checked) {
			var submitto = sf.siteSearch[i].value + escape(sf.query.value);
		}
	}
	var word = escape(sf.query.value);
	if(submitto === undefined){
		submitto = '/decido/q?query=' + word;
	}
	console.log(submitto);
	window.location.href = submitto;
	return false;
	}
