<?php

namespace App\Widgets;

use App\Models\Article as Archive;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\DB;

class ArchiveWidget extends AbstractWidget
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

        return view("widgets.archive_widget", [
            'config' => $this->config,
        ])->withArchives(Archive::select(DB::raw('COUNT(id) AS num'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") AS created'))->groupBy('created')->get(['num', 'created']));
    }
}
