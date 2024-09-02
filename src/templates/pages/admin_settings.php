<?php

namespace WPLinkSocial\templates;

use const WPLinkSocial\PLUGIN_PREFIX;

?>

<div class="wrap">
    <h1>Social Links Settings</h1>

    <form method='POST' action="options.php">
        <?php
        settings_fields(PLUGIN_PREFIX);
        do_settings_sections(PLUGIN_PREFIX);
        submit_button();
        ?>
    </form>
</div>
