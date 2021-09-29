# Description

This plugin is an add-on for the awesome WP GraphQL

it buils on top of  WP GraphQL to add support for querying \ mutationing post metafield name `trx_addons_post_likes_count`

## Installing

1. Make sure that WP GraphQL is installed and activated first.
2. Upload this repo (or git clone) to your plugins folder and activate it.

## Usage

#### Querying

```graphql
{
  posts {
    nodes {
      likesCount
    }
  }
}
```

#### Mutation

```graphql
mutation {
  updatePostLike(input:{id: 1930}) {
    likes_count
  }
}
```

