function userSearch(element) {
    let form = element.form;
    let nickname = $(form).find('input[name="nickname"]').val();
    window.location = "/user/search/" + nickname;
}