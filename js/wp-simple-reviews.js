jQuery('.starrr').starrr({
    emptyClass: 'wpsr-icon-star gray',
    fullClass: 'wpsr-icon-star',
    change: function(e, value){
        jQuery('#rating_value').val(value)
    }
})