<link rel="stylesheet" href="/css/style_search_form.css">

<script src="/js/script_search_form.js"></script>

<form class="form-inline search-form" onsubmit="return false;">
    <div class="form-group">
        <input name="name" type="text" class="form-control">

        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle mode-chooser" data-toggle="dropdown">
                <span class="mode-chose">User</span><span class="caret"></span>
            </button>
            <ul class="dropdown-menu mode-options" role="menu">
                <li class="mode-option active-option"><a class="mode-option-text" href="#">User</a></li>
                <li class="mode-option"><a class="mode-option-text" href="#">Clan</a></li>
            </ul>
        </div>

        <button class="btn search-submit-button" type="submit" onclick="search(this)">Search</button>
    </div>
</form>