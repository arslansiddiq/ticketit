<?php

namespace Kordy\Ticketit\Traits;

use Kordy\Ticketit\Models\TSetting;
use Mews\Purifier\Facades\Purifier;

trait Purifiable
{
    /**
     * Updates the content and html attribute of the given model.
     *
     * @param string $rawHtml
     *
     * @return \Illuminate\Database\Eloquent\Model $this
     */
    public function setPurifiedContent($rawHtml)
    {
        $this->content = Purifier::clean($rawHtml, ['HTML.Allowed' => '']);
        $config = array (
          'HTML.SafeIframe' => 'true',
          'URI.SafeIframeRegexp' => '%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%',
          'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
          'URI.MungeResources' => true,
          'URI.AllowedSchemes' => 
          array (
            'http' => true,
            'https' => true,
            'mailto' => true,
            'data' => true,
            'cid' => true,
          ),
        );
        $this->html = Purifier::clean($rawHtml, $config);
        return $this;
    }
}
