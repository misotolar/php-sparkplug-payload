<?php

/**
 * This file is part of PHP Sparkplug Payload.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sparkplug\Payload\Utility;

use Sparkplug\Payload\AbstractHelper;
use Sparkplug\Payload\Payload\DataSet;
use Sparkplug\Payload\Payload\Metric;

/**
 * Metric value encapsulation helper
 *
 * @author Michal Sotolar <michal@sotolar.com>
 */
class MetricHelper extends AbstractHelper
{
    /**
     * Get Metric value
     *
     * @return mixed
     */
    public static function getValue(Metric $metric)
    {
        return $metric->{static::resolve('get', $metric->getDataType())}();
    }

    /**
     * Set Metric value
     *
     * @param mixed $data
     */
    public static function setValue(Metric $metric, $data): bool
    {
        if (null !== $set = $metric->getDatasetValue()) {
            return DataSetHelper::setRows($set, $data);
        }

        $current = $metric->{static::resolve('get', $metric->getDataType())}();
        $metric->{static::resolve('set', $metric->getDataType())}($data);

        return $metric->{static::resolve('get', $metric->getDataType())}() !== $current;
    }

    /**
     * Set Metric Dataset columns
     */
    public static function setDatasetColumns(Metric $metric, array $data): bool
    {
        if (null === $set = $metric->getDatasetValue()) {
            self::setValue($metric, $set = new Dataset);
        }

        return DataSetHelper::setColumns($set, $data);
    }

    /**
     * Set Metric Dataset rows
     */
    public static function setDatasetRows(Metric $metric, array $data): bool
    {
        if (null === $set = $metric->getDatasetValue()) {
            return false;
        }

        return DataSetHelper::setRows($set, $data);
    }

    /**
     * Set Metric PropertySet value
     *
     * @param mixed $data
     */
    public static function setPropertyValue(Metric $metric, string $key, $data): bool
    {
        if (null === $set = $metric->getProperties()) {
            return false;
        }

        return PropertySetHelper::setValue($set, $key, $data);
    }

    /**
     * Set Metric PropertySet values
     */
    public static function setPropertyValues(Metric $metric, array $data): bool
    {
        if (null === $set = $metric->getProperties()) {
            return false;
        }

        return PropertySetHelper::setValues($set, $data);
    }

    /**
     * Set Metric Timestamp
     */
    public static function setTimestamp(Metric $metric): void
    {
        $metric->setTimestamp(\round(\microtime(true) * 1000));
    }
}
