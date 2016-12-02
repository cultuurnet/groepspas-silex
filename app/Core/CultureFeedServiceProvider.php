<?php

namespace CultuurNet\GroepsPas\Core;

use CultureFeed_Uitpas_Default;
use CultuurNet\UiTIDProvider\CultureFeed\CultureFeedServiceProvider as CultureFeedServiceProviderOriginal;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Provides all services for the message bus.
 */
class CultureFeedServiceProvider extends CultureFeedServiceProviderOriginal implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $pimple)
    {
        parent::register($pimple);

        // Set culturefeed_token_credentials to null so we don't have to inject UserServiceProvider and SessionServiceProvider.
        $pimple['culturefeed_token_credentials'] = null;

        // Register culturefeed_uitpas.
        $pimple['culturefeed_uitpas'] = function (Container $pimple) {
          return new CultureFeed_Uitpas_Default($pimple['culturefeed']);
        };
    }
}
