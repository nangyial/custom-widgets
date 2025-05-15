<?php
/*
 * Copyright © Websolute spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Discretelogix\CustomWidget\Plugin;

use Magento\Widget\Model\Widget as MagentoWidget;

class Widget
{
    public function beforeGetWidgetDeclaration(
        MagentoWidget $subject,
        $type,
        $params = [],
        $asIs = true
    ): array
    {
        foreach ($params as $name => $value) {
            if(!is_array($value)){
                if (preg_match('/(___directive\/)([a-zA-Z0-9,_-]+)/', $value, $matches)) {
                    $directive = base64_decode(strtr($matches[2], '-_,', '+/='));
                    $params[$name] = str_replace(['{{media url="', '"}}'], ['', ''], $directive);
                }
            }
        }

        return [$type, $params, $asIs];
    }
}