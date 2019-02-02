$(document).ready(function () {

    /**
     * Adds a new player to the players table
     * @param index player's index (first column)
     * @param clandata data that was from clan info (initial request)
     * @param playerdata data about player that was got via ajax
     */
    function addPlayersTableRow(index, clandata, playerdata) {
        let index_ = "<td>" + (index + 1) + "</td>";
        let nickname = "<td><a href='/user/search/" + playerdata.nickname + "' target='_blank'>" +
            playerdata.nickname + "</a></td>";
        let post = "<td>" + clandata.role_i18n + "</td>";
        let days = "<td>" + Math.floor(((new Date()).getTime()/1000 - clandata.joined_at) / 24 / 60 / 60) + "</td>";
        let battles = "<td>" + playerdata.battles + "</td>";
        let victories= "<td style='color: " + playerdata.winrateColor + ";'><b>" + playerdata.victories + "</b></td>";
        let wg = "<td style='color: " + playerdata.WGcolor + ";'><b>" + playerdata.wg + "</b></td>";
        let wn8 = "<td style='color: " + playerdata.WN8color + ";'><b>" + playerdata.WN8 + "</b></td>";

        // create a new row in table
        $('table#players-table tbody').append("<tr></tr>");

        // add table data to last row which was just created
        $('table#players-table tbody tr:last-child').append(
            index_, nickname, post, days, battles, victories, wg, wn8);
    }

    // loading players info
    function loadPlayersInfo() {
        for (let i = 0; i < members.length; i++) {

            $.get("/clan/getShortUserInfo/" + members[i].account_id, function (data) {
                data = JSON.parse(data);

                addPlayersTableRow(i, members[i], data);


                if (i == members.length - 1) {
                    hideTablePreloader();
                }
            });

        }
    }

    function hideTablePreloader() {
        // table is loaded, hide table preloader
        $('.table-preloader').css("display", "none");
        console.log("hidden");
    }

    loadPlayersInfo();

});