<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'C#k=nZynEX:Ef;p{##2skoqtgmnGii^Ug2qQXj)[ZS`Z(.&`d2&oFE!~!GjB#mO5' );
define( 'SECURE_AUTH_KEY',   'e_}TLHw]X%[deT0)mywmeh5xYA]1.HdjFZWUwKAo5r5S5.>OhRxc<Pw~_D}Yq)WI' );
define( 'LOGGED_IN_KEY',     'UoZE`;AQTD>`:nqEd#FBJ8uT[@[0E.NGgkta9Ir|z>vE!Ere+F@pDd*H)m:5kr;2' );
define( 'NONCE_KEY',         '=cV2)j=6l>|U+9T@%kK{!=lt0rM.)h~KpOCAMkM0-W6BshAT1qT(w&mQa>eQnE>z' );
define( 'AUTH_SALT',         'zAHqHyRO5{gPAa|]-TF7ysz~,rHD@MMOKhXR5,6?uma[4ZP<,P^,D#42Jl_g.+0s' );
define( 'SECURE_AUTH_SALT',  '/E{~pR158>t9u$e!+K~_bB97isZy[mPhW^InSds.:D`X+,86Qxh${%kL+h>&,l71' );
define( 'LOGGED_IN_SALT',    '4Ak|gXl8g=WV,+-`GXu!W^c)j&9M>GdVVLDDUXEt$(K~u<O(i.UDC*}_g_.6y@49' );
define( 'NONCE_SALT',        'XBFMIL4J]Z}_{kK}IIgS46L)HafZ.7Q`r(};~=j*Vj>lsxJ&J@^~q1CCXB[k_>vI' );
define( 'WP_CACHE_KEY_SALT', '2JA=2Iluy):$p]DC^Paaee2Y])8bj;lw{5_u:^&OpDMvy}@ms&/r=%^~)Z^]sv<A' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
