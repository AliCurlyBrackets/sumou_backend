<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sumou' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'sTSt:1n%R07<pulKJV (tVw4Y0,F96Tdxx$igm5h,2^Vq/lIK5P[G2KNzJ<ghp8r' );
define( 'SECURE_AUTH_KEY',  '3{Cgt?h!!b3!2OFScJ3y_1$M)%n$dUnB H06XEdzvs)fhI4~p-~IJYo4h/1>F9BA' );
define( 'LOGGED_IN_KEY',    'W0?l_?nxUR6L:*I{x{vdv/4[@Gh:*IBW[+^H~?2$+t]Bs@H2`ai!qNw1!GYaentl' );
define( 'NONCE_KEY',        'U7$WY^?W4]ajh3-Z&fmo[c>XL`Iok,^nAJN*&}!m}kIaYWv{7A3lZZmB0vNnZc]=' );
define( 'AUTH_SALT',        'fc=+;jj8LRYJ@j!C4n9GMH%=JF%PKU?KS~Xl.}Bvl_W,kwgM#TVYm nmtfe$*|E!' );
define( 'SECURE_AUTH_SALT', ' <Ck|DLphU+v:zycN^,waD~]9EKg{#Vw,U3_UzKw5>h>#ih`Sw+cENc&g!_L3rgu' );
define( 'LOGGED_IN_SALT',   'c;HQePfk@bha}+Uve,UyGo7+qI)^B#w(x_wnn!qL:WPs0L)`8~?_hZUE=$F){zBv' );
define( 'NONCE_SALT',       'yi;L`o_W;$MmPk)/@HuE%OK]s LayW2-Lz;OI<}I>+I71a(cIKrnu`kb?@AmzT{I' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
