<?php

namespace App\Http\Controllers;

use App\Models\Porto;
use App\Http\Requests\StorePortoRequest;
use App\Http\Requests\UpdatePortoRequest;

class PortoController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Porto::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.porto.gallery.index', $item->id) . '">
                            Gallery
                        </a>
                        <a class="inline-block border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" 
                            href="' . route('dashboard.porto.edit', $item->id) . '">
                            Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.porto.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.porto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.porto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePortoRequest $request)
    {
        $data = $request->all();

        porto::create($data);

        return redirect()->route('dashboard.porto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\porto  $porto
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(porto $porto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\porto  $porto
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(porto $porto)
    {
        $category = Categories::all();

        return view('pages.dashboard.porto.edit',[
            'item' => $porto,
            'categories' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\porto  $porto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(portoRequest $request, porto $porto)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        
        $porto->update($data);

        return redirect()->route('dashboard.porto.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\porto  $porto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(porto $porto)
    {
        $porto->delete();

        return redirect()->route('dashboard.porto.index');
    }
}
