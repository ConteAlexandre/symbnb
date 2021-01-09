$('#add-image').click(function () {
    // Define index at 0 with the value of input
    const index = +$('#widgets-counter').val();

    // Recover the prototype of entries
    const tmpl = $('#ad_create_images').data('prototype').replace(/__name__/g, index);

    // Inject this code in the div
    $('#ad_create_images').append(tmpl);

    // When click on button add image incrementation with 1
    $('#widgets-counter').val(index+1);

    // Manage the delete button
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click( function () {
        const target = this.dataset.target;
        $(target).remove()
    })
}

function updateCounter() {
    const count = +$('#ad_create_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter()
handleDeleteButtons()