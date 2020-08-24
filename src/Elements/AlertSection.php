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
use Syntro\SilverStripeElementalBaseitems\Elements\BootstrapSectionBaseElement;

/**
 *  Bootstrap based alert section
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class AlertSection extends BootstrapSectionBaseElement
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
    private static $icon = 'font-icon-attention';

    /**
     * @var string
     */
    private static $table_name = 'ElementAlertSection';

    /**
     * set to false if image option should not show up
     *
     * @config
     * @var bool
     */
    private static $allow_image_background = false;

    /**
     * Available background colors for this Element
     *
     * @config
     * @var array
     */
    private static $background_colors = [
        'danger' => 'Danger',
        'warning' => 'Warning',
        'success' => 'Success',
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
        'warning' => 'light',
        'success' => 'light',
        'primary' => 'light',
    ];

    /**
     * @config
     * @var bool
     */
    private static $faIcons = true;

    private static $db = [
        'Content' => 'Text',
        'FAIcon' => 'Varchar(50)'
    ];

    private static $defaults = [
        'BackgroundColor' => 'danger'
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
            // add a dropdown with available colors
            $fields->removeByName('BackgroundColor');
            $fields->addFieldToTab(
                'Root.Main',
                DropdownField::create(
                    'BackgroundColor',
                    'Alert Color',
                    $this->getBackgroundColors()
                ),
                'FAIcon'
            );
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
        return $this->renderWith($this->getSubTemplate(__FUNCTION__));
    }

    /**
     * ContentHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function ContentHolder()
    {
        return $this->renderWith($this->getSubTemplate(__FUNCTION__));
    }

    /**
     * HeaderHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function HeaderHolder()
    {
        return $this->renderWith($this->getSubTemplate(__FUNCTION__));
    }

    /**
     * IconHolder - helperfunction to allow template-replacement
     *
     * @return string
     */
    public function IconHolder()
    {
        return $this->renderWith($this->getSubTemplate(__FUNCTION__));
    }
}
