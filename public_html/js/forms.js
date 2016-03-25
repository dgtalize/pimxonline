

// setup an "add a tag" link
//var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
//var $newLinkLi = $('<li></li>').append($addTagLink);

$(document).ready(function() {

    //no need for datepicker in Chrome
    if (navigator.userAgent.search("Chrome") < 0) {
        $('input[type="date"]').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    }
                
    $('a.add_subitem, button.add_subitem').click(function(ev) {
        // Gets the container of items
        var fieldsContainer = $(this).parent('.fields_container');

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        fieldsContainer.data('index', fieldsContainer.children('.form-group').length);

        // prevent the link from creating a "#" on the URL
        ev.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(fieldsContainer, $(this));

    });

    $(' .form-group .fields_container .form-group').each(function(){
        addTagFormDeleteLink($(this));
    });
});

function addTagForm(fieldsContainer, addButton) {
    // Get the data-prototype explained earlier
    var prototype = fieldsContainer.data('prototype');

    // get the new index
    var index = fieldsContainer.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    fieldsContainer.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    newForm = $(newForm);
    if (addButton) {
        addButton.before(newForm);
    } else {
        fieldsContainer.append(newForm);
    }
    addTagFormDeleteLink(newForm);
}

function addTagFormDeleteLink(form_row) {
    var container = $(form_row).children('.fields_container');
    
    var removeButton = $('<a class="btn btn-danger del_subitem">delete</a>');
    container.append(removeButton);

    removeButton.click(function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $(form_row).remove();
    });
}