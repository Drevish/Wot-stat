<?php
    $user_id = $data->user_id;
    $stats = $data->$user_id->statistics;

/**
 * @param $number number from 1 to 10
 * @return string number in roman numerals
 */
    function numberToRoman($number) {
        $map = [
                1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VII',
            9 => 'IX',
            10 => 'X',
        ];

        return $map[$number];
    }
?>

<link rel="stylesheet" href="/css/style_account_view.css">

<div class="account">
    <div class="container">



        <div class="row top-row">
            <div class="col-lg-10">

                <div class="nickname">
                    <a class="nickname-link" href="<?= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>">
                        <?= $data->$user_id->nickname ?>
                    </a>
                </div>

                <div class="registration-date info">
                    <span class="main-text">
                        Registration date:
                        <?= date('d.m.Y', $data->$user_id->created_at) ?>
                    </span>
                    <span class="secondary-text">
                        <?php
                        $time_now = new DateTime();
                        $registration_date = (new DateTime())->setTimestamp($data->$user_id->created_at);
                        $time_difference = $time_now->diff($registration_date);

                        $format_string = '(';
                        if($time_difference->y > 0)
                            $format_string .= '%y years';
                        if($time_difference->m > 0)
                            $format_string .= ', %m months';
                        if($time_difference->d > 0)
                            $format_string .= ' and %d days';
                        $format_string .= ')';

                        if ($format_string != '()')
                        echo $time_difference->format($format_string);
                        ?>
                    </span>
                </div>

                <div class="lass-battle-date info">
                    <span class="main-text"></span>
                        Last battle time:
                        <?= date('d.m.Y H:i', $data->$user_id->last_battle_time) ?>
                        GMT
                    <span class="secondary-text">
                        <?php
                        $time_difference= time() - $data->$user_id->last_battle_time;
                        $days = floor($time_difference / 60 / 60 / 24);

                        if ($days > 0) {
                            echo "($days days ago)";
                        } else {
                            $hours = floor($time_difference / 60 / 60);
                            echo "($hours hours ago)";
                        }
                        ?>
                    </span>
                </div>

            </div>


            <?php if($data->$user_id->clan_id != null) : ?>
            <div class="col-lg-12 clan-info container-fluid">
                <div class="row">

                    <div class="clan-icon col-lg-1">
                        <img src="https://ru.wargaming.net/clans/media/clans/emblems/cl_<?=
                            substr($data->clan_info->clan_id, strlen($data->clan_info->clan_id) - 3)?>/<?=
                        $data->clan_info->clan_id?>/emblem_64x64.png" alt="">
                    </div>

                    <div class="col-lg-11">
                        <div class="clan-tag">[<b><?= $data->clan_info->tag ?></b>]</div>
                        <div class="clan-name"><?= $data->clan_info->name ?></div>
                    </div>

                </div>
            </div>
            <?php endif; ?>

        </div>



        <div class="row account-info">


            <div class="col-lg-2 col-lg-offset-1">
                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= number_format($stats->all->battles, '0', '.', ' ') ?>
                    </div>
                    <div class="account-info-field-description">
                        Battles
                    </div>
                </div>

                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= number_format( $stats->all->hits / $stats->all->shots * 100, '2', '.', ' ')  ?>%
                    </div>
                    <div class="account-info-field-description">
                        Hits precision
                    </div>
                </div>
            </div>


            <div class="col-lg-2">
                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= number_format($stats->all->wins / $stats->all->battles * 100, 2) ?>%
                    </div>
                    <div class="account-info-field-description">
                        Victories
                    </div>
                </div>

                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= number_format($stats->all->damage_dealt / $stats->all->battles, 0, '.', ' ') ?>
                    </div>
                    <div class="account-info-field-description">
                        Average damage per battle
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="account-info-field-big">
                    <div class="account-info-field-big-image">
                        <img src="/images/WorldOfTanks.ico"  class = "img-responsive">
                    </div>
                    <div class="account-info-field-big-data">
                        <?= number_format($data->$user_id->global_rating, '0', '.', ' ') ?>
                    </div>
                    <div class="account-info-field-big-description">
                    Global rating
                </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= $stats->all->battle_avg_xp ?>
                    </div>
                    <div class="account-info-field-description">
                        Average experience per battle
                    </div>
                </div>

                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= $stats->all->max_frags ?>
                    </div>
                    <div class="account-info-field-description">
                        Maximum frags
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="account-info-field">
                    <div class="account-info-field-data">
                        <?= number_format($stats->all->max_xp, '0', '.', ' ') ?>
                    </div>
                    <div class="account-info-field-description">
                        Maximum experience
                    </div>
                </div>
            </div>
        </div>



        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#summary">Summary</a>
            </li>
            <li><a data-toggle="tab" href="#tanks">Tanks</a></li>
        </ul>




        <div class="tab-content">
            <div id="summary" class="tab-pane fade in active">
                <div class="row main-statistics" id="summary">
                    <div class="col-lg-12">


                        <div class="container-fluid main-statistics-container">

                            <div class="row main-statistics-row">
                                <div class="col-lg-12 main-statistics-caption">
                                    Global statistics
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Battles count</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->battles, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->wins / $stats->all->battles * 100, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Battle experience</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->xp, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg"> <?= $stats->all->battle_avg_xp ?> </div>
                            </div>

                        </div>


                        <div class="container-fluid main-statistics-container">

                            <div class="row main-statistics-row">
                                <div class="col-lg-12 main-statistics-caption">
                                    Battle efficiency
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Frags</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->frags, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->frags / $stats->all->battles, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Spotted</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->spotted, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->spotted / $stats->all->battles, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Base defence points</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->dropped_capture_points, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->dropped_capture_points / $stats->all->battles, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Base capture points</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->capture_points, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->capture_points / $stats->all->battles, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Damage dealt</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->damage_dealt, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format($stats->all->damage_dealt / $stats->all->battles, 2, '.', '') ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Hits precision</div>
                                <div class="col-lg-3 main-statistics-total">
                                    <?= number_format($stats->all->hits, '0', '.', ' ') ?>
                                </div>
                                <div class="col-lg-3 main-statistics-avg">
                                    <?= number_format( $stats->all->hits / $stats->all->shots * 100, '2', '.', ' ')  ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Surviving coefficient</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= number_format($stats->all->survived_battles / $stats->all->battles, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Destroying coefficient</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= number_format($stats->all->frags /
                                        ($stats->all->battles - $stats->all->survived_battles), 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Dealt/received damage coefficient</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= number_format($stats->all->damage_dealt / $stats->all->damage_received, 2) ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Tanking factor</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= $stats->all->tanking_factor ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Battles per day</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?php
                                    $time_difference= time() - $data->$user_id->created_at;
                                    $days = floor($time_difference / 60 / 60 / 24);
                                    echo floor($stats->all->battles / $days);
                                    ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Maximum experience per battle</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= $stats->all->max_xp ?>
                                </div>
                            </div>

                            <div class="row main-statistics-row">
                                <div class="col-lg-6 main-statistics-row-name">Maximum damage per battle</div>
                                <div class="col-lg-3 col-lg-offset-3 main-statistics-avg">
                                    <?= $stats->all->max_damage ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <?php
                // tanks array
                $tanks = $data->tanks;

                // tanks database
                $tanksDb = $data->tanksDatabase;
            ?>
            <div id="tanks" class="tab-pane fade">
                <table id="tanksTable" class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Nation</th>
                            <th>I-X</th>
                            <th></th>
                            <th>Name</th>
                            <th>Battles</th>
                            <th>Victories</th>
                            <th>Avg. exp.</th>
                            <th>Mastery</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($tanks as $tank) {
                        $tank_id = $tank->tank_id;
                        $tankInfo = $tanksDb->$tank_id;

                        // no such tank
                        if (is_null($tankInfo)) continue;

                        // no random battles
                        if ($tank->all->battles == '0') continue
                        ?>

                        <tr>
                            <td>
                                <div class="nation-image-wrapper">
                                    <div class="nation-image">
                                        <img src="/images/nation/<?= $tankInfo->nation ?>.png" alt="">
                                    </div>
                                </div>
                            </td>
                            <td class="td-text"><?= numberToRoman($tankInfo->tier) ?></td>
                            <td class="td-tank-image">
                                <div class="tank-image-wrapper">
                                    <img class="tank-image" src="<?= $tankInfo->images->big_icon ?>" alt="">
                                </div>
                            </td>
                            <td class="td-text"><?= $tankInfo->short_name ?></td>
                            <td class="td-text"><?= $tank->all->battles ?></td>
                            <td class="td-text">
                                <?= number_format($tank->all->wins / $tank->all->battles * 100, '0') ?>%
                            </td>
                            <td class="td-text"><?= $tank->all->battle_avg_xp ?></td>
                            <td>
                                <?php if ($tank->mark_of_mastery != '0'): ?>
                                <div class="mark-of-mastery-image-wrapper">
                                    <img class="mark-of-mastery-image"
                                         src="/images/achievements/markOfMastery<?= $tank->mark_of_mastery ?>.png" alt="">
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- JQuery datatables -->

        <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function () {
                $('#tanksTable').DataTable();
            });
        </script>

    </div>
</div>
