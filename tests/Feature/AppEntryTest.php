<?php

namespace Tests\Feature;

it('has app entry page', function () {
    $this->get('/')->assertOk();
});
