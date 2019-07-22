<?php


namespace Sau\WP\Core\Carbon;


use Carbon_Fields\Carbon_Fields;
use ChangeCase\ChangeCase;
use Sau\WP\Core\DependencyInjection\Collector\CarbonCollector;
use Sau\WP\Core\Twig\Twig;

class Carbon
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;
    /**
     * @var CarbonCollector
     */
    private $collector;
    /**
     * All block titles
     * @var array
     */
    protected $blocks = [];
    /**
     * @var Twig
     */
    private $template;

    public function __construct(
        \Symfony\Component\DependencyInjection\ContainerInterface $container,
        CarbonCollector $collector,
        Twig $template
    ) {

        $this->container = $container;
        $this->collector = $collector;
        $this->template  = $template;
        $this->initCarbon();
    }

    /**
     * Initialize carbon
     */
    private function initCarbon()
    {
        #init carbon
        add_action(
            'after_setup_theme',
            function () {
                Carbon_Fields::boot();

            }
        );
        add_action(
            'carbon_fields_register_fields',
            function () {
                foreach ($this->collector->getContainers() as $id => $params) {
                    $this->container->get($id)
                                    ->init();
                }
            }
        );
        add_filter(
            'allowed_block_types',
            function ($blocks) {
                $blocks    = [];
                foreach ($this->collector->getContainers() as $id => $params) {
                    $container = $this->container->get($id);
                    if ($container->getType() === ContainerType::BLOCK) {
                        //todo: непредвиденная странность, почемуто добавляется суфикс блок для блока гутенберга, надо проверить
                        $blocks[] = sprintf(
                            '%s/%s',
                            'carbon-fields',
                            ChangeCase::kebab($container->getContainerID())
                        );
                    }
                }
                return $blocks;

            }
        );
    }

}
