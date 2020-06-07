<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SearchRecipes
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
        $search = $args['term'];
        $term = explode(' ', $search);

        if (!$args['term']) {
            return \App\Recipe::where('title', 'like', '%' . 'this is just a dummy text if you dont get any thing' . '%')->get();
        } else {
            for ($x = 0; $x < count($term); $x++) {
                return \App\Recipe::where([
                    ['title', 'like', '%' . $term[$x] . '%'],
                    ['status', '=', 'PUBLISHED'],
                ])
                    ->orWhere('body', 'like', '%' . $term[$x] . '%')
                    ->limit(8)->get();
            }
        }
    }
}
