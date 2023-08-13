<?php

namespace App\Services\Cache;

use Exception;
use PDO;
use App\Core\Env;
use App\Exceptions\EnvPropertyValueException;

if (Env::get('SWIFT_CACHE_DRIVER') == 'FILE') {

    class SwiftCache
    {
        private static $cache = array();

        private static function loadCache()
        {
            if (file_exists('cache.json')) {
                $json = file_get_contents('cache.json');
                self::$cache = json_decode($json, true);
            }
        }

        private static function saveCache()
        {
            $json = json_encode(self::$cache);
            file_put_contents('cache.json', $json);
        }

        public static function has($key)
        {
            self::loadCache();
            if (array_key_exists($key, self::$cache) && !self::isExpired($key))
                return true;
            return false;
        }

        public static function get($key)
        {
            self::loadCache();
            if (self::has($key) && !self::isExpired($key)) {
                return self::$cache[$key]['value'];
            } else {
                self::delete($key);
                return null;
            }
        }

        public static function set($key, $value, $expiration = null)
        {
            self::loadCache();
            self::$cache[$key] = array('value' => $value, 'expiration' => $expiration);
            self::saveCache();
        }

        public static function delete($key)
        {
            self::loadCache();
            unset(self::$cache[$key]);
            self::saveCache();
        }

        public static function clear()
        {
            self::$cache = array();
            self::saveCache();
        }

        private static function isExpired($key)
        {
            if (!array_key_exists($key, self::$cache))
                return true;

            $expiration = self::$cache[$key]['expiration'];
            return $expiration !== null && time() >= $expiration;
        }
    }
} else if (Env::get('SWIFT_CACHE_DRIVER') == 'SQLITE') {

    class SwiftCache
    {
        private static $db;

        private static function connect()
        {
            if (self::$db === null) {
                self::$db = new PDO('sqlite:cache.db');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->exec('CREATE TABLE IF NOT EXISTS cache (key TEXT PRIMARY KEY, value TEXT, expiration INTEGER)');
            }
        }

        public static function has($key)
        {
            self::connect();
            $stmt = self::$db->prepare('SELECT * FROM cache WHERE key=?');
            $stmt->execute(array($key));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && !self::isExpired($result['expiration'])) {
                return true;
            } else {
                return false;
            }
        }

        public static function get($key)
        {
            self::connect();
            $stmt = self::$db->prepare('SELECT * FROM cache WHERE key=?');
            $stmt->execute(array($key));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($result['key']) && !self::isExpired($result['expiration'])) {
                return unserialize($result['value']);
            } else {
                self::delete($key);
                return null;
            }
        }

        public static function set($key, $value, $expiration = null)
        {
            self::connect();
            $stmt = self::$db->prepare('INSERT OR REPLACE INTO cache (key, value, expiration) VALUES (?, ?, ?)');
            $stmt->execute(array(
                $key,
                serialize($value),
                $expiration
            ));
        }

        public static function delete($key)
        {
            self::connect();
            $stmt = self::$db->prepare('DELETE FROM cache WHERE key = :key');
            $stmt->execute(array('key' => $key));
        }

        public static function clear()
        {
            self::connect();
            self::$db->exec('DELETE FROM cache');
        }

        private static function isExpired($expiration)
        {
            if ($expiration !== null && time() >= $expiration) {
                return true;
            } else {
                return false;
            }
        }
    }
} else if (Env::get('SWIFT_CACHE_DRIVER') == 'SESSION') {

    class SwiftCache
    {
        public static function has($key)
        {
            self::startSession();
            return isset($_SESSION[$key]) && !self::isExpired($_SESSION[$key]['expiration']);
        }

        public static function get($key)
        {
            self::startSession();
            if (self::has($key)) {
                return $_SESSION[$key]['value'];
            } else {
                self::delete($key);
                return null;
            }
        }

        public static function set($key, $value, $expiration = null)
        {
            self::startSession();
            $_SESSION[$key] = array('value' => $value, 'expiration' => $expiration);
        }

        public static function delete($key)
        {
            self::startSession();
            unset($_SESSION[$key]);
        }

        public static function clear()
        {
            self::startSession();
            session_unset(); // Oturumdaki tüm değişkenleri temizler.
        }

        private static function isExpired($data)
        {
            $expiration = $data['expiration'];
            return $expiration !== null && time() >= $expiration;
        }

        private static function startSession()
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }
} else
    throw new EnvPropertyValueException();
