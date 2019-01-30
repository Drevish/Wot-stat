// make current active tank info panel invisible
// make info panel that corresponds to the clicked tank row active
function tanksTableRowClick(e) {
    // e is the target row

    // not a tank info panel
    if ($(e).attr("id") === undefined) return;

    let tank_id = $(e).attr("id").substr(4);

    // hiding current info panel
    $('.tank-info-panel.active').removeClass("active");

    // showing new info panel
    $('#info-' + tank_id).addClass("active");
}