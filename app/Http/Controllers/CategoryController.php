<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where("user_id", Auth::id())->get();
        return $this->sendData($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $category = Category::create($data);
        if ($category){
            return $this->sendMessage("Categoria criada com sucesso", $category);
        }else{
            return $this->sendError("Erro ao criar a categoria");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!isset($category)){
            return $this->sendError("Categoria não encontrada", Response::HTTP_NOT_FOUND);
        }
        if ($category->user_id != Auth::id()) {
            return $this->sendError("Categoria não pode ser visualizada", Response::HTTP_FORBIDDEN);
        }

        return $this->sendData($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!isset($category)){
            return $this->sendError("Categoria não encontrada", Response::HTTP_NOT_FOUND);
        }
        if ($category->user_id != Auth::id()) {
            return $this->sendError("Categoria não pode ser alterada", Response::HTTP_FORBIDDEN);
        }

        $data = $request->validated();
        $success = $category->update($data);

        if ($success){
            return $this->sendMessage("Categoria alterada com sucesso");
        } else {
            return $this->sendError("Erro ao alterar a Categoria") ;
        }
        return $this->sendData($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!isset($category)){
            return $this->sendError("Categoria não encontrada", Response::HTTP_NOT_FOUND);
        }
        if ($category->user_id != Auth::id()) {
            return $this->sendError("Categoria não pode ser removida", Response::HTTP_FORBIDDEN);
        }

        $success = $category->delete();

        if ($success){
            return $this->sendMessage("Categoria removida com sucesso");
        } else {
            return $this->sendError("Erro ao remover a Categoria") ;
        }
        return $this->sendData($category);
    }
}
