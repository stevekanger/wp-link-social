# Theme Social Links

Dead simple plugin to add social links to your WordPress theme. A menu option is added to the wordpress admin where links to your profile can be added, removed and sorted. This is inteded for developers to use when creating themes for clients.

## Installation

Download plugin and install in your plugins folder and activate.

## Usage

There are a couple of hooks that can be used with this plugin.

### Get the links

```php
<?php do_action('wp-link-social-get') ?>
```

This hook gets the saved links information in an array. Each item in the array has the following info:

```php
{
    'key' => 'the network key'
    'url' => 'the link you provided',
    'title' => 'the network title',
    'icon' => 'the network icon class'
}
```

### Show the links

```php
<?php do_action('wp-link-social-show') ?>
```

This will output the following html code for each link you've added.

```html
<a
  href="The_link_you_provided"
  title="the_network_title"
  target="_blank"
  rel="me"
  ><span class="fab fa-facebook"></span
></a>
```

There is no css or styles added to any links. It is just a list of `<a>` tags.

The `wp-link-social-show` hook accepts an args array.

| Arg    | type     | default | description                                                                           |
| ------ | -------- | ------- | ------------------------------------------------------------------------------------- |
| before | (string) | null    | If you want content displayed before the links                                        |
| after  | (string) | null    | If you want content displayed after the links                                         |
| walker | (string) | null    | A user definded function that returns valid html. called with links array fn($links). |

### Adding wrapper elements to links

If you want to add a wrapper to the links the `wp-link-social-show` hook accepts `before` and `after` arguments in the args array:

```php
<?php do_action('wp-link-social-show', ['before' => '<div class="social-links">', 'after' => '</div>']) ?>
```

this will add a wrapper to the links like this:

```html
<div class="social-links">
  <a
    href="The_link_you_provided"
    title="the_network_title"
    target="_blank"
    rel="me"
    ><span class="fab fa-facebook"></span
  ></a>
  ...ect
</div>
```

### Creating custom walker function

You can also pass a walker function to the `wp-link-social-show` hook.

```php
<?php do_action('wp-link-social-show', ['walker' => 'theme_social_links_walker']) ?>
```

and do something like:

```php
function theme_social_links_walker($links) {
    $output = '';
    foreach ($links as $key => $link) {
        $output .= '<li><a href="' . $link['url'] . '" target="_blank" rel="noopener noreferrer">' . $link['title'] . '</a></li>';
    }
    return $output;
}
```

the walker will be called with the same array as the `wp-link-social-get` hook passes so for each link you will get

```php
{
    'key' => 'the network key'
    'url' => 'the link you provided',
    'title' => 'the network title',
    'icon' => 'the network icon class'
}
```
