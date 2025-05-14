<?php

/**
 * @copyright Copyright (c) 2016 www.magebuzz.com
 */

namespace Discretelogix\CustomWidget\Block\Adminhtml\Widget;

Class Editor extends \Magento\Backend\Block\Template
{
    protected $wysiwygConfig;
    protected $factoryElement;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        $data = []
    ) {
        $this->factoryElement = $factoryElement;
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $data);
    }

    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $editor = $this->factoryElement->create('editor', ['data' => $element->getData()])
            ->setLabel('')
            ->setForm($element->getForm())
            ->setWysiwyg(true)
            ->setConfig(
                $this->wysiwygConfig->getConfig([
                    'add_variables' => false,
                    'add_widgets' => false,
                    'add_images' => true
                ])
            );

        if ($element->getRequired()) {
            $editor->addClass('required-entry');
        }
        $element->setData('after_element_html', $editor->getElementHtml());
        $element->setValue(''); // Hides the additional label that gets added.
        return $element;
    }
}
