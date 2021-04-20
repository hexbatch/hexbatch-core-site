<?php
namespace hexlet;

use Symfony\Component\Yaml\Yaml;

class SettingsException extends GoKabamLibException {}

/**
 * Class Settings
 *  MUST set HEXLET_ENVIRONMENT as environmental variable
 */
class Settings {

	/**
	 * @var array
	 */
	protected static $settings = [];

	/**
	 * Environmental
	 *
	 * @param string $name
	 *
	 * @return mixed
	 * @throws SettingsException
	 */
	public static function get_setting( string $name) {
		static::build_settings();
		$name = strtoupper($name);
		if (array_key_exists($name,static::$settings)) {
			return static::$settings[$name];
		}
		return static::getenv($name);
	}

	/**
	 * @param string $env_key
	 * @param bool $b_throw_exception , default true, if false will return false
	 *
	 * @return string
	 * @throws SettingsException
	 */
	public static function getenv( string $env_key,$b_throw_exception = true) {
		$da_value = getenv($env_key);
		if (false === $da_value) {
			if ($b_throw_exception) {
				throw new SettingsException("cannot find environmental variable $env_key");
			} else {
				return false;
			}

		}
		$da_value = trim($da_value);
		if (empty($da_value)) {
			if ($b_throw_exception) {
				throw new SettingsException("environmental variable $env_key is empty");
			} else {
				return false;
			}

		}
		return $da_value;
	}

	/**
	 * @return array
	 * @throws SettingsException
	 */
	public static function build_settings(): array
    {
		if (!empty(static::$settings)) {return [];}
		$environment = static::getenv('HEXLET_ENVIRONMENT');
		$start = HEXLET_LIB_PATH . '/env.yml';
		if (!is_readable($start)) {
			throw new SettingsException("Cannot read $start, cannot load settings");
		}
		$settings = Yaml::parseFile($start);
		if (empty($settings)) {return [];}
		$underwrite = static::flatten($settings);

		if (empty($environment)) {
			throw new SettingsException("No environment set, cannot load settings. Please set an environmental variable called environment");
		} else {
			$environment = trim($environment);
		}
		$end = HEXLET_LIB_PATH . "/env.$environment.yml";
		if (!is_readable($end)) {
			throw new SettingsException("The environment of $environment does not have a file of $end , cannot load settings");
		}
		$overwrite_raw = Yaml::parseFile($end);
		$overwrite = static::flatten($overwrite_raw);
		static::$settings = array_merge($underwrite,$overwrite);
		static::$settings['ENVIRONMENT'] = $environment;
		return static::$settings;
	}

	/**
	 * @param $array
	 * @param string $prefix
	 * @see https://stackoverflow.com/questions/9546181/flatten-multidimensional-array-concatenating-keys
	 * @return array
	 */
	protected static function flatten($array, $prefix = ''): array
    {
		$result = array();
		foreach($array as $key=>$value) {
			if(is_array($value)) {
				$result = $result + static::flatten($value, $prefix . $key . '_');
			}
			else {
				$upper_key = strtoupper($prefix.$key);
				$result[$upper_key] = $value;
			}
		}
		return $result;
	}
}