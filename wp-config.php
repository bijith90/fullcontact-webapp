<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'fc_addressbooks' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ')OG2~bjNoo*nH$$#O#7JYBB@aIfjN-1t=YZ+$ee_:,zirx8y1-`c`PLbTx9L3X>Q' );
define( 'SECURE_AUTH_KEY',  'Qh b[ ;+ ld=|n1z5vm{`YUQk=slX5 -5|}M#xYO$S_>N%0@=Vc%gEhpM^;t)S;|' );
define( 'LOGGED_IN_KEY',    '^5|pm262n&->wVL6ZNg[(1gg(L%DE8i5KN%=Teh0gI=b- /F@+(jF}cUVx~[RxnB' );
define( 'NONCE_KEY',        '%0:bZ-&@Rb]>4**<J$Z#r2VtaL+q~#KCC|R*|G(CCXy7H&~NM.Ge/@]: df1#T;X' );
define( 'AUTH_SALT',        'LxQgPr.Vd}55DhRa8?6gBLvC/@ds<EBA)+`f1j#84|@Uv+O!-BIvO]7;@aLIg(U}' );
define( 'SECURE_AUTH_SALT', '^Vtti=~^Liv;gCWypWAMwpbOR#`C[I1e+&$Mg]5[H?2N47Gg%zF6BNc#:L:%WwwD' );
define( 'LOGGED_IN_SALT',   'v(laT597N,_(wh!%:&oLbw-o+;vs/~q6J zF>I+AY=c|h1C5+vN!.[8P,9WfbpPI' );
define( 'NONCE_SALT',       'UfTsI}BSEb|0ImXrQWq=qX@]luB+``8+?`cUTH.p`tS<M`MHr6L{*C}nIJG3w.F4' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'fcab_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
