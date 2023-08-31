<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Work;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Visit;

class DashboardController extends Controller
{
    public function index()
    {
        // $visits = DB::select('SELECT YEAR(created_at) as year,MONTH(created_at) as month, SUM(visits_count) AS count FROM `visits` GROUP BY month');
        $visits = Visit::selectRaw('YEAR(created_at) as year,MONTH(created_at) as month, SUM(visits_count) AS count')
            ->groupBy('month')
            ->get();
        return response()->json([
            'cards' => [
                'blogsCount' => $this->getBlogsCount(),
                'worksCount' => $this->getWorksCount(),
                'messagesCount' => $this->getMessagesCount(),
                'visitsCount' => $this->getVisitsCount()
            ],
            'visits' => $visits
        ]);
    } //end of index


    private function getBlogsCount()
    {
        return Blog::count();
    } //end of getBlogsCount


    private function getWorksCount()
    {
        return Work::count();
    } //end of getWorksCount


    private function getMessagesCount()
    {
        return Message::count();
    } //end of getMessagesCount


    private function getVisitsCount()
    {
        return Visit::sum('visits_count');
    } //end of getVisitsCount
}
