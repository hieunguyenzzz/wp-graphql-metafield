<?php // phpcs:ignore

/**
 * Plugin Name:     Add WPGraphQL Metafield
 * Plugin URI:      https://github.com/ashhitch/wp-graphql-yoast-seo
 * Description:     This is WPGraphQL addon
 * Author:          hieu nguyen
 * Author URI:      https://hieunguyen.dev
 * Version:         1.0.0
 *
 * @package         WP_Graphql_Metafield
 */

add_action( 'graphql_register_types', function() {
    register_graphql_field( 'Post', 'likes_count', [
       'type' => 'Integer',
       'description' => __( 'number of like', 'wp-graphql' ),
       'resolve' => function( $post ) {
         $color = get_post_meta( $post->ID, 'trx_addons_post_likes_count', true );
         return ! empty( $color ) ? $color : 0;
       }
    ] );

    register_graphql_mutation( 'updatePostLike', [

        # inputFields expects an array of Fields to be used for inputting values to the mutation
        'inputFields'         => [
            'id' => [
                'type' => 'Integer',
                'description' => __( 'id of post', 'your-textdomain' ),
            ]
        ],
    
        # outputFields expects an array of fields that can be asked for in response to the mutation
        # the resolve function is optional, but can be useful if the mutateAndPayload doesn't return an array
        # with the same key(s) as the outputFields
        'outputFields'        => [
            'likes_count' => [
                'type' => 'Integer',
                'description' => __( 'Description of the output field', 'your-textdomain' ),
                'resolve' => function( $payload, $args, $context, $info ) {
                               return isset( $payload['likes_count'] ) ? $payload['likes_count'] : null;
                }
            ]
        ],
    
        # mutateAndGetPayload expects a function, and the function gets passed the $input, $context, and $info
        # the function should return enough info for the outputFields to resolve with
        'mutateAndGetPayload' => function( $input, $context, $info ) {
            // Do any logic here to sanitize the input, check user capabilities, etc
            $exampleOutput = null;
            if ( ! empty( $input['id'] ) ) {
                $countLike = get_post_meta( $input['id'], 'trx_addons_post_likes_count', true );
                update_post_meta( $input['id'], 'trx_addons_post_likes_count', $countLike + 1);
                
            }
            return [
                'likes_count' => $countLike + 1,
            ];
        }
    ] );
  } );

  

