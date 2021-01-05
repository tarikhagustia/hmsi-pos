<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
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
        $rules = [
            'name' => 'required|unique:product_categories',
            'desc' => 'required',
        ];

        $rules = array_merge($rules, $request);

        $rules = collect($rules)->except($except)->toArray();

        return $rules;
    }

    public function index()
    {
        $categories = ProductCategory::where(function ($query) {
            $query->where('name', 'like', '%'.request()->search.'%')
                ->orWhere('desc', 'like', '%'.request()->search.'%');
        })
            ->when(Auth::user()->branch_id, function ($q){
                $q->where('branch_id', Auth::user()->branch_id);
            })
        ->paginate(25);

        $categories->appends(['search' => request()->search]);

        return view('product_category.index', compact('categories'));
    }

    public function create()
    {
        return view('product_category.create_edit');
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $data = $request->only(array_keys($this->rules()));
        $data['branch_id']= Auth::user()->branch_id;

        ProductCategory::create(
            $data
        );

        session()->flash('success', 'Data produk kategori telah ditambah.');

        return redirect(route('product-categories.index'));
    }

    public function edit(ProductCategory $productCategory)
    {
        if (is_null($productCategory)) {
            abort(404);
        }

        return view('product_category.create_edit', compact('productCategory'));
    }

    public function update(ProductCategory $productCategory)
    {
        $this->validate(request(), $this->rules([
            'name' => 'required|unique:product_categories,name,'.$productCategory->id,
        ]));

        $productCategory->update(
            request()->only(array_keys($this->rules()))
        );

        session()->flash('success', 'Data produk kategori telah diperbarui.');

        return redirect(route('product-categories.index'));
    }

    public function destroy(ProductCategory $productCategory)
    {
        if (is_null($productCategory)) {
            abort(404);
        }

        $productCategory->delete();

        return redirect(route('product-categories.index'));
    }

    public function inactive(ProductCategory $productCategory)
    {
        $productCategory->inactive();
        return redirect()->back()->withSuccess('Data Produk telah di Nonaaktifkan');
    }

    public function publish(ProductCategory $productCategory)
    {
        $productCategory->publish();
        return redirect()->back()->withSuccess('Data Produk telah di Publish');

    }
}
