<?php

namespace App\Http\Controllers;

use App\Grids\LibrariesGridInterface;
use App\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param LibrariesGridInterface $LibrariesGrid
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(LibrariesGridInterface $LibrariesGrid, Request $request)
    {
        return $LibrariesGrid->create(['query' => Library::where('user_id', Auth::user()->id), 'request' => $request])->renderOn('books.books_list'); // render the grid on the welcome view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( )
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        //
        $item = new Library();
        $item->user_id = Auth::user()->id;
        $item->book_id = $request->get('id');

        $item->save();

        return back() ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show(Library $library)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Library $library)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {

        $library->where([
            ['user_id', '=', Auth::user()->id],
            ['id', '=', request()->get('library') ]
        ])->delete();

        return back();
    }
}
