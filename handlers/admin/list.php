<?php

/**
 * Admin handler for listing comments by identifier.
 */

$this->require_admin ();

$page->layout = 'admin';

$page->title = __ ('Comments') . ': ' . Template::sanitize ($_GET['identifier']);

$status = isset ($_GET['status']) ? $_GET['status'] : 1;

echo $tpl->render ('comments/admin_list', array (
	'comments' => Comment::by_identifier ($_GET['identifier'], $status)
));

?>