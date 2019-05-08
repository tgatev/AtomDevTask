<?php

namespace App\Grids;

use Closure;
use Leantony\Grid\Grid;
use Leantony\Grid\Buttons\GenericButton;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Books;

class BooksGrid extends Grid implements BooksGridInterface
{
    /**
     * The name of the grid
     *
     * @var string
     */
    protected $name = 'Books';

    /**
     * List of buttons to be generated on the grid
     *
     * @var array
     */
    protected $buttonsToGenerate = [
        'create',
//        'refresh',
//        'export',
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
//		    "id" => [
//		        "label" => "ID",
//		        "filter" => [
//		            "enabled" => true,
//		            "operator" => "="
//		        ],
//		        "styles" => [
//		            "column" => "grid-w-10"
//		        ]
//		    ],
            "image" => [
                "raw" => true,
                "data" => function ($columnData, $columnName) {
                    return  '<img src="'.Books::find($columnData->id)->getImgUrl().'"/>';
                },
            ],
		    "name" => [
		        "search" => [
		            "enabled" => true
		        ],
		        "filter" => [
		            "enabled" => true,
		            "operator" => "="
		        ]
		    ],
		    "ISBN" => [
		        "search" => [
		            "enabled" => true
		        ],
		        "filter" => [
		            "enabled" => true,
		            "operator" => "="
		        ]
		    ],
		    "year" => [
		        "search" => [
		            "enabled" => true
		        ],
		        "filter" => [
		            "enabled" => true,
		            "operator" => "="
		        ]
		    ],
		    "Description" => [
		        "search" => [
		            "enabled" => true
		        ],
		        "filter" => [
		            "enabled" => true,
		            "operator" => "="
		        ]
		    ],
//		    "created_at" => [
//		        "sort" => false,
//		        "date" => "true",
//		        "filter" => [
//		            "enabled" => true,
//		            "type" => "date",
//		            "operator" => "<="
//		        ]
//		    ]
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
        $this->setIndexRouteName('showBooks');

        // crud support
        $this->setCreateRouteName('addBook');
        $this->setViewRouteName('viewBook');
        $this->setDeleteRouteName('deleteBook');

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
        $this->addRowButton('addToCollection', (new GenericButton([
            'name' => '',
            'icon' => 'fa fa-plus-square',
            'position' => 3,
            'class' => 'btn btn-outline-primary btn-sm grid-row-button show_modal_form show_modal_form',
            'showModal' => true,
            'gridId' => $this->getId(),
            'type' => static::$TYPE_ROW,
            'title' => 'Add Book To Collection',
            'url' => function ($gridName, $item) {
                return route('addTolLibrary' , ["id" =>$item->id ]).'&ref=book-grid';
            },
            'renderIf' => function ($gridName, $item) {
                return in_array('view', $this->buttonsToGenerate);
            }
        ]))) ;
        $this->addRowButton('edit', (new GenericButton([
            'name' => '',
            'icon' => 'fa fa-pencil-square-o',
            'position' => 2,
            'class' => 'btn btn-outline-primary btn-sm grid-row-button show_modal_form show_modal_form',
            'showModal' => true,
            'gridId' => $this->getId(),
            'type' => static::$TYPE_ROW,
            'title' => 'Edit Book',
            'url' => function ($gridName, $item) {
                return route('updateBook' , ["id" =>$item->id ]).'&ref=book-grid';
            },
            'renderIf' => function ($gridName, $item) {
                return in_array('view', $this->buttonsToGenerate);
            }
        ]))) ;

        // call `addRowButton` to add a row button
        // call `addToolbarButton` to add a toolbar button
        // call `makeCustomButton` to do either of the above, but passing in the button properties as an array
        // call `editToolbarButton` to edit a toolbar button
        $this->editToolbarButton('create', [
            'name' => 'Add Book',
            'title' => 'Add new Book',
        ]);
        // call `editRowButton` to edit a row button
        // editing the view button
//        dd(($this->buttons)["rows"]["test"]->__toString());
        $this->editRowButton('view', [
            'name' => '',
            'title' => 'View Book',
        ]);
        $this->editRowButton('delete', [
            'name' => '',
            'title' => 'Delete Book',
        ]);
        // call `editButtonProperties` to do either of the above. All the edit functions accept the properties as an array

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
