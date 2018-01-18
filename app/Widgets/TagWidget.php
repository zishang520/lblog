<?php

namespace App\Widgets;

use App\Models\Tag;
use Arrilot\Widgets\AbstractWidget;

class TagWidget extends AbstractWidget
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
        return view("widgets.tag_widget", [
            'config' => $this->config,
        ])->withTags(Tag::all(['id', 'slug']));
    }
}
