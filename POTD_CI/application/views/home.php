<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="/assets/css/potd.css" rel="stylesheet" media="screen">
	<title>POTD</title>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900|Lora|Geo' rel='stylesheet' type='text/css'>
	<link media="all" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		function isLetter(s)
		{
			return s.match("^[a-zA-Z]+$");
		}

		//need to fix the hint toggle so appears (toggles up) after clicking "im ready"
		//then, if you click hint it toggles up even more and theres the verse text
		//once the submission is correct and the button turns green, highlight the "NEXT button" light yellow
		//once the submission is correct, tiny little flag pops up above ticker!

		//-->LATER:
		//talk about how to do ticker count of how many verses have been done in one sitting

		var stored_words =[];
		var change_num = 0;
		var proverb = "";

		$('#first_change').click(function(){
			if(change_num == 0){
				console.log(change_num);
				proverb = $('#trial_text').text();
				var done='DONE';
				$('#ready').html(done);

				var pv_array = proverb.split(" ");
				var html=[];

				for(var i=0; i<pv_array.length; i++)
				{
					if($.trim(pv_array[i]).length < 7 || ($.trim(pv_array[i]).length == 7 && !isLetter(pv_array[i][(pv_array[i]).length-1])) )
						html.push(pv_array[i]);
					else{
						if(!isLetter(pv_array[i][(pv_array[i]).length-1])){
							var trimmed = $.trim(pv_array[i]);
							// console.log(trimmed.substring(0, trimmed.length-1));
							stored_words.push([i, trimmed.substring(0, trimmed.length-1)]);
							var sym = pv_array[i][(pv_array[i]).length-1];
							// console.log(sym);
							html.push("<input id='"+i+"' type='text' name='strings["+i+"]'>"+sym);
						}
						else{
							stored_words.push([i, $.trim(pv_array[i])]);
							html.push("<input id='"+i+"' type='text' name='strings["+i+"]'>");
						}
						// stored_words.push($.trim(pv_array[i]).replace('.',''));		
					}
				}
				console.log(stored_words);
				$('#trial_text').find('p').html(html.join(' '));
				change_num++;
			}
			else if(change_num > 0){
				$("#verse").submit();	
			}
		});

		$('#verify').click(function(){
			$('#verse').submit();
		});

		$('#verse').on('submit', function(){
			var data = $(this).serializeArray();
			var answer = [];
			for(var key in data)
			{
				// console.log(data[key]);
				answer.push(data[key].value);
			}
			success = true;
			// console.log(stored_words.length);
			for(var i=0; i<stored_words.length; i++)
			{
				if (stored_words[i][1] != answer[i])
				{
					$('#'+stored_words[i][0]).addClass("error");
					success = false;
				}
				else
				{
					$('#'+stored_words[i][0]).addClass("success");
				}					
			}
			if (success == true)
			{
				var versetext = $("#versetext");
				versetext.text(proverb).addClass("final");
				// var nexttext = $("#right_btn");
				// nexttext.addClass("yellow");
			}
			change_num++;
			return false;
		});

		$('#right_btn').click(function(){
			location.reload();
		});

		$('#hint').click(function(){
			var versetext = $("#secret");
			versetext.text(proverb);
		});

	});
	</script>
</head>

<body>
	<div id="wrapper">
		<div class="bg bg1">
			<img src="/assets/images/picshelf.png" alt="shelf1" id="picshelf_img">
		</div>	
		<div class="bg bg2">
			<img src="/assets/images/bunnyshelf.png" alt="shelf1" id="bunnyshelf_img">
		</div>	
		<div class="bg bg3">
			<img src="/assets/images/desk.png" alt="desk" id="desk_img">
		</div>
		
		<div id="container">
				<div class="middle">
					<div id="titlebox">
						<img src="/assets/images/lamp.png" alt="lamp" id="lamp_img">
						<img src="/assets/images/counter.png" alt="counter" id="counter_img">
						<div id="titlebox_con">
							<h3>Lumen</h3>
							<p id="subtitle">BITE-SIZED BIBLICAL WISDOM TO MEMORIZE</p>
						</div>
						<div id="counterbox">
							<p id="count">00</p>
						</div>
							
					</div>
					<div id="whitebox">
						<div id="whitebox_con">
							<div id="ref">
								PROVERBS <?php echo $proverb->CHAPTERNO; ?>:<?php echo $proverb->VERSENO; ?> KJV
							</div>
							<div id="trial_text">
								<form id='verse' action='' method=''>
									<p id="versetext"><?php echo $proverb->VERSETEXT; ?></p>
								</form>
							</div>	
						</div>
						<div id="show">
							<div id="hint">
							Click for a hint.
							</div>
							<div id="secret">
							</div>
						</div>
					</div>
					<div id="greybox">
						<div id="left_btn">
							<div id="first_change">
								<p id="ready">I'M READY...HIDE THE WORDS!</p>
							</div>
						</div>
						<div id="right_btn">
							<p id="skip">NEXT</p>
						</div>
						
					</div>
				</div> <!--end of middle column section -->
				<div class="row">
					<div id="footer">
						Another little project by <a href="">MaleesaMade</a>. KJV Public Domain.
					</div>
					
				</div>
				<div id="show_verse">
				</div>
		</div>
	</div>
</body>

<!-- //on view, form page takes you to controller/method that stores verse, finds>5, and takes out the spots.
//store in a session
//function checker, pulls it out of the session and checks  -->

</html>