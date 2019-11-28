<?php


namespace Sau\WP\Core\Carbon\Logic;


use Symfony\Component\Console\Style\StyleInterface;

/**
 * Class AbstractContainerLogic
 * @package Sau\WP\Core\Carbon\Logic
 * @see     https://docs.carbonfields.net/#/containers/conditional-display
 */
abstract class AbstractContainerLogic
{
    /**
     * @var StyleInterface
     */
    private $style;

    /**
     * @var array
     */
    private $logic = [];

    const OPERATION_COMPARE = ['=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'CUSTOM',];

    public function __construct(StyleInterface $style)
    {
        $this->style = $style;
    }

    public function build()
    {
        while ($type = $this->style->choice('Choice condition type', ['and', 'or'], 'and')) {
            $type = $type == 'or' ? 'or_where' : 'where';

            $condition = $this->style->choice('Choice condition type', static::getTypes());
            $operator  = $this->style->choice('Choice condition operator', self::OPERATION_COMPARE, '=');
            $value     = $this->style->ask('Value') ?? '';

            $this->logic[] = sprintf('%s("%s","%s","%s")', $type, $condition, $operator, $value);

            if ( ! $this->style->confirm('More conditions?', false)) {
                break;
            };
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLogic(): string
    {
        return implode('->', $this->logic);
    }

    abstract static public function getTypes(): array;
}
