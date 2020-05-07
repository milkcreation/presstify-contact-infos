<?php declare(strict_types=1);

namespace tiFy\Plugins\ContactInfos;

use tiFy\Container\ServiceProvider;

class ContactInfosServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        add_action('after_setup_theme', function () {
            $this->getContainer()->share('contact-infos', new ContactInfos($this->getContainer()->get('app')));
        });
    }
}