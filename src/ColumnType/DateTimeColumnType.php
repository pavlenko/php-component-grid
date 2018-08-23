<?php

namespace PE\Component\Grid\ColumnType;

use PE\Component\Grid\ColumnInterface;
use PE\Component\Grid\Exception\UnexpectedValueException;
use PE\Component\Grid\View\CellView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formatted datetime column
 */
class DateTimeColumnType extends AbstractColumnType
{
    /**
     * @inheritDoc
     */
    public function buildCellView(CellView $view, ColumnInterface $column, $row, array $options)
    {
        $value = $view->vars['value'];

        if (!$value) {
            return;
        }

        if (!($value instanceof \DateTimeInterface)) {
            throw new UnexpectedValueException('DateTimeInterface', $value);
        }

        $formatter = \IntlDateFormatter::create(
            $options['locale'],
            $options['date_format'],
            $options['time_format'],
            $options['timezone'],
            \IntlDateFormatter::GREGORIAN,
            $options['pattern']
        );

        $view->vars['value'] = $formatter->format($value);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'locale'      => \Locale::getDefault(),
            'date_format' => \IntlDateFormatter::LONG,
            'time_format' => \IntlDateFormatter::LONG,
            'timezone'    => \IntlTimeZone::createDefault(),
            'pattern'     => '',
        ]);
    }
}