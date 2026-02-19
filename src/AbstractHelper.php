<?php

/**
 * This file is part of PHP Sparkplug Payload.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sparkplug\Payload;

/**
 * Abstract utility helper
 *
 * @author Michal Sotolar <michal@sotolar.com>
 */
abstract class AbstractHelper
{
    /**
     * Resolve data type method
     */
    protected static function resolve(string $type, int $dataType): string
    {
        if (false !== $dataType > 0) {
            switch ($dataType) {
                case DataType::Int8:
                case DataType::Int16:
                case DataType::Int32:
                case DataType::UInt8:
                case DataType::UInt16:
                    return \sprintf('%sIntValue', $type);
                case DataType::Int64:
                case DataType::UInt32:
                case DataType::UInt64:
                    return \sprintf('%sLongValue', $type);
                case DataType::Float:
                    return \sprintf('%sFloatValue', $type);
                case DataType::Double:
                    return \sprintf('%sDoubleValue', $type);
                case DataType::Boolean:
                    return \sprintf('%sBooleanValue', $type);
                case DataType::String:
                case DataType::Text:
                    return \sprintf('%sStringValue', $type);
                case DataType::Bytes:
                case DataType::File:
                    return \sprintf('%sBytesValue', $type);
                case DataType::DateTime:
                    return \sprintf('%sLongValue', $type);
                case DataType::DataSet:
                    return \sprintf('%sDatasetValue', $type);
                case DataType::Template:
                    return \sprintf('%sTemplateValue', $type);
            }
        }

        return \sprintf('%sValue', $type);
    }
}
