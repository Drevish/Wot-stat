function clanSearch(element) {
    let form = element.form;
    let nickname = $(form).find('input[name="nickname"]').val();
    window.location = "/clan/search/" + nickname;
}