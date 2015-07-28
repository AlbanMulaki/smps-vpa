<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'objprog');

/** MySQL database username */
define('DB_USER', 'objprog');

/** MySQL database password */
define('DB_PASSWORD', 'mangekyo!@#?');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'AF-qW?Ik d :u9M ,W56+]Qt`<uyO6 AnZT,G]N+)xpb<]Qx$i9*_s|n>7S!dnv@');
define('SECURE_AUTH_KEY',  '8W?9La<(r|zs[JS#/L^_Wx-|/uP`?M+5Dfmatj!e)AF=c>O>W-BAd|c_vP{<{kLQ');
define('LOGGED_IN_KEY',    'DHK.G-8XZ5GS7,y$5|^?L=9R;dB7(U&etqd+@pA*.+wpFhdXj!|I6`q+8[B~d9c4');
define('NONCE_KEY',        'IZj69zDbPC$SES77NYe]&>r|b@7jge`SF{1f~XbYk/+4~R3Z[s%mS{jS(-4N$juQ');
define('AUTH_SALT',        'hSpvap9E96$-c/^n~2Sapp8C5itC|_&EH_+GEa?tv/Pz9db,+d-gzEKss+uwLltR');
define('SECURE_AUTH_SALT', 'o&[>3``r>q>$chM[:{pQ-ePG![MtPx;|g|j@3/~+RH){BFYKI>Yam ,`Kk@*-!}k');
define('LOGGED_IN_SALT',   '{qM23-v-sn(Jt5|7`IHP^//*JEjznj:ufI[l}czpIA~D-yH?cE*LOjxOhW<Fh}Au');
define('NONCE_SALT',       'mhoY0Q%R!>.cxcM_#S`|t%0WW4l%sk;fjWs0rUJ,Uy,B|+x6|o}o@`F($D4O;]*p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
