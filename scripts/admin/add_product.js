function CKupdate() {
    for (instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
};

$(document).ready(function() {
    CKEDITOR.replace('parameter');
    CKEDITOR.replace('review_product');
    CKEDITOR.replace('feature');
})