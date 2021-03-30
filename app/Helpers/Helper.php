<?php


namespace App\Helpers;

use DB;

class Helper {


	/**
	 * wendet translation function auf jedes Wertelement eines eindim. arrays an
	 *
	 * @param $arr
	 *
	 * @return array
	 */
	public static function array_translate( $arr ) {
		return array_map( function ( $val ) {
			return __( $val );
		}, $arr );
	}

	/**
	 * data = list of rows with indices (like from db)
	 * removing keys and transforming into ordered array
	 *
	 * @param $data
	 *
	 * @return mixed
	 * @deprecated use collection helper instead
	 */
	public static function array_nokeys( $data ) {
		foreach ( $data as $i => $row ) {
			$data[ $i ] = array_values( $row );
		}

		return $data;
	}

	/**
	 * Helper Function to truncate a file to 0 length
	 *
	 * @param $full_path_to_file
	 */
	public static function truncate_file( $full_path_to_file ) {
		if ( file_exists( $full_path_to_file ) && is_file( $full_path_to_file ) ) {
			$fp = fopen( $full_path_to_file, "w" );
			fclose( $fp );
		}
	}

	/**
	 * @param array $arr
	 *
	 * @return bool
	 */
	public static function arr_is_assoc( array $arr ) {
		if ( array() === $arr ) {
			return false;
		}

		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}

	/**
	 * @param $if
	 * @param $then
	 * @param $else
	 * @param $alias
	 *
	 * @return string
	 */
	public static function map_if_else_statement( $if, $then, $else , $alias) {
		$connection = DB::connection()->getPdo()->getAttribute( PDO::ATTR_DRIVER_NAME );
		if ( 'sqlite' == $connection ) {
			return sprintf( 'case when %s then %s else %s end as %s', $if, $then, $else, $alias );
		} else {
			return sprintf( 'IF(%s,%s,%s) as %s', $if, $then, $else, $alias );
		}

	}

	/**
	 * @param $file
	 * @param string $algo
	 *
	 * @return string
	 */
	public static function hashFile( $file, $algo = 'adler32' ) {
		return hash_file( $algo, $file );
	}

}
