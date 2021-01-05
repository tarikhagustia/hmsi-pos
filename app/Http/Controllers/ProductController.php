<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Product;
use Illuminate\Support\Facades\Auth;
use App\ProductStock;

class ProductController extends Controller
{
    public function __construct()
    {
        $isEdting = preg_match('/edit/', request()->url());

        request()->isEditing = false;

        if ($isEdting) {
           request()->isEditing = true;
        }
    }

    public function rules(array $request = [], array $except = [])
    {
        request()->request->set('price', (float) str_replace('.', '', request()->price));
        request()->request->set('buy_price', (float) str_replace('.', '', request()->price));

        $rules = [
            'category_id' => 'required|exists:product_categories,id',
            'sku' => 'required|unique:products',
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric|min:1',
            'buy_price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:0',
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {
            $rules['sku'] = 'required|unique:products,sku,'. request()->route('product')->id;
        }

        if (request()->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,jpeg,png';
        }

        $rules = array_merge($rules, $request);

        $rules = collect($rules)->except($except)->toArray();

        return $rules;
    }

    public function index()
    {
        $products = Product::with(['category'])
            ->when(Auth::user()->branch_id, function ($q){
                $q->where('branch_id', Auth::user()->branch_id);
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%'.request()->search.'%')
                    ->orWhere('sku', 'like', '%'.request()->search.'%')
                    ->orWhere('desc', 'like', '%'.request()->search.'%');
            })
            ->whereHas('category', function ($query) {
                return $query->orWhere('name', 'like', request()->search.'%');
            })
            ->paginate(25);

        $products->appends(['search' => request()->search]);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create_edit');
    }

    public function store()
    {
        $this->validate(request(), $this->rules());

        $data = request()->only(array_keys($this->rules([], ['image'])));

        if (request()->hasFile('image')) {
            $filename = 'IMG_'.strtoupper(Str::random(10)).'_'.date('YmdHis').'.'.request()->file('image')->getClientOriginalExtension();

            $data['image'] = request()->file('image')->storeAs('images/products', $filename);
        }
        $data['branch_id']= Auth::user()->branch_id;

        $p = Product::create($data);

        ProductStock::create([
            'product_id' => $p->id,
            'branch_id' => $p->branch_id,
            'qty' => $p->stock,
        ]);

        session()->flash('success', 'Data produk telah ditambah.');

        return redirect(route('products.index'));
    }

    public function edit(Product $product)
    {
        if (is_null($product)) {
            abort(404);
        }

        return view('product.create_edit', compact('product'));
    }

    public function update(Product $product)
    {
        $this->validate(request(), $this->rules());

        $data = request()->only(array_keys($this->rules([], ['image'])));

        if (request()->hasFile('image')) {
            $filename = 'IMG_'.strtoupper(Str::random(10)).'_'.date('YmdHis').'.'.request()->file('image')->getClientOriginalExtension();

            $data['image'] = request()->file('image')->storeAs('images/products', $filename);
        }

        $product->update($data);

        session()->flash('success', 'Data produk telah diperbarui.');

        return redirect(route('products.index'));
    }

    public function destroy(Product $product)
    {
        if (is_null($product)) {
            abort(404);
        }

        $product->delete();

        session()->flash('success', 'Data produk telah dihapus.');

        return redirect(route('products.index'));
    }

    public function inactive(Product $product)
    {
        $product->inactive();
        return redirect()->back()->withSuccess('Data Produk telah di Nonaaktifkan');
    }

    public function publish(Product $product)
    {
        $product->publish();
        return redirect()->back()->withSuccess('Data Produk telah di Publish');

    }

}
