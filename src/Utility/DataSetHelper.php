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
use Sparkplug\Payload\Payload\DataSet\DataSetValue;
use Sparkplug\Payload\Payload\DataSet\Row;

/**
 * DataSet value encapsulation helper
 *
 * @author Michal Sotolar <michal@sotolar.com>
 */
class DataSetHelper extends AbstractHelper
{
    /**
     * Set DataSet cols
     */
    public static function setColumns(DataSet $set, array $data): bool
    {
        $set->setNumOfColumns(\count($data));
        $set->setColumns(\array_keys($data));
        $set->setTypes(\array_values($data));

        return true;
    }

    /**
     * Set DataSet rows
     */
    public static function setRows(DataSet $set, array $data, bool $reset = true): bool
    {
        if (false !== $reset) {
            $set->setRows([]);
        }

        foreach ($data as $offset => $setRow) {
            if (true !== \is_int($offset) || true !== \is_array($setRow) || \count($setRow) !== $set->getNumOfColumns()) {
                continue;
            }

            $row = new Row;
            foreach ($setRow as $column => $value) {
                self::setValue($set, $column, $element = new DataSetValue, $value);

                $row->getElements()[] = $element;
            }

            $set->getRows()[] = $row;
        }

        return true;
    }

    /**
     * Set DataSetValue value
     *
     * @param mixed $data
     */
    public static function setValue(DataSet $set, string $column, DataSetValue $value, $data): bool
    {
        $types = \iterator_to_array($set->getTypes());
        if (false !== $offset = \array_search($column, \iterator_to_array($set->getColumns()))) {
            if (false !== isset($types[$offset])) {
                $current = $value->{self::resolve('get', $types[$offset])}();
                $value->{self::resolve('set', $types[$offset])}($data);

                return $value->{self::resolve('get', $types[$offset])}() !== $current;
            }
        }

        return false;
    }
}
