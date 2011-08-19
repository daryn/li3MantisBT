<?php

namespace app\models;

use lithium\g11n\Message;
use app\models\Settings;

/**
 * A class that handles MantisBT Enumerations.
 *
 * For example: 10:lablel1,20:label2
 *
 */
class Enum extends \lithium\core\Object {
	/**
	 * Separator that is used to separate the enum values from their labels.
	 */
	const VALUE_LABEL_SEPARATOR = ':';

	/**
	 * Separator that is used to separate the enum tuples within an enumeration definition.
	 */
	const TUPLE_SEPARATOR = ',';

	/**
	 *
	 * @var array Used to cache previous results
	 */
	private static $_cacheAssocArrayIndexedByValues = array();

	/**
	 * Get the string associated with the $p_enum value
	 *
	 * @param string $enumString
	 * @param int $value
	 * @return string
	 */
	public static function getLabel( $enumString, $value ) {
		$assocArray = Enum::getAssocArrayIndexedByValues( $enumString );
		$valueAsInteger = (int)$value;

		if ( isset( $assocArray[$valueAsInteger] ) ) {
			return $assocArray[$valueAsInteger];
		}

		return Enum::getLabelForUnknownValue( $valueAsInteger );
	}

	/**
	 * Gets the localized label corresponding to a value.  Note that this method
	 * takes in the standard / localized enums so that if the value is in the localized
	 * enum but not the standard one, then it returns not found.
	 *
	 * @param string $enumKey The key to retrieve standard and localized enum strings.
	 * @param integer $value  The value to lookup.
	 *
	 * @return the label or the decorated value to represent not found.
	 */
	public static function getLocalizedLabel( $enumKey, $value ) {
		extract(Message::aliases());
		$settings = Settings::all();
		$enumString = $settings->$enumKey;
		$localizedEnumString = $t($enumKey);

		if ( !Enum::hasValue( $enumString, $value ) ) {
			return Enum::getLabelForUnknownValue( $value );
		}

		return Enum::getLabel( $localizedEnumString, $value );
	}

	/**
	 * Gets the value associated with the specified label.
	 *
	 * @param string $enumString  The enumerated string.
	 * @param string $label       The label to map.
	 * @return integer value of the enum or false if not found.
	 */
	public static function getValue( $enumString, $label ) {
		$assocArrayByLabels = Enum::getAssocArrayIndexedByLabels( $enumString );

		if ( isset( $assocArrayByLabels[$label] ) ) {
			return $assocArrayByLabels[$label];
		}

		return false;
	}

	/**
	 * Get an associate array for the tuples of the enum where the values
	 * are the array indices and the labels are the array values.
	 *
	 * @param string $enumString
	 * @return associate array indexed by labels.
	 */
	public static function getAssocArrayIndexedByValues( $enumString ) {
		if( isset( self::$_cacheAssocArrayIndexedByValues[$enumString] ) ) {
			return self::$_cacheAssocArrayIndexedByValues[$enumString];
		}

		$tuples = Enum::getArrayOfTuples( $enumString );
		$tuplesCount = count( $tuples );

		$assocArray = array();

		foreach ( $tuples as $tuple ) {
			$tupleTokens = Enum::getArrayForTuple( $tuple );

			# if not a proper tuple, skip.
			if ( count( $tupleTokens ) != 2 ) {
				continue;
			}

			$value = (int) trim( $tupleTokens[0] );

			# if already set, skip.
			if ( isset( $assocArray[ $value ] ) ) {
				continue;
			}

			$label = trim( $tupleTokens[1] );

			$assocArray[$value] = $label;
		}

		self::$_cacheAssocArrayIndexedByValues[$enumString] = $assocArray;

		return $assocArray;
	}

	/**
	 * Get an associate array for the tuples of the enum where the labels
	 * are the array indices and the values are the array values.
	 *
	 * @param string $enumString
	 * @return associate array indexed by labels.
	 */
	public static function getAssocArrayIndexedByLabels( $enumString ) {
		return array_flip( Enum::getAssocArrayIndexedByValues( $enumString ) );
	}

	/**
	 * Gets an array with all values in the enum.
	 *
	 * @param $enumString
	 * @return array of unique values.
	 */
	public static function getValues( $enumString ) {
		return array_unique( array_keys( Enum::getAssocArrayIndexedByValues( $enumString ) ) );
	}

	/**
	 * Checks if the specified enum string contains the specified value.
	 *
	 * @param string $enumString  The enumeration string.
	 * @param integer $value      The value to chec,
	 * @return bool true if found, false otherwise.
	 */
	public static function hasValue( $enumString, $value ) {
		$assocArray = Enum::getAssocArrayIndexedByValues( $enumString );
		$valueAsInteger = (int)$value;
		return isset( $assocArray[$valueAsInteger] );
	}

	/**
	 * Breaks up an enum string into num:value elements
	 *
	 * @param string $enumString enum string
	 * @return array array of num:value elements
	 */
	private static function getArrayOfTuples( $enumString ) {
		if ( strlen( trim( $enumString ) ) == 0 ) {
			return array();
		}

		$rawArray = explode( Enum::TUPLE_SEPARATOR, $enumString );
		$trimmedArray = array();

		foreach ( $rawArray as $tuple ) {
			$trimmedArray[] = trim( $tuple );
		}

		return $trimmedArray;
	}

	/**
	 * Given one num:value pair it will return both in an array
	 * num will be first (element 0) value second (element 1)
	 *
	 * @param string $tuple a num:value pair
	 * @return array array(value, label)
	 */
	private static function getArrayForTuple( $tuple ) {
		return explode( Enum::VALUE_LABEL_SEPARATOR, $tuple );
	}

	/**
	 * Given a value it decorates it and returns it as the label.
	 *
	 * @param integer The value (e.g. 50).
	 * @return The decorated value (e.g. @50@).
	 */
	private static function getLabelForUnknownValue( $value ) {
		$valueAsInteger = (int)$value;
		return '@' . $valueAsInteger . '@';
	}
}