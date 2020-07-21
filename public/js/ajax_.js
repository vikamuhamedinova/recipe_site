$(document).ready(function() {
	$('#newIngredientForm').submit(function (e) {
		console.log('submitting');
		e.preventDefault();
		
		$.ajax({
			type: 'POST',
			url: '/ingredient/',
			data: $(this).serialize(),
			async: true,
			success: function(data, status) 
			{       
				console.log('success');
                $('#ingredient_tbody').append(data.resp);
				(document.getElementById('newIngredientForm')).reset();
            },
			error : function(xhr, textStatus, errorThrown) {  
                  console.log('Ajax request failed.');  
            }
		});
		
	});
	
	$('.js-edit-button').click(function (e) {
		var url = $(this).attr('href');
		console.log('click');
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: url,
			async: true,
			success: function (data) {
				console.log('success2');
				//console.log(data);
				$('#edit_form').append(data);
				$($('#edit_form').children()[1]).attr("action", url);
				$($('#edit_form').children()[1]).submit(function (e) {
					console.log('submitting');
					e.preventDefault();
					$.ajax({
						type: "POST",
						url: url,
						data: $(this).serialize(),
						async: true,
						success: function (data) {
							console.log('success edit');
							var curid = (/^\/ingredient\/(\d)+\/edit/.exec(url))[1];
							console.log(curid);
							$(document.getElementById('tr-' + curid)).html(data.resp);
							$($('#edit_form').children()[0]).css({'display':'none'});
							$($('#edit_form').children()[1]).css({'display':'none'});
						}
						error : function(xhr, textStatus, errorThrown) {  
							console.log('Ajax request failed.');  
						}

					});
					return false;
				});
			}
		});
		return false;
	});
});