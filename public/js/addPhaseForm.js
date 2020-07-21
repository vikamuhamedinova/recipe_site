var $collectionHolder1;

// setup an "add a phase" link
var $addPhaseButton = $('<button type="button" class="btn btn-success">Добавить этап</button>');

$(document).ready(function() {
    // Get the ul that holds the collection of phases
    $collectionHolder1 = $('#phase_list');

	$collectionHolder1.append($addPhaseButton);
	
	$collectionHolder1.find('.phase').each(function() {
		addPhaseRemoveButton($(this));
	});
	
	// count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder1.data('index', $collectionHolder1.find(':input').length);
	
	$addPhaseButton.click(function(e) {
		e.preventDefault();
        // add a new phase form (see next code block)
        addPhaseForm($collectionHolder1);
    }); 
});

function addPhaseForm($collectionHolder1) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder1.data('prototype');

	
    // get the new index
    var index = $collectionHolder1.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder1.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a phase" link li
    var $panel = $('<div class="row phase"></div>');
	var $panelBody = $('<div class="col-md-12"></div></div>').append(newForm);
	$panel.append($panelBody);
	addPhaseRemoveButton($panel);
	$addPhaseButton.before($panel);
}

function addPhaseRemoveButton($panel){
	var $removePhaseButton = $('<a href="#" class="btn btn-danger">Удалить</a>');
	var $panelFooter = $('<div class="panel-footer"></div>').append($removePhaseButton);
	$removePhaseButton.click(function(e) {
		e.preventDefault();
		$(e.target).parents('.phase').remove();
	});
	$panel.append($panelFooter);
}