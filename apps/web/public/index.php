<?php

declare(strict_types=1);

use ECommerce\Apps\Web\WebKernel;

require_once dirname(__DIR__) . '/../../vendor/autoload_runtime.php';

return function (array $context) {
    return new WebKernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
