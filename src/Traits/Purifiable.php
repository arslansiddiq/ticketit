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
        // $this->html = Purifier::clean($rawHtml, TSetting::grab('purifier_config'));
        $this->html = $rawHtml;
        return $this;
    }
}
