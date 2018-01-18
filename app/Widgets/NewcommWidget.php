<?php

namespace App\Widgets;

use App\Models\Comment;
use Arrilot\Widgets\AbstractWidget;

class NewcommWidget extends AbstractWidget
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

        return view("widgets.newcomm_widget", [
            'config' => $this->config,
        ])->withComments(Comment::select('id', 'article_id', 'nickname', 'content')->orderBy('id', 'DESC')->limit(isset($this->config['index_comnum']) ? $this->config['index_comnum'] : 10)->where('hide', 0)->get(['id', 'article_id', 'nickname', 'content']));
    }
}
