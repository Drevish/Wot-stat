<link rel="stylesheet" href="/css/style_clan_search.css">

<div class="clan">
    <div class="container">

        <div class="row short-description">
            <div class="col-sm-2">
                <div class="clan-icon">
                    <img src="<?= $data->emblems->x195->portal ?>" alt="">
                </div>
            </div>

            <div class="col-sm-10">
                <div class="tag-and-name">
                    <a href="https://ru.wargaming.net/clans/wot/<?= $data->clan_id ?>/" target = "_blank">
                        <span class="tag" style="color: <?= $data->color ?>">
                            [<?= $data->tag ?>]
                        </span>
                        -
                        <span class="name"><?= $data->name ?></span>
                    </a>
                </div>

                <div class="motto">
                    <?= $data->motto ?>
                </div>

                <div class="created-at">
                    <span class="main-text">
                        Created at:
                        <?= date('d.m.Y', $data->created_at) ?>
                    </span>
                    <span class="secondary-text">
                        (<?php
                        echo floor((time() - $data->created_at) / 24 / 60 / 60);
                        ?> days)
                    </span>
                </div>

                <div class="members-count">
                    Members: <?= count($data->members) ?>
                </div>
            </div>
        </div>

        <div class="row clan-description">
            <div class="col-sm-12">
                <div class="caption">About clan</div>

                <div class="description">
                    <?= $data->description_html ?>
                </div>
            </div>
        </div>

        <div class="row clan-players">
            <div class="col-sm-12">
                <div class="caption">Players</div>

                <table id="players-table" class="table table-bordered table-striped">
                    <thead>
                    <th>№</th>
                    <th>Nickname</th>
                    <th>Post</th>
                    <th>Days</th>
                    <th>Battles</th>
                    <th>Victories</th>
                    <th>WG</th>
                    </thead>

                    <tbody></tbody>
                </table>

                <div class="table-preloader">
                    <div class="spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

                <script>
                    let members = <?= json_encode($data->members) ?>;
                </script>

            </div>
        </div>
    </div>
</div>

<script src="/js/script_clan_search.js"></script>