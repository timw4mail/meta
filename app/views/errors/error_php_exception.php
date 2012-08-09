<div style="position:relative; margin:0.5em auto; padding:0.5em; width:95%; border:1px solid #924949; background: #f3e6e6;">
	<h4>An uncaught <?= get_class($exception) ?> was thrown.</h4>

	<p>Message:  <?= $message; ?></p>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

		<p>Backtrace: </p>
		<?php foreach($exception->getTrace() as $error): ?>

			<?php if (isset($error['file']) &&  ! stristr($error['file'], MM_SYS_PATH)): ?>
				<p style="margin-left:10px">
				File: <?= str_replace(MM_BASE_PATH, "", $error['file']) ?><br />
				Line: <?= $error['line'] ?><br />
				Function: <?= $error['function'] ?>
				</p>
			<?php endif ?>

		<?php endforeach ?></p>

	<?php endif ?>
</div>