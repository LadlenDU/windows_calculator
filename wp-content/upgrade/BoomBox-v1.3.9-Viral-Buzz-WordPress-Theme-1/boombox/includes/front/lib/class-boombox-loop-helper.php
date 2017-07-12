<?php

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


if ( ! class_exists( 'Boombox_Loop_Helper' ) ) {
	/**
	 * Class for adv and newsletter injection into archive and page listings
	 */
	class Boombox_Loop_Helper {
		protected static $loop_index = 1;
		protected static $current_page = 1;
		protected static $skip = false;

		protected static $instead_adv;
		protected static $instead_newsletter;

		protected static function set_instead( $instead_adv, $instead_newsletter ) {
			static::$instead_adv = $instead_adv;
			// show the newsletter after the adv if their positions are the same
			static::$instead_newsletter = $instead_newsletter + (int) ( $instead_newsletter == $instead_adv );
		}

		protected static $is_adv_enabled = false;
		protected static $is_newsletter_enabled = false;

		protected static function set_injection_enabled( $is_adv_enabled, $is_newsletter_enabled ) {
			if ( (bool) $is_adv_enabled ) {
				static::$is_adv_enabled = true;
			}
			if ( (bool) $is_newsletter_enabled ) {
				static::$is_newsletter_enabled = true;
			}
		}

		protected static $adv_position = - 1;
		protected static $newsletter_position = - 1;

		protected static function set_page_positions( $posts_per_page ) {
			if ( static::$is_adv_enabled ) {
				if ( - 1 == $posts_per_page ) {
					static::$adv_position = static::$instead_adv;
				} else if ( 0 < $posts_per_page ) {
					static::$adv_position = ( static::$instead_adv + $posts_per_page ) % $posts_per_page;
					if ( 0 === static::$adv_position ) {
						static::$adv_position = $posts_per_page;
					}
				}
			}
			if ( static::$is_newsletter_enabled ) {
				if ( - 1 == $posts_per_page ) {
					static::$newsletter_position = static::$instead_newsletter;
				} else if ( 0 < $posts_per_page ) {
					static::$newsletter_position = ( static::$instead_newsletter + $posts_per_page ) % $posts_per_page;
					if ( 0 === static::$newsletter_position ) {
						static::$newsletter_position = $posts_per_page;
					}
				}
			}
		}

		protected static $adv_page;
		protected static $newsletter_page;

		protected static function init_pages( $posts_per_page ) {
			if ( ! static::$is_adv_enabled && ! static::$is_newsletter_enabled ) {
				return;
			}

			if ( static::$is_adv_enabled ) {
				if ( -1 == $posts_per_page ) {
					static::$adv_page = 1;
				} else if ( 0 < $posts_per_page ) {
					static::$adv_page = ceil( static::$instead_adv / (float) $posts_per_page );
				}
			}
			if ( static::$is_newsletter_enabled ) {
				if ( - 1 == $posts_per_page ) {
					static::$newsletter_page = 1;
				} else if ( 0 < $posts_per_page ) {
					static::$newsletter_page = ceil( static::$instead_newsletter / (float) $posts_per_page );
				}
			}
		}

		protected static $offset;

		protected static function init_offset( $posts_per_page, $offset ) {
			if ( - 1 == $posts_per_page ) {
				if ( ! $offset ) {
					$offset = 0;
				}
			} else if ( 0 < $posts_per_page ) {
				if ( ! $offset ) {
					$offset = ( static::$current_page - 1 ) * $posts_per_page;
				}
				if ( static::$skip ) {
					if ( static::$is_adv_enabled && static::$adv_page < static::$current_page ) {
						-- $offset;
					}
					if ( static::$is_newsletter_enabled && static::$newsletter_page < static::$current_page ) {
						-- $offset;
					}
				}
			}

			static::$offset = $offset;
		}

		public static function get_offset() {
			return static::$offset;
		}

		public static function init( $is_adv_enabled = false, $instead_adv = 1, $is_newsletter_enabled = false, $instead_newsletter = 1, $skip = false, $posts_per_page = - 1, $page = 1, $offset = false ) {
			$posts_per_page       = intval( $posts_per_page ) ? intval( $posts_per_page ) : 1;
			$offset               = absint( $offset ) ? absint( $offset ) : false;
			static::$current_page = absint( $page ) ? absint( $page ) : 1;
			static::$skip         = (bool) $skip;
			static::set_instead( $instead_adv, $instead_newsletter );
			static::set_injection_enabled( (bool) $is_adv_enabled, (bool) $is_newsletter_enabled );
			static::set_page_positions( $posts_per_page );
			static::init_pages( $posts_per_page );
			static::init_offset( $posts_per_page, $offset );
		}

		public static function prepare_query_for_pagination( $wp_query ) {
			if( static::$instead_adv > $wp_query->found_posts ){
				static::$is_adv_enabled = false;
			}
			if( static::$instead_newsletter > $wp_query->found_posts ){
				static::$is_newsletter_enabled = false;
			}

			$additional_offset = (int) static::$is_adv_enabled + (int) static::$is_newsletter_enabled;

			if ( 0 < $additional_offset ) {

				$wp_query->found_posts += $additional_offset;

				$posts_per_page = $wp_query->get( 'posts_per_page' );
				if ( static::$skip && 0 < $posts_per_page ) {
					$wp_query->max_num_pages = ceil( $wp_query->found_posts / $posts_per_page );
				}

			}
		}

		protected static function is_time_for_adv() {
			return static::$is_adv_enabled &&
			       static::$adv_page == static::$current_page &&
			       static::$adv_position == static::$loop_index;
		}

		protected static function is_time_for_newsletter() {
			return static::$is_newsletter_enabled &&
			       static::$newsletter_page == static::$current_page &&
			       static::$newsletter_position == static::$loop_index;
		}

		public static function have_posts() {
			global $wp_query;
			$posts_per_page = $wp_query->get( 'posts_per_page' );

			// skip the last post
			if ( static::$skip && $posts_per_page < static::$loop_index && -1 != $posts_per_page ) {
				return false;
			}

			// if it's the time to show the adv then we have something to show
			if ( static::is_time_for_adv() || static::is_time_for_newsletter() ) {
				return true;
			}

			// as default
			return have_posts();
		}

		public static function the_post() {
			$is_adv        = false;
			$is_newsletter = false;
			if ( static::is_time_for_adv() ) {
				$is_adv = true;
			} elseif ( static::is_time_for_newsletter() ) {
				$is_newsletter = true;
			} else {
				the_post();
			}

			++ static::$loop_index;

			return array(
				'is_inject'     => $is_adv || $is_newsletter,
				'is_adv'        => $is_adv,
				'is_newsletter' => $is_newsletter
			);
		}
	}
}