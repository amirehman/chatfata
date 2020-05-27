<?php

namespace App\GraphQL\Mutations;

use Illuminate\Http\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Recipe;

class RecipeMutation
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
    public function store($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $recipe = new Recipe();

        $recipe->title = $args['title'];
        $slug = str_slug($args['title']);
        $allrecipes = Recipe::where('slug', '=', $slug)->pluck('slug');

        if($allrecipes->count() == 0)
        {
           $recipe->slug = $slug;
        }else{
            $count = Recipe::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $recipe->slug = $count ? "{$slug}-{$count}" : $slug;
        }

        $recipe->body = $args['detail'];
        $recipe->difficulty = $args['difficulty'];
        $recipe->prep_time = $args['prep_time'];
        $recipe->image = $args['image'];
        $recipe->video = $args['url'];
        $recipe->user_id = 2;
        $recipe->status = 'DRAFT';
        $recipe->featured = 0;

        return $recipe->save();

    }
}
