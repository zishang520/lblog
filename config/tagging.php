<?php

return [
    // Datatype for primary keys of your models.
    // used in migrations only
    'primary_keys_type' => 'integer', // 'string' or 'integer'

    // 在保存标签之前通过此值传递的值
    'normalizer' => '\Conner\Tagging\Util::slug',

    // 传递标签的显示值（用于前端显示）
    'displayer' => '\Illuminate\Support\Str::title',

    // Database connection for Conner\Taggable\Tag model to use
    //'connection' => 'mysql',

    // When deleting a model, remove all the tags first
    'untag_on_delete' => true,

    // Auto-delete unused tags from the 'tags' database table (when they are used zero times)
    'delete_unused_tags' => true,

    // Model to use to store the tags in the database
    'tag_model' => App\Models\Tag::class,

    // Delimiter used within tags
    'delimiter' => '-',

    // Model to use for the relation between tags and tagged records
    'tagged_model' => App\Models\Tagged::class,
];
