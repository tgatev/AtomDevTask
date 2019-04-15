<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Books extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ISBN', 'year', 'Description', 'image'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The validation rules related to the table
     *
     * @return array
     */
    public static function getValidationRules( $exclude_id = null )
    {
        return [
            'name' => ['required', 'string','min:5', 'max:100' ],
            'ISBN' => ['required', 'string', 'min:10','max:20',
                $exclude_id ?
                    Rule::unique('books', 'ISBN')->ignore($exclude_id) :
                    Rule::unique('books', 'ISBN') ],
            'year' => ['required','integer','min:0','max:'.(date('Y'))],
            'Description' => ['string', 'max:500' ],

            'image' => [
                $exclude_id == null ?  'required': null ,
                'image','mimes:jpeg,png,jpg,gif,svg','max:2048'
                /* not need in case of code paths
                , $exclude_id ?
                    Rule::unique('books', 'ISBM')->ignore($exclude_id) :
                    Rule::unique('books', 'ISBN')
                */
            ],
        ];
    }
}
