/**
 * Extends kis-js to allow centering of absolutely-positioned containers
 */
$_.ext('center', function (sel){
	sel = this.el;

	if (typeof sel === "undefined") return;

	var contHeight,
		contWidth,
		xOffset,
		inH,
		inW,
		top,
		left;

	contHeight = (typeof sel.outerHeight !== "undefined")
		? sel.outerHeight
		: sel.offsetHeight;

	contWidth = (typeof sel.outerWidth !== "undefined")
		? sel.outerWidth
		: sel.offsetWidth;

	xOffset = (typeof window.pageXOffset !== "undefined")
		? window.pageXOffset
		: document.documentElement.scrollLeft;

	inH = (window.innerHeight)
		? window.innerHeight
		: document.documentElement.offsetHeight;

	inW = (window.innerWidth)
		? window.innerWidth
		: document.documentElement.offsetWidth;

	sel.style.position = "fixed";
	top = (inH - contHeight) / 2;
	left = (inW - contWidth) / 2 + xOffset;

	if (sel.style.posTop)
	{
		sel.style.posTop = top + "px";
	}
	else
	{
		sel.style.top = top + "px";
	}

	sel.style.left = left + "px";
});

(function() {

    "use strict";

    var TINY = window.TINY || {};
    var $_ = window.$_ || {};

	// ! Show/hide forms based on use
	$_("fieldset dl").dom.hide();
	$_("fieldset legend").event.add('click', function(e){
		var form = $_("fieldset dl").dom;

		(form.css('display').trim() == 'none')
			? form.show()
			: form.hide();
	});

	var meta = {};
	window.meta = meta;

	/**
	 * Deletes a genre/category/section/data item
	 * based on the current page context
	 */
	meta.delete_item = function(e) {
		var item_id, id, type;

		// Get the type/id of the item
		item_id = this.parentNode.id;
		item_id = item_id.split('_');

		id = item_id[1];
		type = item_id[0];

		// Confirm deletion
		var confirm_string = "Are you sure you want to delete this "+type+"? Deleting this item will delete all items under it. There is no undo.";

		var do_delete = confirm(confirm_string);

		var status = false;

		if (do_delete)
		{
			// Call the appropriate deletion method
			switch(type)
			{
				case "genre":
				case "category":
				case "section":
				case "data":
					$_.post(APP_URL+'delete', {'id':id, 'type':type}, function(res){
						if (res == 1)
						{
							// Reload the page
							window.location = window.location;
						}
						else
						{
							$_.get(APP_URL+'message', {
								type: 'error',
								message: 'There was an error deleting that item'
							}, function(h) {
								$_('body').dom.prepend(h);
							});
						}
					});
				break;

				default:
				break;
			}
		}
	};

	/**
	 * Gets the edit form and displays the overlay for the item
	 * being edited
	 */
	meta.get_edit_form = function(e) {
		var item_id, id, type;

		// Get the type/id of the item
		item_id = this.parentNode.id;
		item_id = item_id.split('_');

		id = item_id[1];
		type = item_id[0];

		$_('#overlay_bg, #overlay').dom.show();

		//Get the form for the current item
		$_.get(APP_URL+'edit', {'id':id, 'type':type}, function(res){
			$_('#overlay').dom.html(res);

			// Center the form
			$_('#overlay').center();

			if (type == 'data')
			{
				// WYSIWYG
				new TINY.editor.edit('edit_wysiwyg',
				{
					id:'val',
					width:450,
					height:175,
					cssclass:'te',
					controlclass:'tecontrol',
					rowclass:'teheader',
					dividerclass:'tedivider',
					controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
						'orderedlist','unorderedlist','|','leftalign',
						'centeralign','rightalign','blockjustify','|','unformat','n','undo','redo','|',
						'image','hr','link','unlink','|'],
					footer:true,
					fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
					xhtml:true,
					cssfile:ASSET_URL+'css.php/g/css',
					bodyid:'editor',
					footerclass:'tefooter',
					toggle:{text:'source',activetext:'wysiwyg',cssclass:'toggle'},
					resize:{cssclass:'resize'}
				});
			}
		});
	};

	/**
	 * Submit the update form via javascript
	 */
	meta.update_item = function(e) {
		var id, type, name, val, txt, data={};

		// Update textarea from WYSIWYG
		if (window.edit_wysiwyg)
		{
			window.edit_wysiwyg.toggle();
		}

		// Get the form values
		data.id = $_.$('#id').value;
		data.type = $_.$('#type').value;
		data.name = $_.$('#name').value;
		txt = document.getElementById('val');
		if (txt)
		{
			data.val = txt.value;
		}

		// Submit the form
		$_.post(APP_URL+'update', data, function(res) {

			// Hide the overlay and form
			$_('#overlay_bg').dom.css('display', '');
			$_('#overlay').dom.html('');
			$_('#overlay').dom.hide();

			// Show the appropriate status message
			if (res == 1)
			{
				// Reload the page
				window.location = window.location;
			}
			else
			{
				$_.get(APP_URL+'message', {
					type: 'error',
					message: 'There was an error updating that item.'
				}, function(h) {
					$_('body').dom.prepend(h);
				});
			}

		});
	};

	// -------------------------------------------------
	// ! Event binding
	// -------------------------------------------------

	// Delete Button functionality
	$_("button.delete").event.add('click', meta.delete_item);

	// Edit Button functionality
	$_("button.edit").event.add('click', meta.get_edit_form);

	// Overlay close
	$_("#overlay_bg").event.add('click', function(e) {
		$_('#overlay_bg').dom.css('display', '');
		$_('#overlay').dom.html('');
		$_('#overlay').dom.hide();
	});

	// Edit form submission
	$_.event.live('#edit_form', 'submit', meta.update_item);

}());