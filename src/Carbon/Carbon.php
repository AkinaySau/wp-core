<?php


namespace Sau\WP\Core\Carbon;


use Carbon_Fields\Carbon_Fields;
use Sau\WP\Core\DependencyInjection\Collector\CarbonCollector;
use Sau\WP\Core\Twig\Template;

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
     * @var Template
     */
    private $template;

    public function __construct(
        \Symfony\Component\DependencyInjection\ContainerInterface $container,
        CarbonCollector $collector,
        Template $template
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
                    $this->container->get($id);
                    /*$container = new $class();
                    if ($container->getType() === ContainerType::BLOCK) {
                      $this->container->setTemplater(Template $twig)
                        $this->blocks[] = $container->getTitle();
                    }
                    $container->init();*/
                }
            }
        );
    }

}
