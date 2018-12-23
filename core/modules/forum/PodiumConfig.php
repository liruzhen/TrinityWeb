<?php

namespace core\modules\forum;

use core\models\Settings;
use core\modules\forum\db\Query;
use core\modules\forum\log\Log;
use Exception;
use yii\base\Component;
use yii\caching\Cache;

/**
 * Podium configuration component.
 * Handles the module configuration.
 * Every default configuration value is saved in database first time when administrator saves Podium settings.
 *
 * @property Cache $cache
 * @property array $defaults
 * @property array $all
 * @property array $cached
 * @property array $notCached
 * @property array $stored
 */
class PodiumConfig extends Component
{
    const DEFAULT_FROM_NAME = 'TrinityWeb';
    const FLAG_ALLOW_POLLS = 1;
    const FLAG_MEMBERS_VISIBLE = 1;
    const FLAG_MERGE_POSTS = 1;
    const FLAG_USE_WYSIWYG = 1;
    const HOT_MINIMUM = 20;
    const MAINTENANCE_MODE = 0;
    const MAX_SEND_ATTEMPTS = 5;
    const META_DESCRIPTION = 'TrinityWeb Forum';
    const META_KEYWORDS = 'yii2, forum, trinityweb';
    const PODIUM_NAME = 'Forum';
    const SECONDS_EMAIL_TOKEN_EXPIRE = 86400;
    const SECONDS_PASSWORD_RESET_TOKEN_EXPIRE = 86400;

    private $_config;

    /**
     * Returns configuration table name.
     * @return string
     * @since 0.2
     */
    public static function tableName()
    {
        return Settings::tableName();
    }

    /**
     * Returns list of default configuration values.
     * These values are stored in cached configuration but saved only when
     * administrator saves Podium settings.
     * @return array
     * @since 0.2
     */
    public function getDefaults()
    {
        return [
            'forum.allow_polls'      => self::FLAG_ALLOW_POLLS,
            'forum.from_name'        => self::DEFAULT_FROM_NAME,
            'forum.hot_minimum'      => self::HOT_MINIMUM,
            'forum.maintenance_mode' => self::MAINTENANCE_MODE,
            'forum.max_attempts'     => self::MAX_SEND_ATTEMPTS,
            'forum.members_visible'  => self::FLAG_MEMBERS_VISIBLE,
            'forum.merge_posts'      => self::FLAG_MERGE_POSTS,
            'forum.meta_description' => self::META_DESCRIPTION,
            'forum.meta_keywords'    => self::META_KEYWORDS,
            'forum.name'             => self::PODIUM_NAME,
            'forum.use_wysiwyg'      => self::FLAG_USE_WYSIWYG,
            'forum.version'          => Podium::getInstance()->version,
        ];
    }

    /**
     * Returns Podium cache instance.
     * @return PodiumCache
     * @since 0.5
     */
    public function getCache()
    {
        return Podium::getInstance()->podiumCache;
    }

    /**
     * Returns configuration values.
     * @return array
     * @since 0.6
     */
    public function getAll()
    {
        if ($this->_config !== null) {
            return $this->_config;
        }
        try {
            $this->_config = $this->cached;
        } catch (Exception $exc) {
            Log::warning($exc->getMessage(), null, __METHOD__);
            $this->_config = $this->stored;
        }

        return $this->_config;
    }

    /**
     * Returns cached configuration values.
     * @throws Exception
     * @return array
     * @since 0.6
     */
    public function getCached()
    {
        $cache = $this->cache->get('config');
        if ($cache === false) {
            $cache = $this->notCached;
            $this->cache->set('config', $cache);
        }

        return $cache;
    }

    /**
     * Returns not cached configuration values.
     * If stored configuration is empty default values are returned.
     * @return array
     * @since 0.6
     */
    public function getNotCached()
    {
        return array_merge($this->defaults, $this->stored);
    }

    /**
     * Returns stored configuration values.
     * These can be empty if configuration has not been modified.
     * @return array
     * @since 0.6
     */
    public function getStored()
    {
        $stored = [];
        try {
            $query = (new Query)->from(static::tableName())->all();
            if (!empty($query)) {
                foreach ($query as $setting) {
                    $stored[$setting['key']] = $setting['value'];
                }
            }
        } catch (Exception $e) {
            if (Podium::getInstance()->getInstalled()) {
                Log::error($e->getMessage(), null, __METHOD__);
            }
        }

        return $stored;
    }

    /**
     * Returns configuration value of the given name.
     * @param string $name configuration key
     * @return string|null
     */
    public function get($name)
    {
        $config = $this->all;

        return isset($config[$name]) ? $config[$name] : null;
    }

    /**
     * Sets configuration value of the given name.
     * Every change automatically updates the cache.
     * Set value to null to restore default one.
     * @param string $name configuration key
     * @param string $value configuration value
     * @return bool
     */
    public function set($name, $value)
    {
        try {
            if (is_string($name) && (is_string($value) || $value === null)) {
                if ($value === null) {
                    if (!array_key_exists($name, $this->defaults)) {
                        return false;
                    }
                    $value = $this->defaults[$name];
                }
                if ((new Query)->from(static::tableName())->where(['key' => $name])->exists()) {
                    Podium::getInstance()->db->createCommand()->update(
                        static::tableName(), ['value' => $value], ['key' => $name]
                    )->execute();
                } else {
                    Podium::getInstance()->db->createCommand()->insert(
                        static::tableName(), ['key' => $name, 'value' => $value]
                    )->execute();
                }
                $this->cache->set('config', $this->notCached);
                $this->_config = null;

                return true;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage(), null, __METHOD__);
        }

        return false;
    }

    /**
     * Alias for getAll().
     * @return array
     */
    public function all()
    {
        return $this->all;
    }
}
