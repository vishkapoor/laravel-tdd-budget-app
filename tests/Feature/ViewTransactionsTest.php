<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTransactionsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = factory('App\Models\Transaction')->create();

        $this->get('/transactions')->assertSeeText($transaction->description);

    }
}
