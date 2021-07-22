<?php

it('has livewire/createbreaktimelivewire page', function () {
    $response = $this->get('/livewire/createbreaktimelivewire');

    $response->assertStatus(200);
});
