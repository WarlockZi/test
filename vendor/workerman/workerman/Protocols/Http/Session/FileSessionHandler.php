<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Workerman\Protocols\Http\Session;

/**
 * Class FileSessionHandler
 * @package Workerman\Protocols\Http\Session
 */
class FileSessionHandler implements \SessionHandlerInterface
{
    /**
     * Session save path.
     *
     * @var string
     */
    protected static $_sessionSavePath = null;

    /**
     * Session file prefix.
     *
     * @var string
     */
    protected static $_sessionFilePrefix = 'session_';

    /**
     * Init.
     */
    public static function init() {
        $save_path = @\session_save_path();
        if (!$save_path || \strpos($save_path, 'tcp://') === 0) {
            $save_path = \sys_get_temp_dir();
        }
        static::sessionSavePath($save_path);
    }

    /**
     * FileSessionHandler constructor.
     * @param array $config
     */
    public function __construct($config = array()) {
        if (isset($config['save_path'])) {
            static::sessionSavePath($config['save_path']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function open($save_path, $name)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($session_id)
    {
        $session_file = static::sessionFile($session_id);
        \clearstatcache();
        if (\is_file($session_file)) {
            $data = \file_get_contents($session_file);
            return $data ? $data : '';
        }
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function write($session_id, $session_data)
    {
        $temp_file = static::$_sessionSavePath.uniqid(mt_rand(), true);
        if (!\file_put_contents($temp_file, $session_data)) {
            return false;
        }
        return \rename($temp_file, static::sessionFile($session_id));
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($session_id)
    {
        $session_file = static::sessionFile($session_id);
        if (\is_file($session_file)) {
            \unlink($session_file);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime) {
        $time_now = \time();
        foreach (\glob(static::$_sessionSavePath . static::$_sessionFilePrefix . '*') as $file) {
            if(\is_file($file) && $time_now - \filemtime($file) > $maxlifetime) {
                \unlink($file);
            }
        }
    }

    /**
     * Get session file path.
     *
     * @param $session_id
     * @return string
     */
    protected static function sessionFile($session_id) {
        return static::$_sessionSavePath.static::$_sessionFilePrefix.$session_id;
    }

    /**
     * Get or set session file path.
     *
     * @param $path
     * @return string
     */
    public static function sessionSavePath($path) {
        if ($path) {
            if ($path[\strlen($path)-1] !== DIRECTORY_SEPARATOR) {
                $path .= DIRECTORY_SEPARATOR;
            }
            static::$_sessionSavePath = $path;
            if (!\is_dir($path)) {
                \mkdir($path, 0777, true);
            }
        }
        return $path;
    }
}

FileSessionHandler::init();