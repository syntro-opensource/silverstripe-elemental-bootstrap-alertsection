<?php

namespace Syntro\SilverStripeElementalBootstrapAlertSection\Elements;

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\FieldList;
use DNADesign\Elemental\Models\BaseElement;
use BucklesHusky\FontAwesomeIconPicker\Forms\FAPickerField;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;

/**
 *  Bootstrap based alert section
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class AlertSection extends BaseElement
{
    /**
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @var string
     */
    private static $controller_template = 'SectionHolder';

    /**
     * @var string
     */
    private static $icon = 'font-icon-attention';

    /**
     * @var string
     */
    private static $table_name = 'ElementAlertSection';

    /**
     * @config
     * @var array
     */
    private static $colors = [
        'primary' => 'Primary',
        'success' => 'Success',
        'warning' => 'Warning',
        'danger' => 'Danger',
    ];

    /**
     * @config
     * @var array
     */
    private static $textColors = [
        'primary' => 'light',
        'success' => 'light',
        'warning' => 'light',
        'danger' => 'light',
    ];

    /**
     * @config
     * @var bool
     */
    private static $faIcons = true;

    private static $db = [
        'BackgroundColor' => 'Varchar(50)',
        'Content' => 'Text',
        'FAIcon' => 'Varchar(50)'
    ];

    private static $defaults = [
        'BackgroundColor' => 'primary'
    ];

    private static $many_many = [
        'Buttons' => Link::class
    ];

    private static $many_many_extraFields = [
        'Buttons' => [
            'Sort' => 'Int' // Required for all many_many relationships
        ]
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            /* @var FieldList $fields */
            $fields->dataFieldByName('Content')
                ->setRows(5);

            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create(
                    'BackgroundColor',
                    'Background Color',
                    $this->getColors()
                ),
                'Content'
            );

            if ($this->useIcons()) {
                $fields->addFieldToTab(
                    'Root.Main',
                    FAPickerField::create('FAIcon', 'Icon'),
                    'Content'
                );
            }  else {
                $fields->removeByName('FAIcon');
            }
            $fields->removeByName([
                'Buttons',
                'Root.Buttons'
            ]);
            $fields->addFieldToTab(
                'Root.Main',
                LinkField::create(
                    'Buttons',
                    'Buttons',
                    $this
                )
            );
            return $fields;
        });

        return parent::getCMSFields();
    }


    /**
     * getColors - returns a Map of named colors
     *
     * @return array
     */
    public function getColors()
    {
        $colors = $this->config()->get('colors');
        $selection = [];
        foreach ($colors as $key => $value) {
            $selection[$key] = _t(
                __CLASS__ . '.' . $key,
                $value
            );
        }
        return $selection;
    }

    /**
     * getTextColor - returns a suitable color for text and buttons.
     * if no color is defined, 'light' is returned.
     *
     * @return string
     */
    public function getTextColor()
    {
        $colors = $this->config()->get('textColors');

        if (isset($colors[$this->BackgroundColor])) {
            return $colors[$this->BackgroundColor];
        }

        return 'light';
    }

    /**
     * useIcons - simple getter for icon config
     *
     * @return bool
     */
    public function useIcons()
    {
        return $this->config()->get('faIcons');
    }


    /**
     * @return string
     */
    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Alert Section');
    }

    /**
     * ButtonHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function ButtonHolder()
    {
        return $this->renderWith('Syntro/BootstrapAlertSection/Elements/ButtonHolder');
    }

    /**
     * ContentHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function ContentHolder()
    {
        return $this->renderWith('Syntro/BootstrapAlertSection/Elements/ContentHolder');
    }

    /**
     * HeaderHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function HeaderHolder()
    {
        return $this->renderWith('Syntro/BootstrapAlertSection/Elements/HeaderHolder');
    }

    /**
     * IconHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function IconHolder()
    {
        return $this->renderWith('Syntro/BootstrapAlertSection/Elements/IconHolder');
    }
}
