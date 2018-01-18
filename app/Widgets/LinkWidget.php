<?php

namespace App\Widgets;

use App\Models\Link;
use Arrilot\Widgets\AbstractWidget;

class LinkWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view("widgets.link_widget", [
            'config' => $this->config,
        ])->withLinks(Link::where('hide', 0)->get(['sitename', 'siteurl']));
    }
}
