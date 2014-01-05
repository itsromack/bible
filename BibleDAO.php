<?php
class BibleDAO {
	public static function getChapterNumbers($book_id) {
		global $db;
		$sql = "SELECT MAX(chapter_number) AS chapter_numbers
				FROM kjv_english
				WHERE book_id = {$book_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['chapter_numbers'];
		} else {
			return false;
		}
	}

	public static function getVerseNumbers($book_id, $chapter_id) {
		global $db;
		$sql = "SELECT MAX(verse_number) AS verse_numbers
				FROM kjv_english
				WHERE book_id = {$book_id}
					AND chapter_number = {$chapter_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['verse_numbers'];
		} else {
			return false;
		}
	}

	public static function getVerseText($book_id, $chapter_id, $verse_id) {
		global $db;
		$sql = "SELECT verse_text
				FROM kjv_english
				WHERE book_id = {$book_id}
					AND chapter_number = {$chapter_id}
					AND verse_number = {$verse_id};";
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row['verse_text'];
		} else {
			return false;
		}
	}

	public static function getChapterText($book_id, $chapter_id) {
		global $db;
	}

	public static function search($keyword) {
		global $db;
		if (empty($keyword)) {
			return false;
		}
		$sql = "SELECT b.book_name, v.chapter_number, v.verse_number, v.verse_text
				FROM kjv_english v
				JOIN books b ON (b.id = v.book_id)
				WHERE verse_text LIKE '%{$keyword}%';";
		$result = $db->query($sql);
		if ($result) {
			$verses = array();
			for ($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				$verses[] = array(
					'book_name' => $row['book_name'],
					'chapter_number' => $row['chapter_number'],
					'verse_number' => $row['verse_number'],
					'verse_text' => $row['verse_text']
					);
			}
			$result->free();
			return $verses;
		} else {
			return false;
		}
	}

	public static function getBooks() {
		global $db;
		$sql = "SELECT id, book_name FROM books ORDER BY id";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$books = array();
			for ($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				$books[$row['id']] = $row['book_name'];
			}
			$result->free();
			return $books;
		} else {
			return false;
		}
	}
}