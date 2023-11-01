<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/tasks-not-completed', function () {
    return view('index', [
        'tasks' => Task::where('completed', false)->latest()->paginate(10),
        'show_comp' => false
        // 'tasks' => Task::all()->sortByDesc('updated_at')
        //'tasks' => \App\Models\Task::latest()->get()
        // 'tasks' => Task::where('completed', true)->get()
    ]);
})->name('tasks.index-not-completed');

Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->paginate(10),
        'show_comp' => true
        // 'tasks' => Task::all()->sortByDesc('updated_at')
        //'tasks' => \App\Models\Task::latest()->get()
        // 'tasks' => Task::where('completed', true)->get()
    ]);
})->name('tasks.index');

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::view('/tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');

Route::get('/tasks/{task}/{show_comp?}', function (Task $task, $show_comp=0) {
    return view('show', [
        'task' => $task,
        'show_comp'=> $show_comp
    ]);
})->name('tasks.show');


Route::post('/tasks', function (TaskRequest $request) {
    // daca am ajuns aici inseamna ca request a fost validat, altfel ar fi iesit
    // $data = $request->validated();
    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];

    // $task->save();
    //Varianta mai scurta:
    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    // $data = $request->validated();
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task updated successfully!');
})->name('tasks.update');

Route::delete('/tasks/{task}/{show_comp?}', function (Task $task, $show_comp=0) {
    $task->delete();
    if ($show_comp) {
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    } else {
        return redirect()->route('tasks.index-not-completed')
            ->with('success', 'Task deleted successfully.');
    }
})->name('tasks.destroy');

Route::get('/delete-all', function () {
    $tasks = Task::get();
    foreach( $tasks as $task ){
        $task->delete();
    }

    return redirect()->route('tasks.index')
        ->with('success', 'All tasks deleted successfully.');
})->name('tasks.destroy-all');

Route::get('/delete-completed', function () {
    $tasks = Task::where('completed', true)->get();
    foreach( $tasks as $task ){
        $task->delete();
    }

    return redirect()->route('tasks.index')
        ->with('success', 'Completed tasks deleted successfully.');
})->name('tasks.destroy-completed');

Route::put('tasks/{task}/toogle-complete', function (Task $task) {
    $task->toggleComplete(); //method in model class
    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle');

Route::fallback(function () {
    return 'Still got somewhere!';
});