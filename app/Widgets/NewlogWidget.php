<?php

namespace App\Widgets;

use App\Models\Article;
use Arrilot\Widgets\AbstractWidget;

class NewlogWidget extends AbstractWidget
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

        return view("widgets.newlog_widget", [
            'config' => $this->config,
        ])->withArticles(Article::select('id', 'title')->orderBy('id', 'DESC')->limit(isset($this->config['index_newlog']) ? $this->config['index_newlog'] : 10)->get(['id', 'title']));
    }
}
