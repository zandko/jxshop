<?php

namespace models;

class Blog extends Model
{
    protected $tableName = 'blog';
    protected $fillable = ['title', 'content', 'is_show'];

}
