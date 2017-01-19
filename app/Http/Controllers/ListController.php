<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TaskList;

class ListController extends Controller
{
//    public function index(Request $request)
//    {
//        return
//    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
        ]);

        $request->user()->taskList()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }
}
