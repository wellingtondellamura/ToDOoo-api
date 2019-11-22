<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\TaskRequest;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return $this->sendData($tasks);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $category = Category::find($data['category_id']);
        if (!isset($category)){
            return $this->sendError("Erro ao cadastrar a Tarefa. A categoria seleciona não existe", Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $task = Task::create($data);
        if (isset($task)){
            return $this->sendMessage("Tarefa Cadastrada com Sucesso", $task);
        } else {
            return $this->sendError("Erro ao cadastrar a Tarefa");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (isset($task)){
            if ($task->user_id != Auth::id())
            {
                return $this->sendError("Tarefa não pode ser Visualizada",403) ;
            }

            return $this->sendData($task);
        } else {
            return $this->sendError("Tarefa Não Encontrada",404) ;
        }
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function done($id)
    {
        $task = Task::find($id);
        if (!isset($task)){
            return $this->sendError("Tarefa Não Encontrada",404) ;
        }
        if ($task->user_id != Auth::id())
        {
            return $this->sendError("Tarefa não pode ser alterada",403) ;
        }

        $task->done = true;
        $success = $task->save();
        if ($success){
            return $this->sendMessage("Tarefa alterada com sucesso");
        } else {
            return $this->sendError("Erro ao alterar a Tarefa") ;
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::find($id);

        if (!isset($task)){
            return $this->sendError("Tarefa Não Encontrada",404) ;
        }

        if ($task->user_id != Auth::id())
        {
            return $this->sendError("Tarefa não pode ser alterada",403) ;
        }

        $data = $request->validated();
        $success = $task->update($data);

        if ($success){
            return $this->sendMessage("Tarefa alterada com sucesso");
        } else {
            return $this->sendError("Erro ao alterar a Tarefa") ;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!isset($task)){
            return $this->sendError("Tarefa Não Encontrada",404) ;
        }

        if ($task->user_id != Auth::id())
        {
            return $this->sendError("Tarefa não pode ser removida",403) ;
        }


        $success = $task->delete();

        if ($success){
            return $this->sendMessage("Tarefa removida com sucesso");
        } else {
            return $this->sendError("Erro ao remover a Tarefa") ;
        }
    }
}
