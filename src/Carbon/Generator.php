<?php


namespace Sau\WP\Core\Carbon;


use ChangeCase\ChangeCase;
use Symfony\Component\Console\Style\StyleInterface;

class Generator
{
    /**
     * @var StyleInterface
     */
    private $io;
    /**
     * @var string
     */
    private $prefix;

    /**
     * @var array
     */
    private $fields = [];

    public function __construct(StyleInterface $io, string $prefix = null)
    {
        $this->io     = $io;
        $this->prefix = $prefix;
    }

    public function start()
    {
        $this->io->title(sprintf('Start generate fields[%s]', $this->getPrefix()));
        $old_name = $name = $this->io->ask('Enter field name(empty for end)');

        while ($name) {
            $name = $this->generateName($name);

            if (array_key_exists($name, $this->fields)) {
                $this->io->warning(sprintf('Filed name is used'));
                $name = $this->io->ask('Enter field name(empty for end)');
                continue;
            }

            $type  = $this->io->choice(
                'Enter field name(empty for end)',
                FieldTypes::getTypes(),
                FieldTypes::TYPE_TEXT
            );
            $label = $this->io->ask('Label', ChangeCase::upperFirst($old_name));

            $this->addField($name, $type, $label);

            //new field
            $old_name = $name = $this->io->ask('Enter field name(empty for end)');
        }
    }

    /**
     * @return string
     */
    public function getFields(): string
    {
        return implode(",\n",$this->fields);
    }

    /**
     * @param string $name
     * @param string $type
     * @param string $label
     */
    public function addField(string $name, string $type, string $label): void
    {
        $field = sprintf($this->getFieldPattern(), $type, $name, $label);
        if ($this->io->confirm('Is required?', false)) {
            $field .= '->set_required()';
        }

        switch ($type):
            case FieldTypes::TYPE_COMPLEX:
                $this->extComplex($field, $name);
                break;
            case FieldTypes::TYPE_MEDIA_GALLERY:
                $this->extMediaGallery($field);
                break;
            case FieldTypes::TYPE_HTML:
                $this->extHtml($field);
                break;
            case FieldTypes::TYPE_IMAGE:
                $this->extImage($field);
                break;
            case FieldTypes::TYPE_FILE:
                $this->extFile($field);
                break;
        endswitch;

        $this->fields[ $name ] = $field;
        $this->io->success(sprintf("Added field [%s]", $name));
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return ChangeCase::snake($this->prefix ?? '');
    }

    /**
     * @param $name
     *
     * @return string
     */
    private function generateName($name): string
    {
        if ($this->getPrefix()) {
            return ChangeCase::snake($this->getPrefix().'_'.$name);
        }

        return ChangeCase::snake($name);
    }

    /**
     * Default field pattern
     * @return string
     */
    protected function getFieldPattern()
    {
        if (defined('THEME_LANG')) {
            return 'Field::make("%s", "%s", __( "%s", THEME_LANG ))';
        } else {
            return 'Field::make("%s", "%s", "%s")';
        }
    }

    private function extComplex(string &$field, string $name)
    {
        //==================================
        $field .= "->add_fields([\n";
        $this->io->text(sprintf('Start generate fields for [%s]', $name));
        $ext_f = new self($this->io);
        $ext_f->start();
        $field .= $ext_f->getFields();
        $this->io->text(sprintf('End generate fields for [%s]', $name));
        $field .= "\n])";
        //==================================
        $layout = $this->io->choice(
            'Layout type',
            ['grid', 'tabbed-horizontal', 'tabbed-vertical'],
            'tabbed-horizontal'
        );
        $field  .= sprintf('->set_layout("%s")', $layout);
        //==================================
        $min   = $this->io->ask(
            'Minimum number of rows',
            0,
            function ($var) {
                return is_int($var);
            }
        );
        $field .= $min > 0 ? '->set_min()' : '';
        //==================================
        $max   = $this->io->ask(
            'Maximum number of rows',
            0,
            function ($var) {
                return is_int($var);
            }
        );
        $field .= $max > 0 ? '->set_max()' : '';
        //==================================
        if ($this->io->confirm('Add underscore template')) {
            $field .= '->set_header_template( "<% if (FIELD_NAME) { %><%- FIELD_NAME %><% } %>" )';
        }
    }

    private function extMediaGallery(string &$field)
    {
        if ($this->io->confirm("Duplicates allowed?")) {
            $field .= '->set_duplicates_allowed( false )';
        }
        $field .= '->set_type( ["image"] )';
    }

    private function extHtml(string &$field)
    {
        $field .= '->set_html("<p>HTML-text</p>")';
    }

    private function extImage(string &$field)
    {
        $field .= '->set_width( 10 )';
    }

    private function extFile(string &$field)
    {
        if ($mime = $this->io->ask("Enter MIME-type")) {
            $field .= sprintf('->set_type( "%s" )', $mime);
        }
        //$field .= '->set_value_type( "url" )';
        $field .= '->set_width( 10 )';
    }

    public function getFieldNames()
    {
        return array_keys($this->fields);
    }

}
