jQuery(document).ready(function() {
    let form = jQuery("#mvdb_form");
    let fname = jQuery("#mvdb_fname");
    let lname = jQuery("#mvdb_lname");
    let email = jQuery("#mvdb_email");
    let movie = jQuery("#mvdb_movie");
    let opinion = jQuery("#mvdb_opinion");
    let nonce = jQuery("#mvdb_form_security");

    form.on('submit', (e) => {
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: global.ajax_url,
            data: {
                action: 'mvdb_submit_form',
                fname: fname.val(),
                lname: lname.val(),
                email: email.val(),
                movie: movie.val(),
                opinion: opinion.val(),
                mvdb_form_security: nonce.val()
            },
            success: function (response) {
                jQuery("#mvdb_success").text(response.data.message);
                jQuery("label[id$='error']").each((i, label) => jQuery(label).text(''));
                jQuery("input[id^='mvdb'], textarea[id^='mvdb']").each((i, el) => jQuery(el).val(''));
            },
            error: function (err) {
                err.responseJSON.data.forEach((el) => {
                    jQuery(`#mvdb_${el.for}_error`).text(el.message);
                });
            }
        });
    });
});