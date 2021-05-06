<?php

namespace Tests\Browser\Domains\Links;

use App\Models\User;
use Database\Factories\UserFactory;
use Domains\Links\LinksServiceProvider;
use Domains\Tags\Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Collection;
use Tests\DuskTestCase;

class LinksSubmitTest extends DuskTestCase
{
    protected User $user;
    protected Collection $tags;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->withPersonalTeam()->create();
        $this->tags = TagFactory::new()->times(10)->create();
    }

    /** @test */
    public function it_shows_submit_form(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/submit-link')
                ->assertSee('TÍTULO')
                ->assertSee('NOME')
                ->assertSee('E-MAIL')
                ->assertSee('ENDEREÇO URL')
                ->assertSee('DESCRIÇÃO')
                ->assertSee('ETIQUETAS / TAGS')
                ->assertSee('Save');

            foreach ($this->tags as $tag) {
                $browser->assertSee($tag->name);
            }
        });
    }

    /** @test */
    public function it_doesnt_show_name_nor_email_if_logged_in(): void
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)
                ->visit('/submit-link')
                ->screenshot('submitllink')
                ->assertSee('TÍTULO')
                ->assertDontSee('NOME')
                ->assertDontSee('E-MAIL')
                ->assertSee('ENDEREÇO URL')
                ->assertSee('DESCRIÇÃO')
                ->assertSee('ETIQUETAS / TAGS')
                ->assertSee('Save');
        });
    }

    /** @test */
    public function it_submits_a_link(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/submit-link')
                ->type('#title', 'Title')
                ->type('#author_name', 'Say my name')
                ->type('#author_email', 'say.my@name.now')
                ->type('#description', 'Some long descriiiiiiiiiption')
                ->check('tags[' . random_int(1, $this->tags->count()) . ']')
                ->type('#link', 'https://www.google.com')
                ->keys('#link', '{tab}')
                ->waitForText('upload another cover image', 30)
                ->press('#submit')
                ->waitUntilMissing('#submit')
                ->assertPathIs(route(name: LinksServiceProvider::getName() . '::index', absolute: false));
        });
    }
}
