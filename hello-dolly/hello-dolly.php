<?php
/**
 * This is a plugin that symbolizes the hope and enthusiasm of an entire
 * generation summed up in two words sung most famously by Louis Armstrong.
 *
 * @package Hello_Dolly
 * @version 1.6
 *
 * @wordpress-plugin
 * Plugin Name: Hello Dolly
 * Plugin URI: https://wordpress.org/plugins/hello-dolly/
 * Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
 * Author: Matt Mullenweg
 * Version: 1.6
 * Author URI: http://ma.tt/
 */

/**
 * Defines the lyrics for 'Hello Dolly'.
 *
 * @return string A random line of from the lyrics to the song.
 */
function hello_dolly_get_lyric()
{
    /**
 * These are the lyrics to Hello Dolly 
*/
    $lyrics = "Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
So, take her wrap, fellas
Find her an empty lap, fellas
Dolly'll never go away again
Hello, Dolly
Well, hello, Dolly
It's so nice to have you back where you belong
You're lookin' swell, Dolly
I can tell, Dolly
You're still glowin', you're still crowin'
You're still goin' strong
We feel the room swayin'
While the band's playin'
One of your old favourite songs from way back when
Golly, gee, fellas
Find her a vacant knee, fellas
Dolly'll never go away
Dolly'll never go away
Dolly'll never go away again";

    // Here we split it into lines.
    $lyrics = explode("\n", $lyrics);
 
    // And then randomly choose a line.
    return wptexturize($lyrics[ wp_rand(0, count($lyrics) - 1) ]);
}
add_action('admin_notices', 'hello_dolly');
/**
 * This just echoes the chosen line, we'll position it later. This function is
 * set up to execute when the admin_notices action is called.
 */
function hello_dolly()
{
    $chosen = hello_dolly_get_lyric();
    echo "<p id='dolly'>$chosen</p>";
}
 
add_action('admin_head', 'dolly_css');
/**
 * Add some CSS to position the paragraph.
 */
function dolly_css()
{
    /**
     *This makes sure that the positioning is also good for right-to-left languages.
     */
    $x = is_rtl() ? 'left' : 'right';
    echo "<style type='text/css'> #dolly { float: $x; padding-$x: 15px; padding-top: 5px; margin: 0; font-size: 11px; } </style> "; 
 
}
