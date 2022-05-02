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
	public function DeletarProduto($id)
	{
		$produto = Produto::find($id);
		unlink(public_path().'/produtoImagens/'.$produto->imagePath);

		$produto->delete();

		return response()->json(['message' => 'O produto foi deletado', 200]);
	}
	public function getCarrinhoItens(Request $request, $id)
	{
		$produto = Produto::find($id);

		return response()->json(['produto' => $produto], 200);
	}
}
