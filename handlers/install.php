<?php

$this->require_admin ();

$page->layout = 'admin';

$cur = $this->installed ('comments', $appconf['Admin']['version']);

if ($cur === true) {
	$page->title = 'Already installed';
	echo '<p><a href="/">Home</a></p>';
	return;
} elseif ($cur !== false) {
	header ('Location: /' . $appconf['Admin']['upgrade']);
	exit;
}

$page->title = 'Installing app: comments';

if (ELEFANT_VERSION < '1.1.0') {
	$driver = conf ('Database', 'driver');
} else {
	$conn = conf ('Database', 'master');
	$driver = $conn['driver'];
}

$error = false;
$sqldata = sql_split (file_get_contents ('apps/comments/conf/install_' . $driver . '.sql'));
foreach ($sqldata as $sql) {
	if (! db_execute ($sql)) {
		$error = db_error ();
		echo '<p class="notice">Error: ' . db_error () . '</p>';
		break;
	}
}

if ($error) {
	echo '<p class="notice">Error: ' . $error . '</p>';
	echo '<p>Install failed.</p>';
	return;
}

echo '<p>Done.</p>';

$this->mark_installed ('comments', $appconf['Admin']['version']);

?>