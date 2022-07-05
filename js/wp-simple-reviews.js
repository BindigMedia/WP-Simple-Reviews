jQuery(document).ready(function(){
    initToggle();
});


// Init Toggle
function initToggle() {
    // Toggle Legal Notice
    jQuery(document).on('click', '.reviews-legal-trigger', function() {
        jQuery('.reviews-legal').addClass('show');
    });

    // Toggle Legal Notice
    jQuery(document).on('click', '.reviews-legal.show', function() {
        jQuery('.reviews-legal').removeClass('show');
    });

}

jQuery('.starrr').starrr({
    emptyClass: 'wpsr-icon-star gray',
    fullClass: 'wpsr-icon-star',
    change: function(e, value){
        jQuery('#rating_value').val(value)
    }
});
