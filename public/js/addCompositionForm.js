var $collectionHolder;

// setup an "add a composition" link
var $addCompositionButton = $('<button type="button" class="btn btn-success">Добавить ингредиент</button>');

$(document).ready(function() {
    // Get the div that holds the collection of compositions
    $collectionHolder = $('#composition_list');

	$collectionHolder.append($addCompositionButton);
	
	$collectionHolder.find('.composition').each(function() {
		addRemoveButton($(this));
	});
	
	// count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
	
	$addCompositionButton.click(function(e) {
		e.preventDefault();
        // add a new composition form (see next code block)
        addCompositionForm($collectionHolder);
    }); 

});

function addCompositionForm($collectionHolder) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

	
    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
	console.log(newForm);
    // Display the form in the page in an li, before the "Add a phase" link li
    var $panel = $('<div class="row composition"></div>').append(newForm);
	addRemoveButton($panel);
	$addCompositionButton.before($panel);
}

function addRemoveButton($panel){
	var $removeButton = $('<a href="#" class="btn btn-danger">Удалить</a>');
	var $panelFooter = $('<div class="col-md-2 my-4"></div>').append($removeButton);
	$removeButton.click(function(e) {
		e.preventDefault();
		$(e.target).parents('.composition').remove();
	});
	$panel.append($panelFooter);
}