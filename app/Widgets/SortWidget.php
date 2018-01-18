<?php

namespace App\Widgets;

use App\Models\Sort;
use Arrilot\Widgets\AbstractWidget;

class SortWidget extends AbstractWidget
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

        return view("widgets.sort_widget", [
            'config' => $this->config,
        ])->withSorts(Sort::select('id', 'sortname')->orderBy('taxis', 'ASC')->orderBy('lft', 'ASC')->orderBy('rgt', 'DESC')->get(['id', 'sortname']));
    }
}
