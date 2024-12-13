<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'project_id' => 'required|exists:projects,id'
        ]);

        $task = new Task();
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->project_id = $request->input('project_id');
        $task->user_id = auth()->user()->id;
        $task->save();

        return redirect()->route('projects.show', $task->project_id)->with('success', 'Tâche créée avec succès');
    }

    public function index(Project $project){
        $tasks = Task::where(['user_id' => auth()->user()->id, 'project_id' => $project->id])->get();
        return view('projects.show', compact('tasks'));
    }

    public function edit(Task $task)
    {
        // Vérifier que l'utilisateur est autorisé à modifier cette tâche
        if ($task->user_id !== auth()->user()->id) {
            abort(403);
        }
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        // Vérifier que l'utilisateur est autorisé à modifier cette tâche
        if ($task->user_id !== auth()->user()->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->save();

        return redirect()->route('projects.show', $task->project_id)
            ->with('success', 'Tâche modifiée avec succès');
    }

    public function destroy(Task $task){
        $task->delete();
        return redirect()->route('projects.show', $task->project_id);
    }

    public function showCreateForm()
    {
        $projects = Project::where('user_id', auth()->user()->id)->get();
        return view('tasks.create', compact('projects'));
    }
}
