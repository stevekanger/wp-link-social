<?php

namespace WPLinkSocial\templates;

use WPLinkSocial\lib\Data;

use const WPLinkSocial\PLUGIN_PREFIX;

$current_links = get_option(PLUGIN_PREFIX . '_social_links');
?>

<div class="wrap">
    <h1>Social Links</h1>
    <h2>Add A Link</h2>
    <p class="description">
        If you add a link to an already existing network, it will replace the existing link.
    </p>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="network">Network</label>
                </th>
                <td>
                    <select name="network" id="wp-link-social-network">
                        <option value="">Select Network</option>
                        <?php foreach (Data::$supported_profile_networks as $network) : ?>
                            <option value="<?php echo $network['key'] ?>"><?php echo $network['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th><label for="url">Profile Link</label></th>
                <td>
                    <input type="text" name="url" id="wp-link-social-url" class="regular-text ltr">
                    <p class="description">eg. https://facebook.com/yourusername</p>
                </td>
            </tr>

            <tr>
            </tr>
        </tbody>
    </table>
    <button id="wp-link-social-add" class="button button-primary">Add Link</button>

    <h2>Current Links</h2>
    <p class="description">
        Your current links. <strong>Drag and drop links to reorder</strong>.
    </p>

    <div id="wp-link-social-current">
        <?php if (empty($current_links)) : ?>
            <p>There are currently no links.</p>
        <?php else : ?>
            <?php foreach ($current_links as $link) : ?>
                <div data-key="<?php echo $link['key'] ?>" data-url="<?php echo $link['url'] ?>">
                    <div><span class="<?php echo $link['icon'] ?>"></span></div>
                    <a href="<?php echo $link['url'] ?>" target="_blank"><?php echo $link['url'] ?></a>
                    <button><span class="dashicons dashicons-no"></span></button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
