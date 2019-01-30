$(document).ready(function () {
    // search mode chooser
    $(".mode-options .mode-option").click(function(event){
        // change mode chooser text
        $('.mode-chooser .mode-chose').text($(this).text());

        // make currently active option inactive
        $('.mode-option.active-option').removeClass('active-option');

        // if anywhere mode option is the same to chose make it active
        $('.mode-option').each(function (index) {
            if ($(this).find('.mode-option-text').text() == $('.mode-chooser .mode-chose').first().text()) {
                $(this).addClass('active-option');
            }
        });
    });
});

function search(element) {
    let form = element.form;
    let nickname = $(form).find('input[name="name"]').val();
    let searchMode = $(form).find('.mode-chose').text().toLowerCase();
    window.location = "/" + searchMode + "/search/" + nickname;
}