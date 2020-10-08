<?php

namespace Syntro\SilverStripeElementalBootstrapAlertSection\Elements;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
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
     * This defines the block name in the CSS
     *
     * @config
     * @var string
     */
    private static $block_name = 'alert-section';

    /**
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @var string
     */
    private static $icon = 'elemental-icon-alert';

    /**
     * @var string
     */
    private static $table_name = 'ElementAlertSection';

    /**
     * @var string
     */
    private static $controller_template = 'AlertSectionHolder';

    /**
     * if set to false, no Icons will be displayed
     *
     * @config
     * @var bool
     */
    private static $use_fa_icons = true;

    /**
     * set to false if image option should not show up
     *
     * @config
     * @var bool
     */
    private static $allow_image_background = false;


    private static $add_default_background_color = false;

    /**
     * Available background colors for this Element
     *
     * @config
     * @var array
     */
    private static $background_colors = [
        'danger' => 'Danger (red)',
        'warning' => 'Warning (yellow)',
        'success' => 'Success (green)',
        'primary' => 'Primary',
    ];

    /**
     * Color mapping from background color. This is mainly intended
     * to set a default color on the section-level, ensuring text is readable.
     * Colors of subelementscan be added via templates
     *
     * @config
     * @var array
     */
    private static $text_colors_by_background = [
        'danger' => 'light',
        'warning' => 'dark',
        'success' => 'light',
        'primary' => 'light',
    ];

    private static $link_colors_by_text = [];


    private static $db = [
        'Content' => 'Text',
        'DisplayIcon' => 'Boolean',
        'FAIcon' => 'Varchar(50)'
    ];

    private static $defaults = [
        'BackgroundColor' => 'danger',
        'DisplayIcon' => false
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
                ->setRows(5)
                ->setTitle(_t(
                    __CLASS__ . '.CONTENT',
                    'Content'
                ));

            $fields->removeByName([
                'Buttons',
                'Root.Buttons'
            ]);
            $fields->addFieldToTab(
                'Root.Main',
                LinkField::create(
                    'Buttons',
                    _t(
                        __CLASS__ . '.BUTTONS',
                        'Buttons'
                    ),
                    $this
                )
            );
            // add a dropdown with available colors
            $fields->removeByName('BackgroundColor');
            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create(
                    'BackgroundColorLabel',
                    _t(
                        __CLASS__ . '.COLOR',
                        'Color'
                    ),
                    $this->getTranslatedOptionsFor('background_colors', false)
                ),
                'Content'
            );

            // Add icon Field
            $fields->removeByName([
                'FAIcon',
                'DisplayIcon'
            ]);
            if ($this->useIcons()) {
                $fields->addFieldsToTab(
                    'Root.Main',
                    [
                        CheckboxField::create(
                            'DisplayIcon',
                            _t(
                                __CLASS__ . '.DISPLAYICON',
                                'Display icon'
                            )
                        ),
                        $iconField = FAPickerField::create(
                            'FAIcon',
                            _t(
                                __CLASS__ . '.ICON',
                                'Icon'
                            )
                        ),
                    ]
                );
                $iconField->hideUnless('DisplayIcon')->isChecked();
            }
        });

        return parent::getCMSFields();
    }

    /**
     * useIcons - simple getter for icon config
     *
     * @return bool
     */
    public function useIcons()
    {
        return $this->config()->get('use_fa_icons');
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
}
