<?php
include_once('config.php');
include_once('BibleDAO.php');

$books = BibleDAO::getBooks();
$defaultChapters = BibleDAO::getChapterNumbers(1);
$defaultVerses = BibleDAO::getVerseNumbers(1, 1);
$defaultVerseText = BibleDAO::getVerseText(1, 1, 1);?>

Books: <select name="books" id="books">
	<?php foreach($books as $id => $book): ?>
		<option value="<?= $id ?>"><?= $book ?></option>
	<?php endforeach ?>
</select>

Chapters: <select name="chapters" id="chapters">
	<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
		<option value="<?= $i ?>"><?= $i ?></option>
	<?php endfor ?>
</select>

Verses: <select name="verses" id="verses">
	<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
		<option value="<?= $i ?>"><?= $i ?></option>
	<?php endfor ?>
</select>

<div id="verse_text">
	<?= $defaultVerseText ?>
</div>

<hr /> Search: <input type="text" id="search_keyword" name="keyword" />
<input type="button" id="search" value="Search" />
<div id="search_result"></div>
<script type="text/javascript" src="jquery.1.10.2.js"></script>
<script type="text/javascript" src="bible.js"></script>