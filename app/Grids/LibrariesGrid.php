<?php

namespace App\Grids;

use Closure;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Leantony\Grid\Grid;
use App\Books;

class LibrariesGrid extends Grid implements LibrariesGridInterface
{
    /**
     * The name of the grid
     *
     * @var string
     */
    protected $name = 'Libraries';

    /**
     * List of buttons to be generated on the grid
     *
     * @var array
     */
    protected $buttonsToGenerate = [
        'view',
        'delete'
    ];

    /**
     * Specify if the rows on the table should be clicked to navigate to the record
     *
     * @var bool
     */
    protected $linkableRows = false;

    /**
    * Set the columns to be displayed.
    *
    * @return void
    * @throws \Exception if an error occurs during parsing of the data
    */
    public function setColumns()
    {
        $this->columns = [
            "cover" => [
                "filter" => [
                    "enabled" => false
                ],
                "raw" => true,
                "data" => function($columnData, $columnName) {
                    // do whatever you want to display the data for the `name` column
                    $book = Books::find($columnData->book_id);

                    return view("layouts.img", [
                        "href" => $book->getImgUrl(),
                        "bookViewHref" => route('viewBook', ["book" =>$book->id]),
                    ]);
                },
                "export" => false
            ],
		    "book_name" => [
                "label" => "Book Name",
                "raw" => true,
                "data" => function($columnData, $columnName) {
                    $book = Books::find($columnData->book_id);
                    return  view('library.book_name', [
                        'route' =>route('viewBook', ["book" =>$book->id]),
                        "book_name" => $book->name ]
                    );
                },
                "filter" => [
                    "enabled" => true,
                    "type" => "date",
                    "operator" => "<="
                ],
		        "export" => true
		    ],
		    "created_at" => [
		        "label" => "Registered",
		        "sort" => false,
		        "date" => "true",
		        "filter" => [
		            "enabled" => true,
		            "type" => "date",
		            "operator" => "<="
		        ]
		    ]
		];
    }

    /**
     * Set the links/routes. This are referenced using named routes, for the sake of simplicity
     *
     * @return void
     */
    public function setRoutes()
    {
        // searching, sorting and filtering
        $this->setIndexRouteName('myLibrary');

        // crud support
        $this->setCreateRouteName('addTolLibrary');
        $this->setDeleteRouteName('removeFromLibrary');
        $this->setViewRouteName('viewBook');

        // default route parameter
        $this->setDefaultRouteParameter('id');
    }

    /**
    * Return a closure that is executed per row, to render a link that will be clicked on to execute an action
    *
    * @return Closure
    */
    public function getLinkableCallback(): Closure
    {
        return function ($gridName, $item) {
            return route($this->getViewRouteName(), [$gridName => $item->id]);
        };
    }

    /**
    * Configure rendered buttons, or add your own
    *
    * @return void
    */
    public function configureButtons()
    {
        // call `addRowButton` to add a row button
        // call `addToolbarButton` to add a toolbar button
        // call `makeCustomButton` to do either of the above, but passing in the button properties as an array

        // call `editToolbarButton` to edit a toolbar button
        // call `editRowButton` to edit a row button
        // call `editButtonProperties` to do either of the above. All the edit functions accept the properties as an array

        $this->editRowButton('delete', [
            'name' => 'Remove From Collection',
            'title' => 'Remove From Collection',
        ]);
        $this->editRowButton('view', [
            'name' => 'See the Book Review',
            'title' => 'See the Book Review',
            'url' => function($gridName, $gridItem) {
                return route('viewBook', ["book" => $gridItem->book_id]);
            },
        ]);
    }

    /**
    * Returns a closure that will be executed to apply a class for each row on the grid
    * The closure takes two arguments - `name` of grid, and `item` being iterated upon
    *
    * @return Closure
    */
    public function getRowCssStyle(): Closure
    {
        return function ($gridName, $item) {
            // e.g, to add a success class to specific table rows;
            // return $item->id % 2 === 0 ? 'table-success' : '';
            return "";
        };
    }
}
