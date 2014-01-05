$(document).ready(function() {
	function getVerseText(bid, cid, vid) {
		$.ajax({
			url: 'versetext.php',
			data: {book_id: bid, chapter_id: cid, verse_id: vid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				$('#verse_text').html(response.verse_text);
			}
		});
	}

	$('#books').on('change', function() {
		var bid = $(this).val();
		$.ajax({
			url: 'chapters.php',
			data: {book_id: bid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.chapters; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#chapters').html(str);
				getVerseText(bid, 1, 1);
			}
		});
	});

	$('#chapters').on('change', function() {
		var bid = $('#books').val();
		var cid = $(this).val();
		$.ajax({
			url: 'verses.php',
			data: {book_id: bid, chapter_id: cid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.verses; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#verses').html(str);
				getVerseText(bid, cid, 1);
			}
		});
	});

	$('#verses').on('change', function() {
		var bid = $('#books').val();
		var cid = $('#chapters').val();
		var vid = $(this).val();
		getVerseText(bid, cid, vid);
	});

	$('#search').click(function() {
		var keyword = $('#search_keyword').val();
		$.ajax({
			url: 'search.php',
			data: {keyword: keyword},
			dataType: 'JSON',
			method: 'GET',
			success: function(response){
				var str = '<strong>' + response.result.length + ' verses found</strong><br>';
				var verse;
				console.log(response.result);
				for(i = 0; i < response.result.length; i++) {
					verse = response.result[i];
					str += '<font color="blue">'
						+ verse.book_name + ' '
						+ verse.chapter_number + ':' + verse.verse_number 
						+ '</font> '
						+ '<strong>' + verse.verse_text + '</strong><br>';
				}
				$('#search_result').html(str);
			},
			error: function(err) {
				$('#search_result').html(err.message);
			}
		})
	});
});