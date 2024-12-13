<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function create(){
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|min:5',
            'start_date' => 'date',
            'end_date' => 'date',
        ]);

        $project = new Project();
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->start_date = $request->input('start_date');
        $project->end_date = $request->input('end_date');
        $project->user_id = auth()->user()->id;
        $project->save();

        return redirect()->route('projects');
    }

    public function index()
    {
        $projects = Project::where('user_id', auth()->user()->id)->get();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->save();

        return redirect()->route('projects.show', $project->id);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }

}
