<?php

namespace App\Widgets;

use App\Models\Article;
use Arrilot\Widgets\AbstractWidget;

class HotlogWidget extends AbstractWidget
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

        return view("widgets.hotlog_widget", [
            'config' => $this->config,
        ])->withArticles(Article::select('id', 'title')->orderBy('reads', 'DESC')->limit(isset($this->config['index_hotlognum']) ? $this->config['index_hotlognum'] : 10)->get(['id', 'title']));
    }
}
