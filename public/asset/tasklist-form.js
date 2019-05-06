function addItemFormDeleteLink($itemFormLi){
    var $removeFormButton = $('<button type="button">Effacer cette element</button>');
    $itemFormLi.append($removeFormButton);
    $removeFormButton.on('click', function(e){
        $itemFormLi.remove();
    });
}

function addItemForm($collectionHolder, $newItemLi){
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm =newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div></div>').append(newForm);
    $newItemLi.before($newFormLi);
    addItemFormDeleteLink($newFormLi);
}

$(document).ready(function(){
    console.log('JQUERY READY');

    var $collectionHolder;
    var $additemButton = $('<button type ="button" class="add_item_link">Add a item</button>');
    var $newItemLi = $('<div></div>').append($additemButton);

    $collectionHolder = $('#tasklist_listitems');
    $collectionHolder.append($newItemLi);
    $collectionHolder.find('.listitem').each(function(){
        addItemFormDeleteLink($(this));
    });
    $collectionHolder.data('index', $collectionHolder.find('.listitem').length);
    $additemButton.on('click', function(e){
        addItemForm($collectionHolder, $newItemLi);
    });
});
