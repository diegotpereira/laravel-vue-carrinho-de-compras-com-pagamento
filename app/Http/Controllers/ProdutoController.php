<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$produtos = Produto::all();
		$response = [
			'produtos' => $produtos
		];
		
		return response()->json($response, 200);
    }

	public function addNovo(Request $request)
	{
		$this->validate($request, [
			'imagePath' => 'required',
			'titulo' => 'required',
			'descricao' => 'required',
			'preco' => 'required',
		]);
		$input = $request->all();
		$exploded = explode(',', $request->imagePath);
		$decoded = base64_decode($exploded[1]);

		if (str_contains($exploded[0], 'jpeg')) {
			$extension = 'jpeg';
		} else {
			$extension = 'png';
		}
		$arquivoNome = str::random().'.'.$extension;
		$path = public_path().'/produtoImagens/'.$arquivoNome;
		file_put_contents($path, $decoded);

		$produto = new Produto([
			'imagePath' => $arquivoNome,
			'titulo' => $request->input('titulo'),
			'descricao' => $request->input('descricao'),
			'preco' => $request->input('preco')
		]);
		$produto->save();

		return response()->json(['produto' => $produto], 201);
	}
	public function EditarProduto(Request $request, $id)
	{
		$produto = Produto::find($id);

		if (file_exists(public_path().'/produtoImagens/'.$request->imagePath)) {
			$produto->imagePath = $request->input('imagePath');
			$produto->titulo = $request->input('titulo');
			$produto->descricao = $request->input('descricao');
			$produto->preco = $request->input('preco'); 
		} else {
			unlink(public_path().'/produtoImagens/'.$produto->imagePath);

			$exploded = explode(',', $request->imagePath);
			$decoded = base64_decode($exploded[1]);

			if (str_contains($exploded[0], 'jpeg')) {
				$extension = 'jpeg';
			} else {
				$extension = 'png';
			}
			$arquivoNome = str::random().'.'.$extension;
			$path = public_path().'/produtoImagens/'.$arquivoNome;
			file_put_contents($path, $decoded);

			$produto->imagePath = $arquivoNome;
			$produto->titulo = $request->input('titulo');
			$produto->descricao = $request->input('descricao');
			$produto->preco = $request->input('preco');
		}
		$produto->save();

		return response()->json(['produto' => $produto], 200);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
