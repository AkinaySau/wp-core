<?php


namespace Sau\WP\Core\Command\Make;


use Carbon_Fields\Field;
use ChangeCase\ChangeCase;
use Nette\PhpGenerator\PhpNamespace;
use Sau\WP\Core\Carbon\GutenbergBlock;
use Sau\WP\Core\DependencyInjection\WPExtension\ActionInterface;
use Sau\WP\Core\Option\AbstractPageOption;
use Sau\WP\SettingsAPI\SettingsGroup;
use WP_REST_Controller;
use WP_REST_Response;

class OptionsMake extends AbstractMakeNamespace
{
    public function pathPrefix(): string
    {
        return 'Options';
    }

    protected function generate(): PhpNamespace
    {
        $expectedClass = $this->ascExpectedClass();

        list($namespace, $class) = $this->parseNamespace($expectedClass);
        $namespace = new PhpNamespace($this->namespaceAbsolute($namespace));

        $namespace->addUse(AbstractPageOption::class)
                  ->addUse(SettingsGroup::class);

        $class = $namespace->addClass($class);
        $class->addExtend(AbstractPageOption::class);

        $title = $this->getStyle()
                      ->ask(
                          'Enter page title',
                          null,
                          function ($val) {
                              $val = trim($val);
                              if ( ! $val) {
                                  throw new \Exception('Page title name can`t be empty');
                              }

                              return $val;
                          }
                      );

        $menuTitle = $this->getStyle()
                          ->ask(
                              'Enter menu title',
                              $title,
                              function ($val) {
                                  $val = trim($val);
                                  if ( ! $val) {
                                      throw new \Exception('Menu title name can`t be empty');
                                  }

                                  return $val;
                              }
                          );

        $slug = $this->getStyle()
                     ->ask(
                         'Enter page slug',
                         ChangeCase::kebab($title),
                         function ($val) {
                             $val = trim($val);
                             if ( ! $val) {
                                 throw new \Exception('Menu title name can`t be empty');
                             }

                             return $val;
                         }
                     );
        $class->addConstant('PAGE_TITLE', $title);
        $class->addConstant('MENU_TITLE', $menuTitle);
        $class->addConstant('SLUG', $slug);

        $settings = $this->getStyle()
                         ->confirm("Add settings");

        $class->addMethod('page')
              ->addComment('Содержимое сраницы')
              ->setReturnType('void')
              ->setBody($settings ? '$this->setupSettingsBlock();' : 'echo static::PAGE_TITLE');

        if ($settings) {
            $class->addMethod('setupSettingsBlock')
                  ->setFinal(true)
                  ->setComment('Вывод блока настроек')
                  ->setVisibility('private')
                  ->setReturnType('void')
                  ->setBody(
                      sprintf(
                          '
                        echo \'<form method="POST" action="options.php">\';
                        settings_fields( %s );
                        do_settings_sections( %1$s );
                        submit_button();
                        echo \'</form>\';
                        ',
                          'static::SLUG'
                      )
                  );

            $class->addMethod('settings')
                  ->setFinal(true)
                  ->setBody(
                      sprintf('
                        $group_id=\'pages\';
                        $group_title=\'Страницы\';
                        $setting_group = new SettingsGroup($group_id,$group_title,%s);
                        $setting_group->addField(new UrlField($id, $title));
                      ','static::SLUG')
                  );

        }
    }

}
