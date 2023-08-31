<?php

namespace Tests\Feature;

use function Pest\Laravel\get;

it('has app entry page', function () {
    get('/')->assertOk();
});
