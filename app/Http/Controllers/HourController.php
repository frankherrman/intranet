<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Hour;
use App\Models\HourType;
use App\Models\OverheadType;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HourController extends Controller
{
    public function entry(Request $request, $date) {
        $dates = [];
        $today = $date;
        if(empty($today)) {
            $today = Carbon::now();
        } else {
            $today = Carbon::createFromFormat('Y-m-d', $today);
        }

        $dates[] = [
            'date' => $today->copy()->startOfWeek(),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[0]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[1]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[2]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[3]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[4]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];
        $dates[] = [
            'date' => $dates[5]['date']->copy()->addDay(1),
            'hours_registered' => 0,
            'hours_total' => 8
        ];

        $prev_week = $today->copy()->addDay(-7);
        $next_week = $today->copy()->addDay(7);

        // get data for select boxes
        $projects = Project::where('open', 1)
            ->select(['id', 'name'])
            ->get();

        $project_ids = [];
        foreach($projects as $project) {
            $project_ids[] = $project->id;
        }
        $activities = [];
        if(!empty($project_ids)) {
            $activities = Activity::whereIn('project_id', [$project_ids])
                ->select(['project_id', 'department_id', 'budget', 'name'])
                ->orderBy('name', 'ASC')
                ->get();
        }

        $types = HourType::select(['id', 'department_id', 'name'])
            ->orderBy('department_id', 'asc')
            ->orderBy('name', 'ASC')
            ->get();

        $overhead_types = OverheadType::select(['id', 'name'])->get();

        return Inertia::render('Timesheet/Entry', compact(['dates', 'prev_week', 'next_week', 'projects','activities','types','overhead_types']));
    }
}
