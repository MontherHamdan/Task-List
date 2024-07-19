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

//route for main page
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

//route for show all tasks
Route::get('/tasks', function () {
    // get all records but order by latest
    $task = Task::latest()->paginate(10);

    return view(
        'index',
        ['tasks' => $task]
    );
})->name('tasks.index');


// route for form page to create task
Route::view('/tasks/create', 'create')
    ->name('tasks.create');







//route to edit individual task
// Route::get('/tasks/{id}/edit', function ($id) {

//     // find by id but return 404 page when not found the id
//     $task = Task::findOrFail($id);

//     return view('edit', [
//         'task' => $task
//     ]);
// })->name('tasks.edit');

// INSTEAD OF PUT $ID like in the method above to find a record by id 
// we can this way and automatically laravel will replace the $task with the primary key in the table

//route to edit individual task
Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');


//route to show individual task
Route::get('/tasks/{task}', function (Task $task) {
    return view('show', [
        'task' => $task
    ]);
})->name('tasks.show');


//route for store create tasks method
Route::post('/tasks', function (TaskRequest $request) {
    // $data = $request->validate([
    //     'title' => 'required|max:255',
    //     'description' => 'required',
    //     'long_description' => 'required'
    // ]);
    // will replace this with TaskRequest class

    // $data = $request->validated();
    // $task = new Task;
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();
    // instead of all of that lines to create row in database you can do create() function
    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task created successfully');
})->name('tasks.store');


//route for update task method
Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    // $data = $request->validated();
    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];
    // $task->save();

    // update method instead of the lines above
    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task updated successfully');
})->name('tasks.update');


// route for delete record
Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success', 'task deleted successfully');
})->name('tasks.destroy');

// route for put a task as completed
Route::put('/tasks/{task}/toggle-complete', function (Task $task) {
    $task->toggleCompleted();

    return redirect()->back()
        ->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');
