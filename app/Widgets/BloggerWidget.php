<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class BloggerWidget extends AbstractWidget
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

        return view("widgets.blogger_widget", [
            'config' => $this->config,
        ]);
    }
}