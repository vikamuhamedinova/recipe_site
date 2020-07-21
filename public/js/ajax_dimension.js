$(document).ready(function() {
	$('#newDimensionForm').submit(function (e) {
		console.log('submitting');
		e.preventDefault();
		
		$.ajax({
			url: "{{ path('dimension_new_ajax')}}",
			type: 'POST',
			data: $(this).serialize(),
			async: true,
			success: function (data) {
				console.log('success');
				$('#dimensions_tbody').append(data.resp);
				(document.getElementById('newDimensionForm')).reset();
			}
		});
		return false;
	});
});