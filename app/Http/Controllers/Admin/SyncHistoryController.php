<?php

namespace App\Http\Controllers\Admin;

use App\Models\CrawlHistory;
use Illuminate\Http\Request;

class SyncHistoryController extends Controller
{
    public function index() {
        $models = CrawlHistory::all();
        return view('admin.sync-history.index', compact('models'));
    }
}
