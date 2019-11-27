<?php


namespace Sau\WP\Core\Carbon;


abstract class FieldTypes
{
    //Basic
    const  TYPE_CHECKBOX    = 'checkbox';
    const  TYPE_COLOR       = 'color';
    const  TYPE_HIDDEN      = 'hidden';
    const  TYPE_MULTISELECT = 'multiselect';
    const  TYPE_RADIO       = 'radio';
    const  TYPE_RADIO_IMAGE = 'radio_image';
    const  TYPE_RICH_TEXT   = 'rich_text';
    const  TYPE_SELECT      = 'select';
    const  TYPE_SET         = 'set';
    const  TYPE_TEXT        = 'text';
    const  TYPE_TEXTAREA    = 'textarea';
    //Date and Time
    const TYPE_DATE      = 'date';
    const TYPE_DATE_TIME = 'date_time';
    const TYPE_TIME      = 'time';
    //Relational
    const TYPE_ASSOCIATION = 'association';
    //Media
    const TYPE_FILE          = 'file';
    const TYPE_IMAGE         = 'image';
    const TYPE_MEDIA_GALLERY = 'media_gallery';
    //Misc
    const TYPE_FOOTER_SCRIPTS = 'footer_scripts';
    const TYPE_HEADER_SCRIPTS = 'header_scripts';
    //Structure
    const TYPE_HTML      = 'html';
    const TYPE_SEPARATOR = 'separator';
    //Other
    const TYPE_COMPLEX = 'complex';

    //    const TYPE_


    public static function getTypes()
    {
        return [
            self::TYPE_CHECKBOX,
            self::TYPE_COLOR,
            self::TYPE_HIDDEN,
            self::TYPE_MULTISELECT,
            self::TYPE_RADIO,
            self::TYPE_RADIO_IMAGE,
            self::TYPE_RICH_TEXT,
            self::TYPE_SELECT,
            self::TYPE_SET,
            self::TYPE_TEXT,
            self::TYPE_TEXTAREA,
            self::TYPE_DATE,
            self::TYPE_DATE_TIME,
            self::TYPE_TIME,
            self::TYPE_ASSOCIATION,
            self::TYPE_FILE,
            self::TYPE_IMAGE,
            self::TYPE_MEDIA_GALLERY,
            self::TYPE_FOOTER_SCRIPTS,
            self::TYPE_HEADER_SCRIPTS,
            self::TYPE_HTML,
            self::TYPE_SEPARATOR,
            self::TYPE_COMPLEX,
        ];
    }
}
