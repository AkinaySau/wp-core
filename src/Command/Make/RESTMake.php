<?php


namespace Sau\WP\Core\Command\Make;


use Carbon_Fields\Field;
use ChangeCase\ChangeCase;
use Nette\PhpGenerator\PhpNamespace;
use Sau\WP\Core\Carbon\GutenbergBlock;
use WP_REST_Controller;
use WP_REST_Response;

class RESTMake extends AbstractMakeNamespace
{
    public function pathPrefix(): string
    {
        return 'REST';
    }

    protected function generate(): PhpNamespace
    {
        $expectedClass = $this->ascExpectedClass();

        list($namespace, $class) = $this->parseNamespace($expectedClass);
        $namespace = new PhpNamespace($this->namespaceAbsolute($namespace));


        $namespace->addUse(Field::class);
        $namespace->addUse(WP_REST_Controller::class);
        $namespace->addUse(WP_REST_Response::class);

        $class = $namespace->addClass($class);
        $class->addExtend(WP_REST_Controller::class);

        $class_var__namespace = $this->getStyle()
                                     ->ask('Namespace', 'my-namespace/v1');
        $class->addProperty('namespace', $class_var__namespace)
              ->setVisibility('protected')
              ->setComment('@var string');

        $class_var__rest_base = $this->getStyle()
                                     ->ask('Rest base', 'posts');
        $class->addProperty('rest_base', $class_var__rest_base)
              ->setVisibility('protected')
              ->setComment('@var string');

        $this->getStyle()
             ->success('Namespace');

        $method           = $class->addMethod('register_routes');
        $callable_methods = [];
        do {
            $methods_request = $this->getStyle()
                                    ->choice('Choice method', ['GET', 'POST', 'PUT', 'DELETE'], 'GET');
            $callback        = $this->getStyle()
                                    ->ask(
                                        'Callable method',
                                        null,
                                        function ($var) use ($callable_methods) {
                                            if (empty($var)) {
                                                throw new \RuntimeException('Callable method name can`t be empty');
                                            }
                                            if (array_key_exists($var, $callable_methods)) {
                                                throw new \RuntimeException('Method exist');
                                            }

                                            //TODO: change package
                                            return ChangeCase::lowerCamel($var);
                                        }
                                    );

            $callable_methods[ $callback ] = sprintf(
                'register_rest_route( $this->namespace, "/".$this->rest_base."/", [
                [
                    \'methods\'             => \'%s\',
                    \'callback\'            => [ $this, \'%s\' ],
                ]
            ] );',
                $methods_request,
                $callback
            );

        } while ($this->getStyle()
                      ->confirm('Add more routes', true));

        $method->addBody(implode("\n", $callable_methods));


        //create callable methods
        foreach ($callable_methods as $key => $content) {
            $class->addMethod($key)
                  ->setBody(
                      sprintf(
                          <<<'PHP'
                        //TODO: Write your code this
                      $data = ['data'=>'Response method "%s"'];
                  
                      return new WP_REST_Response($data);
PHP,
                          $key
                      )
                  )
                  ->setReturnType(WP_REST_Response::class);
        }


        return $namespace;
    }
}
