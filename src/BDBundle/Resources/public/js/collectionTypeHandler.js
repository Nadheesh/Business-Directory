/**
 * Created by Nadheesh on 4/18/2016.
 */
function addOwnerForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<td></td>').append(newForm);
    var $abc = $('<tr></tr>').append($newFormLi)
    addTagFormDeleteLink($abc);
    $newLinkLi.before($abc);
}


function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#"><span class="glyphicon glyphicon-remove"></span></a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}