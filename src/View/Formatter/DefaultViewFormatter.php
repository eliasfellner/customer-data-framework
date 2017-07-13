<?php

namespace CustomerManagementFrameworkBundle\View\Formatter;

use Carbon\Carbon;
use CustomerManagementFrameworkBundle\Model\CustomerSegmentInterface;
use Pimcore\Model\Object\ClassDefinition;
use Pimcore\Model\Object\ClassDefinition\Data;
use Pimcore\Model\Translation\TranslationInterface;
use Pimcore\Translate\Admin;

class DefaultViewFormatter implements ViewFormatterInterface
{
    /**
     * @var TranslationInterface[]
     */
    protected $translate = [];
    protected $locale;


    /**
     * @param string $messageId
     * @param array|mixed $parameters
     * @return string
     */
    public function translate($messageId, $parameters = [])
    {
        if (!is_array($parameters)) {
            if (!empty($parameters)) {
                $parameters = [$parameters];
            } else {
                $parameters = [];
            }
        }

        $locale = $this->applyLocale();
        $locale = $this->getLanguageFromLocale($locale);

        if (!$ta = $this->translate[$locale]) {
            $ta = new \Pimcore\Model\Translation\Admin();
            $this->translate[$locale] = $ta;
        }
        $message = $ta->getByKeyLocalized($messageId, true, true, $locale);
        if (count($parameters) > 0) {
            $message = vsprintf($message, $parameters);
        }

        return $message;
    }

    /**
     * @param Data $fd
     * @return array|string
     */
    public function getLabelByFieldDefinition(Data $fd)
    {
        return $this->translate($fd->getTitle());
    }

    public function getLabelByFieldName(ClassDefinition $class, $fieldName)
    {
        if ($fieldName == 'id') {
            return 'ID';
        }

        $fd = $class->getFieldDefinition($fieldName);

        return $this->getLabelByFieldDefinition($fd);
    }


    /**
     * @param Data $fd
     * @param $value
     * @return string
     */
    public function formatValueByFieldDefinition(Data $fd, $value)
    {
        if ($fd instanceof Data\Checkbox) {
            return $this->formatBooleanValue($value);
        }

        if ($fd instanceof Data\Datetime) {
            return $this->formatDatetimeValue($value);
        }

        if ($fd instanceof Data\Date) {
            return $this->formatDatetimeValue($value, true);
        }

        if (is_array($value)) {
            $result = [];
            foreach ($value as $val) {
                $result[] = $this->formatValueByFieldDefinition($fd, $val);
            }

            return implode("\n", $result);
        }

        return $this->formatValue($value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function formatValue($value)
    {
        if ($value instanceof CustomerSegmentInterface) {
            return $this->formatSegmentValue($value);
        }

        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    public function formatBooleanValue($value)
    {
        if ($value) {
            return '<i class="glyphicon glyphicon-check"></i>';
        }

        return '<i class="glyphicon glyphicon-unchecked"></i>';
    }

    /**
     * @param $value
     * @return string
     */
    public function formatDatetimeValue($value, $dateOnly = false)
    {
        $this->applyLocale();

        if (is_object($value) && method_exists($value, 'getTimestamp')) {
            $value = date('Y-m-d H:i:s', $value->getTimestamp());
        }

        $date = Carbon::parse($value);

        if ($dateOnly) {
            return $date->formatLocalized("%x");
        }

        return $date->formatLocalized("%x %X");
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param CustomerSegmentInterface $segment
     * @return string
     */
    protected function formatSegmentValue(CustomerSegmentInterface $segment)
    {
        return sprintf('<span class="label label-default">%s</span>', $segment->getName());
    }

    protected function getLanguageFromLocale($locale)
    {
        return explode('_', $locale)[0];
    }

    /**
     * @return string
     */
    protected function applyLocale()
    {
        $locale = $this->getLocale() ?: \Pimcore::getContainer()->get('pimcore.locale')->getLocale();

        $dateLocaleMap = [
            'de' => 'de_AT',
        ];

        setLocale(LC_TIME, isset($dateLocaleMap[$locale]) ? $dateLocaleMap[$locale] : $locale);
        Carbon::setLocale($this->getLanguageFromLocale($locale));

        return $locale;
    }
}