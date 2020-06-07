<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GetAllIngredientsSorted
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        {
        // return \App\Ingredient::orderby('title', 'asc')->get();
        // return \App\Ingredient::whereHas('ingredient', function($q) {
        //                 $q->where('status','=','PUBLISHED');
        //            })->orderby('title', 'asc')->get();

        return \App\Recipeingredient::where('type', null)->with(['ingredient' => function ($query) {
            $query->whereHas('recipes', function($w) {
                $w->where('status','=','PUBLISHED');
            });
        }])->get();

        // $awardsDirty = new Collection($arr);
        // return $awardsDirty->unique();

    }
    }
}
