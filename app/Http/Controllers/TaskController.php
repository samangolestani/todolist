<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\TaskList;
use App\Repositories\TaskRepository;
use App\Repositories\TaskListRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;
    protected $taskLists;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks, TaskListRepository $taskLists)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
        $this->taskLists = $taskLists;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
            'taskLists' => $this->taskLists->forUser($request->user())
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'list_id' => 'required'
        ]);
        $list_id = TaskList::where('name', '=', $request->list_id)->get()[0]->id;
        $task = new Task;

        $task->name = $request->name;
        $task->description = $request->description;
        $task->list_id = $list_id;
        $task->user_id = $request->user()->id;

        $task->save();

        return redirect('/tasks');
    }

    public function updateDescription(Request $request,$id)
    {
//        App\Task::where('name', $request->name)
//                  ->update(['description' => $request->description]);
        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
