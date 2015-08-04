/**
 * Extends kis-js to allow centering of absolutely-positioned containers
 */
$_.ext('center', function (sel){
	sel = this.el;

	if (typeof sel === "undefined") return;

	var contHeight,
		contWidth,
		inH,
		inW,
		top,
		left;

	contHeight = sel.offsetHeight;
	contWidth = sel.offsetWidth;

	inH = window.innerHeight;
	inW = window.innerWidth;

	sel.style.position = "fixed";
	top = (inH - contHeight) / 2;
	left = (inW - contWidth) / 2;

	sel.style.top = top + "px";
	sel.style.left = left + "px";
});

(function(w, $_) {

	"use strict";

	var TINY = w.TINY || {};
	var $_ = w.$_ || {};

	var parent_map = {
		"data":"section",
		"section":"category",
		"category":"genre",
		"genre":"genre"
	};

	// ! Show/hide forms based on use
	$_("fieldset dl").dom.hide();
	$_("fieldset legend").event.add('click', function(e){
		($_("fieldset dl").dom.css('display').trim() == 'none')
			? $_("fieldset dl").dom.show()
			: $_("fieldset dl").dom.hide();
	});

	var meta = {};
	w.meta = meta;

	/**
	 * Create the WYSIWYG editor box
	 */
	meta.initTINY = function(id) {
		// WYSIWYG
		new TINY.editor.edit('edit_wysiwyg',
		{
			id:id,
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
	},

	/**
	 * Deletes a genre/category/section/data item
	 * based on the current page context
	 */
	meta.delete_item = function(e) {
		var id, type, parent_id;

		// Get the type/id of the item
		id = this.parentNode.dataset['id'];
		type = this.parentNode.dataset.type;
		parent_id = this.parentNode.dataset.parent;

		// Confirm deletion
		var confirm_string = "Are you sure you want to delete this "+type+"? Deleting this item will delete all items under it. There is no undo.";

		var do_delete = confirm(confirm_string);

		var status = false;

		if (do_delete)
		{
			$_.post(APP_URL+'delete', {'id':id, 'type':type}, function(res){
				if (res == 1)
				{
					// Redirect to previous page
					var redir_url = APP_URL+parent_map[type]+'/detail/'+parent_id;
					w.location = (type !== 'genre')
						? redir_url
						: APP_URL;
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
		}
	};

	/**
	 * Gets the edit form and displays the overlay for the item
	 * being edited
	 */
	meta.get_edit_form = function(e) {
		var id, type;

		id = this.parentNode.dataset['id'];
		type = this.parentNode.dataset.type;

		$_('#overlay_bg, #overlay').dom.show();

		//Get the form for the current item
		$_.get(APP_URL+'edit', {'id':id, 'type':type}, function(res){
			$_('#overlay').dom.html(res);

			// Center the form
			$_('#overlay').center();

			if (type == 'data')
			{
				meta.initTINY('val');

				//Do it again, so it's correct this time!
				$_('#overlay').center();
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
				w.location = w.location;
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
		$_('#overlay_bg').dom.css('display', 'none');
		$_('#overlay').dom.html('');
		$_('#overlay').dom.hide();
	});

	// Edit form submission
	$_.event.live('#edit_form', 'submit', meta.update_item);

	// WYSIWYG on section/data pages
	if (document.getElementsByTagName('textarea').length > 0)
	{
		meta.initTINY('val');
		meta.initTINY('val2');
	}
}(window, $_));