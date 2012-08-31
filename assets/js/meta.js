(function() {

    "use strict";

	// Show/hide forms based on use
	$_("fieldset dl").dom.hide();
	$_("fieldset legend").event.add('click', function(e){
		var form = $_("fieldset dl").dom;

		(form.css('display').trim() == 'none')
			? form.show()
			: form.hide();
	});

}());