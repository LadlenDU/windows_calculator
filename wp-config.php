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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'temp123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '>.P)4;OveC.r|:vPgx J%|e0nZ,e^> d!^7L%pL0~Xf@!p*dPO_-(AF|6m_LlStD');
define('SECURE_AUTH_KEY',  '?M=lZE:|bC/b5}6Mp-it$h:EEXQQQt4>vYl7burR8/P~7Ip0i/{&,%HT`w.N[2@L');
define('LOGGED_IN_KEY',    'p`xx^F.]7:,B{PRsQO_VEg*Ko*@Esm*=OPXx_Q<lnjG^p;J$jf^HO>wFWAfFx;G}');
define('NONCE_KEY',        'sF+;rsY;$FBGV42:E@ja[|GM+~D&Df$%KUZ*e>6@;aeiaFf&X%E9^%vC{yVo{N:O');
define('AUTH_SALT',        'r-f pve<bIeVA~D75N^nj(BwPs5<^WTK*I^M8:$OWm1/J,6)yNKOn,1&b=6I6vKA');
define('SECURE_AUTH_SALT', 'c_@JJbT9].Y q7:CZ?]i.pnq-tM*@ti_BsBHz$D;IIg+1YM4&lpAlFT7:l+P%VmW');
define('LOGGED_IN_SALT',   'GCP1>{)C7&VQVXZb4#6|TtsC_[!M_7d)jNAr0de-uefsim`I_VFq;KhFYBuA8@_y');
define('NONCE_SALT',       '(1{N(f{uk`p0*o@Eaii)z8B,E^.s2LAfE4n;_Kzg<`h/UmI8-Ha4B[}wI`6L>`cK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
