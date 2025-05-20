<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('category.index', [
            'categories' => category::Paginate(5)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // dd($request);

    $request->validate([
        'name' => 'required|string|max:255',
        'website' => 'nullable|url',
        'facebook' => 'nullable|string|max:255',
        'telegram' => 'nullable|string|max:255',
        'course_link' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
    ]);

   // Find the category
   $category = new Category();

    // Handle image upload
    if ($request->hasFile('image')) {
        // dd(1);
        $originalName = time()."_".$request->image->getClientOriginalName();
        $imagePath = $request->image->move(public_path('front/specialities'), $originalName);
        $category->image = $originalName;
    }

  $category->name = $request->name;
  $category->website = $request->website;
  $category->facebook = $request->facebook;
  $category->telegram = $request->telegram;
  $category->course_link = $request->course_link;
    // Save the category
    $category->save();
    //    return $category;
    // Redirect with success message
    return redirect()->route('categories')->with('success', 'Category updated successfully.');
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        return view('category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecategoryRequest  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecategoryRequest $request, $id)
    {
        $category = category::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c=category::find($id);
        $c->status='0';
        $c->save();
        // return $c;
        return redirect()->route('categories');
    }
}
