<?php

declare(strict_types=1);

use App\Presentation\Action\DiscountAction;
use Slim\App;

return static function (App $app): void {
    $app->post('/', DiscountAction::class);
};
