<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProductFormRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product, $totalPage = 10;
    private $path = 'products';

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {
        $products = $this->product->getResults($request->all(), $this->totalPage);

        return response()->json($products);
    }

    public function store(StoreUpdateProductFormRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $name = Str::kebab($request->name);
            $extension = $request->imagem->extension();

            $nameFile = "{$name}.{$extension}";
            $data['imagem'] = $nameFile;

            $upload = $request->imagem->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['erro' => 'Fail_Upload'], 500);
        }

        $product = $this->product->create($data);

        return response()->json($product, 201);
    }

    public function show($id)
    {
        if (!$product = $this->product->with(['category'])->find($id))
            return response()->json(['erro' => 'Not Found'], 404);

        return response()->json($product);
    }

    public function update(StoreUpdateProductFormRequest $request, $id)
    {
        if (!$product = $this->product->find($id))
            return response()->json(['erro' => 'Not Found'], 404);

        $data = $request->all();

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

            if ($product->imagem)
                if (Storage::exists("{$this->path}/{$product->imagem}"))
                    Storage::delete("{$this->path}/{$product->imagem}");


            $name = Str::kebab($request->name);
            $extension = $request->imagem->extension();

            $nameFile = "{$name}.{$extension}";
            $data['imagem'] = $nameFile;

            $upload = $request->imagem->storeAs($this->path, $nameFile);

            if (!$upload)
                return response()->json(['erro' => 'Fail_Upload'], 500);
        }

        $product->update($data);

        return response()->json($product);
    }

    public function destroy($id)
    {
        if (!$product = $this->product->find($id))
            return response()->json(['erro' => 'Not Found'], 404);

        if ($product->imagem)
            if (Storage::exists("{$this->path}/{$product->imagem}"))
                Storage::delete("{$this->path}/{$product->imagem}");

        $product->delete();

        return response()->json([], 204);
    }
}
