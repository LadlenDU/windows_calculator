<?php

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

if ( ! class_exists( 'Boombox_Point_Count_Helper' ) && trait_exists( 'Boombox_Vote_Restriction_Trait' ) ) {
	/**
	 * Class Boombox_Point_Count_Helper
	 */
	class Boombox_Point_Count_Helper
	{
		use Boombox_Vote_Restriction_Trait;

		/**
		 * @return string the DB table name prefix included
		 */
		public static function get_point_total_table_name()
		{
			global $wpdb;

			return $wpdb->prefix . 'point_total';
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function pointed_up($post_id)
		{
			return static::voted(array(
				'post_id' => $post_id,
				'point' => 1
			));
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function pointed_down($post_id)
		{
			return static::voted(array(
				'post_id' => $post_id,
				'point' => -1
			));
		}

		/**
		 * @param mixed|array $values
		 *
		 * @return bool
		 */
		protected static function voted($values)
		{
			global $wpdb;
			$restriction = Boombox_Vote_Restriction::get_restriction_by_name(static::get_restriction_name());
			$settings = $restriction->get_settings();
			$db_settings = $restriction->get_db_settings();
			$where = ' 1 = 1 ';

			$values = Boombox_Vote_Restriction::prepare_values($db_settings->get_key_column_names(), $values);
			if (!$values) {
				return false;
			}
			foreach ($values as $key => $value) {
				$where .= $wpdb->prepare(' AND `%1$s` = "%2$s" ', $key, $value);
			}

			if ($settings->need_to_check_user_daily() || $settings->need_to_check_user_total()) {
				$user_id = Boombox_Vote_Restriction::get_user_id();
				if (!$user_id) {
					return false;
				}
				$where .= $wpdb->prepare(' AND `%1$s` = %2$d ', $db_settings->get_user_id_column_name(), $user_id);
			}
			if ($settings->need_to_check_ip_daily() || $settings->need_to_check_ip_total()) {
				$where .= $wpdb->prepare(' AND `%1$s` = \'%2$s\' ', $db_settings->get_ip_column_name(), Boombox_Vote_Restriction::get_ip());
			}
			if ($settings->need_to_check_session_total()) {
				$where .= $wpdb->prepare(' AND `%1$s` = %2$d ', $db_settings->get_session_column_name(), Boombox_Vote_Restriction::get_session_id());
			}

			$db_settings->get_key_column_names();
			$voted = $wpdb->get_var($wpdb->prepare('
				SELECT COUNT(*)
				FROM `%1$s`
				WHERE ' . $where . '
			', static::get_table_name()));
			return !$voted ? false : true;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function can_point_up($post_id)
		{
			if (static::is_restriction_enabled()) {
				return Boombox_Vote_Restriction::check(static::get_restriction_name(), array('post_id' => $post_id, 'point' => 1));
			}

			return true;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function can_point_down($post_id)
		{
			if (static::is_restriction_enabled()) {
				return Boombox_Vote_Restriction::check(static::get_restriction_name(), array('post_id' => $post_id, 'point' => -1));
			}

			return true;
		}

		/**
		 * @param int $post_id
		 * @param int $point
		 */
		protected static function insert_vote($post_id, $point)
		{
			global $wpdb;
			$data = array(
				'post_id' => $post_id,
				'ip_address' => Boombox_Vote_Restriction::get_ip(),
				'point' => $point,
				'session_id' => Boombox_Vote_Restriction::get_session_id()
			);
			$format = array('%d', '%s', '%d', '%s');
			$user_id = Boombox_Vote_Restriction::get_user_id();
			if ($user_id) {
				$data['user_id'] = $user_id;
				$format[] = '%d';
			}
			$wpdb->insert(static::get_table_name(), $data, $format);
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		protected static function update_point_total($post_id)
		{
			global $wpdb;

			$wpdb->delete(static::get_point_total_table_name(),
				array('post_id' => $post_id),
				array('%d')
			);

			$result = $wpdb->query($wpdb->prepare('
            INSERT INTO `%1$s` (`post_id`, `total`)
            SELECT *
            FROM (
	            SELECT `points`.`post_id`, SUM(`points`.`point`) AS `total`
				FROM `%2$s` AS `points`
				WHERE `points`.`post_id` = %3$d
				GROUP BY `points`.`post_id`
			) AS `point_total`
            ON DUPLICATE KEY UPDATE `total` = `point_total`.`total`
        ', static::get_point_total_table_name(), static::get_table_name(), $post_id));

			return (!$result) ? false : true;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function point_up($post_id)
		{
			global $wpdb;
			$status = true;
			if (static::is_restriction_enabled()) {
				$wpdb->query('LOCK TABLES ' . static::get_table_name() . ' WRITE');
				if (static::can_point_up($post_id)) {
					static::insert_vote($post_id, 1);
				} else {
					$status = false;
				}
				$wpdb->query('UNLOCK TABLES');
			} else {
				static::insert_vote($post_id, 1);
			}
			static::discard_point_down($post_id);
			static::update_point_total($post_id);

			return $status;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function point_down($post_id)
		{
			global $wpdb;
			$status = true;
			if (static::is_restriction_enabled()) {
				$wpdb->query('LOCK TABLES ' . static::get_table_name() . ' WRITE');
				if (static::can_point_down($post_id)) {
					static::insert_vote($post_id, -1);
				} else {
					$status = false;
				}
				$wpdb->query('UNLOCK TABLES');
			} else {
				static::insert_vote($post_id, -1);
			}
			static::discard_point_up($post_id);
			static::update_point_total($post_id);

			return $status;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function discard_point_up($post_id)
		{
			$status = Boombox_Vote_Restriction::discard(static::get_restriction_name(), array('post_id' => $post_id, 'point' => 1));
			static::update_point_total($post_id);
			return $status;
		}

		/**
		 * @param int $post_id
		 *
		 * @return bool
		 */
		public static function discard_point_down($post_id)
		{
			$status = Boombox_Vote_Restriction::discard(static::get_restriction_name(), array('post_id' => $post_id, 'point' => -1));
			static::update_point_total($post_id);
			return $status;
		}

		/**
		 * @param int $post_id
		 *
		 * @return int
		 */
		public static function get_post_points($post_id)
		{
			global $wpdb;
			$result = $wpdb->get_var($wpdb->prepare('
            SELECT `total`
            FROM `%1$s`
            WHERE `post_id` = %2$d
        ', static::get_point_total_table_name(), $post_id));

			return (!$result) ? 0 : intval($result);
		}

		/**
		 * Evaluates trait static fields
		 */
		public static function init()
		{
			static::$restriction_name = 'point_count';
			static::$table_name = 'points';
		}
	}
}
Boombox_Point_Count_Helper::init();