(function() {

    "use strict";

	// ! Show/hide forms based on use
	$_("fieldset dl").dom.hide();
	$_("fieldset legend").event.add('click', function(e){
		var form = $_("fieldset dl").dom;

		(form.css('display').trim() == 'none')
			? form.show()
			: form.hide();
	});

	var meta = {};

	/**
	 * Deletes a genre/category/section/data item
	 * based on the current page context
	 */
	meta.delete_item = function(e) {
		// Get the type/id of the item
		var item_id = this.parentNode.id;
		item_id = item_id.split('_');

		var id = item_id[1];
		var type = item_id[0];

		// Confirm deletion
		var confirm_string = "Are you sure you want to delete this "+type+"? Deleting this item will delete all items under it. There is no undo.";

		var do_delete = confirm(confirm_string);

		// Call the appropriate deletion method


		// Show status message
	};

	// -------------------------------------------------
	// ! Event binding
	// -------------------------------------------------

	// Delete Button functionality
	$_("button.delete").event.add('click', meta.delete_item);

	// WYSIWYG
	new TINY.editor.edit('editor',{
		id:'input',
		width:450,
		height:175,
		cssclass:'te',
		controlclass:'tecontrol',
		rowclass:'teheader',
		dividerclass:'tedivider',
		controls:['bold','italic','underline','|','subscript','superscript','|',
				  'orderedlist','unorderedlist','|','leftalign',
				  'centeralign','rightalign','|','unformat','|','undo','redo','n',
				  'image','hr','link','unlink','|','cut','copy','paste','print'],
		footer:true,
		//fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
		xhtml:true,
		cssfile:'//github.timshomepage.net/meta/assets/css.php/g/css',
		bodyid:'editor',
		footerclass:'tefooter',
		toggle:{text:'source',activetext:'wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});

}());