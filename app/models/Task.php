<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Task extends Eloquent
{
    use SoftDeletingTrait;

    protected $guarded = [];
}
