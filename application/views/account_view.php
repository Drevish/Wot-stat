<?php
    $user_id = $data->user_id;
    $stats = $data->$user_id->statistics;
?>

<div class="account">
    <div class="container">



        <div class="row top-row">
            <div class="col-lg-10">

                <div class="nickname">
                    <?= $data->$user_id->nickname ?>
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
                        <div class="clan-tag">[<?= $data->clan_info->tag ?>]</div>
                        <div class="clan-name"><?= $data->clan_info->name ?></div>
                    </div>

                </div>
            </div>
            <?php endif; ?>

        </div>



        <div class="row main-statistics">
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
                            <?= $stats->all->hits_percents ?>
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
</div>
