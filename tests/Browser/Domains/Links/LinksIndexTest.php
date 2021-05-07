<?php

namespace Tests\Browser\Domains\Links;

use Domains\Links\Database\Factories\LinkFactory;
use Tests\DuskTestCase;

class LinksIndexTest extends DuskTestCase
{
    /** @test */
    public function it_shows_links()
    {
        $links = LinkFactory::new()
            ->times(5)
            ->approved()
            ->create();

        $this->browse(function ($browser) use ($links) {
            $browser->visit('/links')
                ->assertSee('Links')
                ->assertSee('Recentes');

            foreach ($links as $link) {
                $browser->assertSee($link->title);
                $browser->assertSee($link->description);
            }
        });
    }
}
