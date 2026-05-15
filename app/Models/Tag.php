<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'color'];

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }

    /** Tailwind bg class for the badge */
    public function badgeClass(): string
    {
        return match ($this->color) {
            'red'    => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
            'green'  => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
            'blue'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
            'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
            'pink'   => 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300',
            'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
            default  => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300',
        };
    }
}
