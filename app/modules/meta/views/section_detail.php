<p class="breadcrumbs">
	<a href="<?= miniMVC\site_url('') ?>">Genres</a> >
	<a href="<?= miniMVC\site_url('genres/detail/'.$p['genre_id']) ?>"><?= $p['genre'] ?></a> >
	<a href="<?= miniMVC\site_url('category/detail/'.$p['category_id']) ?>"><?= $p['category'] ?></a> >
	<?= $section ?>
</p>

<form class="add" action="<?= miniMVC\site_url("section/add_data") ?>" method="post">
	<fieldset>
		<legend>Add Data</legend>
		<dl>
			<!-- Weird tag wrapping is intentional for display: inline-block -->
			<dt><label for="name">Name:</label></dt><dd>
				<input type="text" name="name[]" id="section" /></dd>

			<dt><label for="val">Value:</label></dt><dd>
				<textarea id="input" name="val[]" rows="5" cols="40"></textarea></dd>

			<dt><input type="hidden" name="section_id" value="<?= $section_id ?>" /></dt><dd>
				<button type="submit" class="save">Save Data</button></dd>
		</dl>
	</fieldset>
</form>
<script src="<?= SCRIPT_PATH.'wysiwyg'; ?>"></script>
<script type="text/javascript">
// WYSIWYG
new TINY.editor.edit('editor',
{
	id:'input',
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
// Make sure the WYSIWYG submits the text
// This just copies the text from the WYSIWYG into the textbox
document.querySelector('form').onsubmit = function(e) {
	window.editor.toggle();
};
</script>
<h3>Data</h3>
<?php if ( ! empty($sdata)): ?>

	<?php foreach($sdata as $d_id => $d): ?>
		<?php foreach($d as $k => $v): ?>
		<?php $class = (strpos($v, "<br />") !== FALSE) ? 'multiline' : 'pair' ?>
		<dl class="<?= $class ?>">

			<dt>
				<?= $k ?>
				<span class="modify" id="data_<?=$d_id ?>">
					<button class="edit">Edit</button>
					<button class="delete">Delete</button>
				</span>
			</dt>
			<dd><?= $v ?></dd>

		</dl>
		<?php endforeach ?>
	<?php endforeach ?>

<?php endif ?>