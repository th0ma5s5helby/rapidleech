<?php
function delete() {
	global $list, $PHP_SELF;
?>
<form method="post" action="<?php echo $PHP_SELF; ?>"><input type="hidden" name="act" value="delete_go" />
<?php
	echo lang(count($_GET['files']) > 1 ? 379 : 104).':';
	foreach ($_GET['files'] as $k => $v) {
		echo '<input type="hidden" name="files[]" value="'.$v.'" /><br />';
		echo '<b>'.htmlentities(basename($list[$v]['name'])).'</b>';
	}
?>
<br />
<?php echo lang(148); ?>?
<br />
<table>
	<tr>
		<td><input type="submit" name="yes" style="width: 33px; height: 23px"
			value="<?php echo lang(149); ?>" />
		</td>
		<td>&nbsp;&nbsp;&nbsp;</td>
		<td><input type="submit" name="no" style="width: 33px; height: 23px"
			value="<?php echo lang(150); ?>" />
		</td>
	</tr>
</table>
</form>
<?php
}

function delete_go() {
	global $list, $PHP_SELF;
	if (isset($_POST["yes"])) {
		for($i = 0; $i < count ( $_POST ["files"] ); $i ++) {
			$file = $list [$_POST ["files"] [$i]];
			if (file_exists ( $file ["name"] )) {
				if (@unlink ( $file ["name"] )) {
					printf(lang(151),basename($file['name']));
					echo "<br />";
					unset ( $list [$_POST ["files"] [$i]] );
				} else {
					printf(lang(152),basename($file['name']));
					echo "<br />";
				}
			} else {
				unset ( $list [$_POST ["files"] [$i]] );
				printf(lang(145),basename($file['name']));
				echo "<br />";
			}
		}
		if (! updateListInFile ( $list )) {
			echo lang(146)."<br /><br />";
		}
	} else {
		echo('<script type="text/javascript">location.href="'.$PHP_SELF.'?act=files";</script>');
	}
}
?>