jQuery(document).ready(function() {
    let gallery;

    jQuery('#mvdb_gallery_button').click(function(e) {
        e.preventDefault();
        if(gallery){
            gallery.open();
            return;
        }

        gallery = wp.media.frames.meta_gallery_frame = wp.media({
            title: 'Odaberite slike',
            button: { text:  'Sacuvaj' },
            library: { type: 'image' },
            multiple: 'add'
        });

        gallery.on('open', function() {
            let selection = gallery.state().get('selection');
            let ids = jQuery('#mvdb_gallery').val();
            if(ids){
                let idsArray = ids.split(',');
                idsArray.forEach(function(id) {
                    let attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        });

        gallery.on('select', function() {
            let imageIDs = [];
            gallery.state().get('selection').each(function(attachment) {
                imageIDs.push(attachment.attributes.id);
            });
            let ids = imageIDs.join(",");
            if(ids){
                jQuery('#mvdb_gallery').val(ids);
            }
        });

        gallery.on('close', function() {
            let imagesHTML = '';
            gallery.state().get('selection').each(function(attachment) {
                imagesHTML += `<img src='${attachment.attributes.url}' id="mvdb_gallery_image" width="200px" height="200px"/>`;
            });
            jQuery('.mvdb_gallery_images').html(imagesHTML);
        });

        gallery.open();
    });

    // Dashboard copy shortcode to clipboard
    jQuery("input[name=mvdb_form_shortcode]").on('click', function(el){
        let $tempElement = jQuery("<input>");
        jQuery("body").append($tempElement);
        $tempElement.val(el.target.value).select();
        document.execCommand("Copy");
        $tempElement.remove();
    });
});

