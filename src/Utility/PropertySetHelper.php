<?php

/**
 * This file is part of PHP Sparkplug Payload.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sparkplug\Payload\Utility;

use Sparkplug\Payload\AbstractHelper;
use Sparkplug\Payload\Payload\PropertySet;

/**
 * PropertySet value encapsulation helper
 *
 * @author Michal Sotolar <michal@sotolar.com>
 */
class PropertySetHelper extends AbstractHelper
{
    /**
     * Get PropertySet value
     *
     * @return mixed
     */
    public static function getValue(PropertySet $set, string $key)
    {
        $values = \iterator_to_array($set->getValues());
        if (false !== $offset = \array_search($key, \iterator_to_array($set->getKeys()))) {
            if (false !== isset($values[$offset])) {
                return $values[$offset]->{self::resolve('get', $values[$offset]->getType())}();
            }
        }

        return null;
    }

    /**
     * Set PropertySet value
     *
     * @param mixed $data
     */
    public static function setValue(PropertySet $set, string $key, $data): bool
    {
        $values = \iterator_to_array($set->getValues());
        if (false !== $offset = \array_search($key, \iterator_to_array($set->getKeys()))) {
            if (false !== isset($values[$offset])) {
                $current = $values[$offset]->{static::resolve('get', $values[$offset]->getType())}();
                $values[$offset]->{static::resolve('set', $values[$offset]->getType())}($data);

                return $values[$offset]->{static::resolve('get', $values[$offset]->getType())}() !== $current;
            }
        }

        return false;
    }

    /**
     * Set PropertySet values
     */
    public static function setValues(PropertySet $set, array $data): bool
    {
        $result = false;
        foreach ($data as $key => $value) {
            if (false !== self::setValue($set, $key, $value)) {
                $result = true;
            }
        }

        return $result;
    }
}
