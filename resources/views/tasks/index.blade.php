<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>Laravel Quickstart - Intermediate</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
//    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link href="bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Task List
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
            <div class="col-sm-offset-2 col-sm-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        New TaskList
                    </div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- New List Form -->
                        <form action="{{ url('list') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <!-- List Name -->
                            <div class="form-group">
                                <label for="list-name" class="col-sm-3 control-label">List</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="list-name" class="form-control" value="{{ old('list') }}">
                                </div>
                            </div>
                            <!-- Add List Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-btn fa-plus"></i>Add List
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        New Task
                    </div>

                    <div class="panel-body">
                        <!-- Display Validation Errors -->
                        @include('common.errors')

                        <!-- New Task Form -->
                        <form action="{{ url('task') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <!-- Task Name -->
                            <div class="form-group">
                                <label for="task-name" class="col-sm-3 control-label">Task</label>

                                <div class="col-sm-6">
                                    <input type="text" name="name" id="task-name" class="form-control" value="{{ old('task') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="task-description" class="col-sm-3 control-label">Description</label>

                                <div class="col-sm-6">
                                    <input type="text" name="description" id="task-description" class="form-control" value="{{ old('description') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="list-name" class="col-sm-3 control-label">List</label>

                                <div class="col-sm-6">
                                    <select class="form-control" id="list-selector" name="list_id">
                                    @foreach ($taskLists as $list)
                                        <option>{{ $list->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Add Task Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-btn fa-plus"></i>Add Task
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @foreach ($taskLists as $list)
                <!-- Current Tasks -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Current Tasks :{{ $list->name}}
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                <thead>
                                    <th>Task</th>
                                    <th>Description</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        @if( $task->list_id == $list->id)
                                        <tr>
                                            <td class="table-text"><div>{{ $task->name }}</div></td>
                                            <td class="table-text"><div>
                                                <a href="#" class="editable editable-click"
                                                  data-type="text" data-pk="1" data-url="task/{{ $task->id }}/update_description"
                                                  data-title="Enter description">{{ $task->description }}</a>
                                            </div></td>

                                            <td>
                                                <form action="changelist/{{ $task->id }}" method="POST" class="form-horizontal">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            <select class="form-control" name="list_id">
                                                            @foreach ($taskLists as $list2)
                                                                @if($list2->id == $task->list_id)
                                                                    <option selected="selected">{{ $list2->name }}</option>
                                                                @else
                                                                    <option>{{ $list2->name }}</option>
                                                                @endif
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-default">
                                                                <i class="fa fa-btn fa-plus"></i>Change List
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>

                                            <!-- Task Delete Button -->
                                            <td>
                                                <form action="{{url('task/' . $task->id)}}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

                                                    <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Delete
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    <!-- JavaScripts -->
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="bootstrap-editable/js/bootstrap-editable.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script type="text/javascript" src="js/tasks.js"></script>
</body>
</html>
