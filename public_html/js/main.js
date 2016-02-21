$(document).ready(function() {
	$('.btn-delete').click(function(){
		return confirm('Are you sure you want to delete this element?');
	});
});