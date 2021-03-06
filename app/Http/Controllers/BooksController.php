<?php

namespace App\Http\Controllers;

use App\Grids\BooksGrid;
use App\Grids\BooksGridInterface;
use Illuminate\Http\Request;
use App\Books;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewBook(Request $request)
    {

        $book = Books::find($request->get('book'));

        $absolute_path = storage_path('app/public/') . $book->image;
        $image = Image::make($absolute_path)->resize(200, 300)->encode('data-url');

        return view('books.display', ['book' => $book, 'img' => $image]);
    }

    public function deleteBook(Request $request)
    {
        $id = $request->get("book");
        Books::find($id)->delete();

        return redirect()->route('showBooks');
    }

    /**
     * @param BooksGridInterface $BooksGrid
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function showBooks(BooksGridInterface $BooksGrid, Request $request)
    {
        // the 'query' argument needs to be an instance of the eloquent query builder
        // you can load relationships at this point
        return $BooksGrid->create(['query' => DB::table('books'), 'request' => $request])
            ->renderOn('books.books_list'); // render the grid on the welcome view
    }

    /**
     * Display Creation form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreationForm(Request $request)
    {

        return view('books.book_form', [
            "route" => route("uploadBook"),
            "action" => "Create"
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function patch(Request $request, $id)
    {
        $book = Books::find($id);

        return view('books.book_form', [
            "route" => route("uploadBook"),
            'book' => $book,
            'action' => 'Update',
            'img' => $book->getImgUrl()
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $req_data = $request->all();
        $this->validator($req_data)->validate();

        if($req_data["id"]){
            $Book = Books::find($req_data["id"]);
        }else{
            $Book = new Books();
        }

        $Book->name = $request->input('name');
        $Book->ISBN = $request->input('ISBN');
        $Book->year = $request->input('year');
        $Book->Description = $request->input('Description');

        // File name of cover
        $image_name = md5(implode("", [
            time(),
            $request->input('name'),
            $request->input('ISBN'),
            $request->input('year'),
            $request->input('description')
        ]));

        if (isset($request->file()["image"])) {
            $image_name .= "." . $request->file()["image"]->getClientOriginalExtension();
            $request->file()["image"]->storeAs("image/", $image_name, 'public');

            $Book->image = $image_name;
        }

        // store book
        $Book->save();

        return redirect()->route('showBooks');
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        return Validator::make($data, Books::getValidationRules($data["id"]?:null) );
    }
}
